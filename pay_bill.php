<?php
    include_once("lib/header.php");
    require_once("functions/redirect.php");
    require_once("functions/alert.php");
    require_once("functions/email.php");

    function gen_txref() {
        $txref = "txref_";
        for ($i = 0; $i < 7; $i++) {
            $txref .= mt_rand(0, 6);
        }
        return $txref;
    }

    function update_user_status(){
        $email = $_SESSION['email'];
        $all_appointments = scandir("db/appointments");
        foreach($all_appointments as $key => $value){
            $data = json_decode(file_get_contents("db/appointments/".$value));
            if ( $data != null && $data->email == $email ) {
                $data->status = "Paid";
                $data->date_paid = date('d M, Y');

                unlink("db/appointments/".$value);
                file_put_contents("db/appointments/".$value, json_encode($data));
            }
        }

        // send email of a successful payment
        $subject = "Payment Notification";
        $message = "Your payment was successful";
        send_email($subject, $message, $email);
        
        set_alert('message', 'Payment Successfull');
    }

    if ( !isset($_SESSION['loggedIn']) ) {
        redirect_to("login.php");
    }

?>

<p>
    <?php
        print_alert();
    ?>
</p>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">How do you want to pay your bills?</h1>
    <p>
        <form method='POST' action=''>
            <button type='button' class="btn btn-bg btn-outline-secondary" value='Pay Now' id="submit" onClick="payWithRave()">Pay Now (Inline)</button>
            <button type='button' class="btn btn-bg btn-outline-primary" onClick='pay_standard()' >Pay Now (Standard)</button>
        <form>
    </p>
</div>

<script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script>
    const API_publicKey = "FLWPUBK_TEST-35d83979a55ee06404f2fdfcf4ae64bd-X";

    function payWithRave() {
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: "user@example.com",
            amount: 2000,
            customer_phone: "234099940409",
            currency: "NGN",
            txref: "rave-123456",
            meta: [{
                metaname: "flightID",
                metavalue: "AP1234"
            }],
            onclose: function() {},
            callback: function(response) {
                var txref = response.tx.txRef; // collect txRef returned and pass to a                  server page to complete status check.
                console.log("This is the response returned after a charge", response);
                if (
                    response.tx.chargeResponseCode == "00" ||
                    response.tx.chargeResponseCode == "0"
                ) {
                    <?php update_user_status(); ?>
                } else {
                    <?php set_alert('error', 'can error occured; retry'); ?>
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }

    // function pay_standard() {
    //     <?php
    //         $curl = curl_init();

    //         $customer_email = "user@example.com";
    //         $amount = 3000;  
    //         $currency = "NGN";
    //         $txref = "rave-29933838"; // ensure you generate unique references per transaction.
    //         $PBFPubKey = "FLWPUBK_TEST-35d83979a55ee06404f2fdfcf4ae64bd-X"; // get your public key from the dashboard.
    //         $redirect_url = "pay_bill.php";
    //         $payment_plan = "pass the plan id"; // this is only required for recurring payments.


    //         curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => json_encode([
    //             'amount'=>$amount,
    //             'customer_email'=>$customer_email,
    //             'currency'=>$currency,
    //             'txref'=>$gen_txref(),
    //             'PBFPubKey'=>$PBFPubKey,
    //             'redirect_url'=>$redirect_url,
    //             'payment_plan'=>$payment_plan
    //         ]),
    //         CURLOPT_HTTPHEADER => [
    //             "content-type: application/json",
    //             "cache-control: no-cache"
    //         ],
    //         ));

    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);

    //         if($err){
    //             // there was an error contacting the rave API
    //             set_alert('error', 'error in connection; check your network and retry');
    //             die();
    //         }

    //         $transaction = json_decode($response);

    //         if(!$transaction->data && !$transaction->data->link){
    //             // there was an error from the API
    //             set_alert('error', 'can error occured: ' . $transaction->message);
    //         } else {
    //             update_user_status();
    //         }

    //     ?>
    // }

</script>