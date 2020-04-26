<?php
include_once("lib/header.php");
require("functions/alert.php");
if ( isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn']) ) {
    //redirect to dashboard
    header("Location: dashboard.php");
}

?>
<div class="container">
    <div class="row col-6">
        <h3>Register</h3>
    </div>
    <div class="row col-6">
        <p><strong>Welcome, please register</strong></p>
    </div>
    <div class="row col-6">
        <p>All fields are required</p>
    </div>
    <div class="row col-6">
        <form method='POST' action='processregister.php'>
            <p>
                <?php
                    print_alert();
                ?>
            </p>

            <p>
                <label>First Name</label><br/>
                <input 
                <?php 
                    if ( isset($_SESSION['first_name']) ) {
                        echo "value=" . $_SESSION['first_name'];
                    }
                ?>
                type='text' class="form-control" name='first_name' placeholder='First Name'/>
            </p>
            <p>
                <label>Last Name</label><br/>
                <input
                <?php 
                    if ( isset($_SESSION['last_name']) ) {
                        echo "value=" . $_SESSION['last_name'];
                    }
                ?>
                type='text' class="form-control" name='last_name' placeholder='Last Name'/>
            </p>
            <p>
                <label>Email</label><br/>
                <input 
                <?php 
                    if ( isset($_SESSION['email']) ) {
                        echo "value=" . $_SESSION['email'];
                    }
                ?>
                type='text' class="form-control" name='email' placeholder='Email'/>
            </p>
            <p>
                <label>Password</label><br/>
                <input class="form-control" type='password' name='password' placeholder='Password'/>
            </p>
            <p>
                <label>Gender</label><br/>
                <select name='gender' class="form-control">
                    <option value=''>Select One</option>
                    <option
                    <?php
                        if ( isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female' ) {
                            echo "selected";
                        }
                    ?>
                    >Female</option>
                    <option
                    <?php
                        if ( isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male' ) {
                            echo "selected";
                        }
                    ?>
                    >Male</option>
                </select>
            </p>
            <p>
                <label>Designation</label><br/>
                <select name='designation' class="form-control">
                    <option value=''>Select One</option>
                    <option
                    <?php
                        if ( isset($_SESSION['designation']) && $_SESSION['designation'] == 'Medical Team (MT)' ) {
                            echo "selected";
                        }
                    ?>
                    >Medical Team (MT)</option>
                    <option
                    <?php
                        if ( isset($_SESSION['designation']) && $_SESSION['designation'] == 'Patient' ) {
                            echo "selected";
                        }
                    ?>
                    >Patient</option>
                </select>
            </p>
            <p>
                <label>Department</label><br/>
                <input 
                <?php 
                    if ( isset($_SESSION['department']) ) {
                        echo "value=" . $_SESSION['department'];
                    }
                ?>
                type='text' class="form-control" name='department' placeholder='Department'/>
            </p>
            <p>
                <button class="btn btn-success" type='submit'>Register</button>
            </p>
            <p>
                <a href="forgot.php">Forgot Password</a>
                <a href="login.php">Already have an account? Login</a>
            </p>
        </form>
    </div>
</div>
<?php
require_once("lib/footer.php");
?>