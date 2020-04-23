<?php
include_once("lib/header.php");
require("functions/alert.php");
?>

<h3>Forgot password</h3>
<p>Provide the email address associated with your account</p>

<form action="processforgot.php" method='POST'>
    <p>
        <?php
            print_alert();
        ?>
    </p>

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
        <button type='submit'>Send reset code</button>
    </p>
</form>

<?php
require_once("lib/footer.php");
?>