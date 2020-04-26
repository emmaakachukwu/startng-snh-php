<?php
include_once("lib/header.php");
require("functions/alert.php");
if ( isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn']) ) {
    //redirect to dashboard
    header("Location: dashboard.php");
}

?>

<p>
    <?php
        print_alert();
    ?>
</p>

<h2>Login</h2>
<!-- <p>
    <?php
        // message();
    ?>
</p> -->

<form method='POST' action='processlogin.php'>
   

    <p>
        <label>Email</label><br/>
        <input 
        <?php 
            if ( isset($_SESSION['email']) ) {
                echo "value=" . $_SESSION['email'];
            }
        ?>
        type='email' name='email' placeholder='Email'/>
    </p>
    <p>
        <label>Password</label><br/>
        <input type='password' name='password' placeholder='Password'/>
    </p>
    
    <p>
        <button type='submit'>Login</button>
    </p>

    <p>
        <a href="forgot.php">Forgot Password</a>
    </p>
</form>

<?php
require_once("lib/footer.php");
?>