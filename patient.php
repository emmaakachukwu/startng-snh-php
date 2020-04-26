<?php
include_once("lib/header.php");
require_once("functions/alert.php");
if ( !isset($_SESSION['loggedIn']) ) {
    //redirect to dashboard
    header("Location: login.php");
}

?>

<h2>Patient's Dashboard</h2>
<p>LoggedIn User ID: <?php echo $_SESSION['loggedIn'].'. ' ?>
Welcome, <?php echo $_SESSION['fullname']; ?>, You are logged in as (<?php echo $_SESSION['role'] ?>), and your ID is <?php echo $_SESSION['loggedIn'].'.'; ?> </p>
<p><b>Department: </b> <?php echo $_SESSION['department']; ?> </p>
<p><b>Date of Registration: </b> <?php echo $_SESSION['registered_on']; ?> </p>
<p><b>Date of last login: </b> <?php echo $_SESSION['lastlogin']; ?> </p>
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


<?php
include_once("lib/footer.php");
?>