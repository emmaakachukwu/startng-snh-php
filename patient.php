<?php
include_once("lib/header.php");
if ( !isset($_SESSION['loggedIn']) ) {
    //redirect to dashboard
    header("Location: login.php");
}

?>

<h3>Patient's Dashboard</h3>
<p>LoggedIn User ID: <?php echo $_SESSION['loggedIn'].'. ' ?>
Welcome, <?php echo $_SESSION['fullname']; ?>, You are logged in as (<?php echo $_SESSION['role'] ?>), and your ID is <?php echo $_SESSION['loggedIn'].'.'; ?> </p>
<p><b>Department: </b> <?php echo $_SESSION['department']; ?> </p>
<p><b>Date of Registration: </b> <?php echo $_SESSION['registered_on']; ?> </p>
<p><b>Date of last login: </b> <?php echo $_SESSION['lastlogin']; ?> </p>


<?php
include_once("lib/footer.php");
?>