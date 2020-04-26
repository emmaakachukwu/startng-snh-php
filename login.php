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

<div class="container">
    <div class="row col-6">
        <h3>Login</h3>
    </div>

    <div class="row col-6">
        <form method='POST' action='processlogin.php'>
            <p>
                <label>Email</label><br/>
                <input 
                <?php 
                    if ( isset($_SESSION['email']) ) {
                        echo "value=" . $_SESSION['email'];
                    }
                ?>
                type='email' class="form-control" name='email' placeholder='Email'/>
            </p>
            <p>
                <label>Password</label><br/>
                <input type='password' class="form-control" name='password' placeholder='Password'/>
            </p>
            
            <p>
                <button class="btn btn-sm btn-primary" type='submit'>Login</button>
            </p>

            <p>
                <a href="forgot.php">Forgot Password</a>
                <a href="register.php">Don't have an account? Register</a>
            </p>
        </form>
    </div>
</div>



<?php
require_once("lib/footer.php");
?>