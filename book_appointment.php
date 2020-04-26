<?php
include_once("lib/header.php");
require_once("functions/redirect.php");
require_once("functions/alert.php");
if ( !isset($_SESSION['loggedIn']) ) {
    redirect_to("login.php");
}

?>

<p>
    <?php
        print_alert();
    ?>
</p>

<div class="container">
    <div class="row col-6">
        <h3>Book Appointment </h3>
    </div>

    <div class="row col-6">
        <form method='POST' action='processappointment.php'>
            <p>
                <label>Date of Appointment</label><br/>
                <input 
                <?php 
                    if ( isset($_SESSION['date']) ) {
                        echo "value=" . $_SESSION['date'];
                    }
                ?>
                type='date' class="form-control" name='date' />
            </p>
            <p>
                <label>Time of appointment</label><br/>
                <input
                <?php 
                    if ( isset($_SESSION['time']) ) {
                        echo "value=" . $_SESSION['time'];
                    }
                ?>
                type='time' class="form-control" name='time' />
            </p>
            <p>
                <label>Nature of appointment</label><br/>
                <input
                <?php 
                    if ( isset($_SESSION['nature']) ) {
                        echo "value=" . $_SESSION['nature'];
                    }
                ?>
                type='text' class="form-control" name='nature' placeholder='Nature of appointment' />
            </p>
            <p>
                <label>Initial complaint</label><br/>
                <input
                <?php 
                    if ( isset($_SESSION['complaint']) ) {
                        echo "value=" . $_SESSION['complaint'];
                    }
                ?>
                type='text' class="form-control" name='complaint' placeholder='Initial complaint' />
            </p>
            <p>
                <label>Department you wish to book your appointment in</label><br/>
                <input
                <?php 
                    if ( isset($_SESSION['department']) ) {
                        echo "value=" . $_SESSION['department'];
                    }
                ?>
                type='text' class="form-control" name='department' placeholder='Department you wish to book your appointment in' />
            </p>
            
            <p>
                <button class="btn btn-sm btn-primary" type='submit'>Book Appointment</button>
            </p>
        </form>
    </div>
</div>