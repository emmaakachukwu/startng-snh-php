<?php
include_once("lib/header.php");
require_once("functions/alert.php");
require_once("functions/redirect.php");

if ( !isset($_SESSION['loggedIn']) ) {
    redirect_to("login.php");
} else {
    $userObject = json_decode(file_get_contents("db/users/".$_SESSION['email'].'.json'));
}

?>

<h2>Patient's Dashboard</h2>
<p>LoggedIn User ID: <?php echo $_SESSION['loggedIn'].'. ' ?>
Welcome, <?php echo $userObject->first_name.' '.$userObject->last_name; ?>, You are logged in as (<?php echo $userObject->designation; ?>), and your ID is <?php echo $_SESSION['loggedIn'].'.'; ?> </p>
<p><b>Department: </b> <?php echo $userObject->department; ?> </p>
<p><b>Date of Registration: </b> <?php echo $userObject->registered_on; ?> </p>
<p><b>Date of last login: </b> <?php echo $userObject->lastlogin; ?> </p>
<hr>

<p>
    <?php
        print_alert();
    ?>
</p>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">What do you want to do?</h1>
    <p>
        <a class="btn btn-bg btn-outline-secondary" href="pay_bill.php">Pay Bill</a>
        <a class="btn btn-bg btn-outline-primary" href="book_appointment.php">Book Appointment</a>
    </p>
</div>
<hr>

<h3>Your transaction history</h3>

<?php
$transactions = scandir("db/appointments");
$user_transactions = [];
foreach($transactions as $key => $value){
    $data = json_decode(file_get_contents("db/appointments/".$value));
    if ( $data != null && $data->email == $_SESSION['email'] ) {
        array_push($user_transactions, $data);
    }
}

?>

<div class="container">
    <div class="row">
        <?php if ( count($user_transactions) < 1 ) { ?>
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">You do not have any transaction</h1>
            </div>
        <?php } else { ?>
            <table class="table table-responsive">
                <thead>
                    <th>S/N</th>
                    <th>Date of Transaction initiation</th>
                    <th>Date of Appointment</th>
                    <th>Time of Appointment</th>
                    <th>Nature of Appointment</th>
                    <th>Payment Status</th>
                </thead>

                <tbody>
                    <?php
                    $sn = 1;
                    foreach($user_transactions as $key => $value){ ?>
                        <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo date('d M, Y', strtotime($user_transactions[$key]->date_initiated)); ?></td>
                            <td><?php echo date('d M, Y', strtotime($user_transactions[$key]->date)); ?></td>
                            <td><?php echo date('h:m a', strtotime($user_transactions[$key]->time)); ?></td>
                            <td><?php echo $user_transactions[$key]->nature; ?></td>
                            <td><?php echo $user_transactions[$key]->status; ?></td>
                        </tr>
                    <?php $sn++; } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<?php
include_once("lib/footer.php");
?>