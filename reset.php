<?php
include_once("lib/header.php");
require_once("functions/alert.php");
require_once("functions/user.php");

if ( !is_user_loggedIn() && !is_token_set() ) {
    $_SESSION['error'] = "You are not authorized to view that page";
    header("Location: login.php");
}

?>
<div class="container">
    <div class="row">
        <h3>Reset password</h3>
    </div>
    <div class="row">
        <p>Reset Password associated with your account</p>
    </div>

    <div class="row">
        <form action="processreset.php" method='POST'>
            <p>
                <?php
                    print_alert();
                ?>
            </p>

            <?php 
                if ( !$_SESSION['loggedIn'] ) { ?>
                <input 
                    <?php
                        if ( is_token_set_in_session() ) {
                            echo "value='" . $_SESSION['token'] . "' ";
                        } else {
                            echo "value='" . $_GET['token'] . "' ";
                        }
                    ?>
                type='hidden' class='form-control' name='token' />
            <?php } ?>
            
            <p>
                <label>Email</label><br/>
                <input class='form-control' type='email' name='email' placeholder='Email'/>
            </p>

            <p>
                <label>Enter new Password</label><br/>
                <input class='form-control' type='password' name='password' placeholder='Password'/>
            </p>

            <p>
                <button type='submit' class='btn btn-sm btn-primary'>Reset Password</button>
            </p>
        </form>
    </div>
</div>




<?php
require_once("lib/footer.php");
?>