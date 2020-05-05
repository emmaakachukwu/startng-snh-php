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

<h2>Super Admin's Dashboard</h2>
<p>LoggedIn User ID: <?php echo $_SESSION['loggedIn'].'. ' ?>
Welcome, <?php echo $userObject->first_name.' '.$userObject->last_name; ?>, You are logged in as (<?php echo $userObject->designation; ?>), and your ID is <?php echo $_SESSION['loggedIn'].'.'; ?> </p>
<p><b>Department: </b> <?php echo $userObject->department; ?> </p>
<p><b>Date of Registration: </b> <?php echo $userObject->registered_on; ?> </p>
<p><b>Date of last login: </b> <?php echo $userObject->lastlogin; ?> </p>
<hr>

<?php
$all_users = scandir("db/users");
$medicalteam = [];
$patients = [];
foreach($all_users as $key => $value){
    $data = json_decode(file_get_contents("db/users/".$value));
    if ( $data != null && $data->designation == "Medical Team (MT)" ) {
        array_push($medicalteam, $data);
    } else if ( $data != null && $data->designation == "Patient" ) {
        array_push($patients, $data);
    }
}

?>

<div class="container">
    <div class="row">
        <h3>Register User</h3>
    </div>
    <div class="row">
        <form method='POST' action="processregister_superadmin.php">
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
                <button class="btn btn-sm btn-success" type='submit'>Register User</button>
            </p>
        </form>
    </div>
    <br>
    <div class="row">
        <h3>Staff List</h3>
        <?php if ( count($medicalteam) < 1 ) { ?>
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">You have no registered staff</h1>
            </div>
        <?php } else { ?>
            <table class="table table-responsive">
                <thead>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Gender</th>
                    <th>Department</th>
                    <th>Date of registration</th>
                </thead>

                <tbody>
                    <?php
                    $sn = 1;
                    foreach($medicalteam as $key => $value){ ?>
                        <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo ucfirst($medicalteam[$key]->first_name).' '.ucfirst($medicalteam[$key]->last_name); ?></td>
                            <td><?php echo $medicalteam[$key]->email; ?></td>
                            <td><?php echo $medicalteam[$key]->gender; ?></td>
                            <td><?php echo $medicalteam[$key]->department; ?></td>
                            <td><?php echo $medicalteam[$key]->registered_on; ?></td>
                        </tr>
                    <?php $sn++; } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <br>
    <div class="row">
        <h3>Patient List</h3>
        <?php if ( count($patients) < 1 ) { ?>
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">You have no registered patient</h1>
        </div>
        <?php } else { ?>
            <table class="table table-responsive">
                <thead>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Gender</th>
                    <th>Department</th>
                    <th>Date of registration</th>
                </thead>

                <tbody>
                    <?php
                    $sn = 1;
                    foreach($patients as $key => $value){ ?>
                        <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo ucfirst($patients[$key]->first_name).' '.ucfirst($patients[$key]->last_name); ?></td>
                            <td><?php echo $patients[$key]->email; ?></td>
                            <td><?php echo $patients[$key]->gender; ?></td>
                            <td><?php echo $patients[$key]->department; ?></td>
                            <td><?php echo $patients[$key]->registered_on; ?></td>
                        </tr>
                    <?php $sn++; } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <br>
    <div class="row">
        <h3>Appointments</h3>
        <?php
            $all_appointments = scandir("db/appointments");
            $appointments = [];
            foreach( $all_appointments as $key => $value ) {
                $data = json_decode(file_get_contents("db/appointments/".$value));
                $data ? array_push($appointments, $data) : "";
            }

            if ( !$appointments ) { ?>
                <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                    <h1 class="display-4">You have no appointments</h1>
                </div>
            <?php } else { ?>
                <table class="table table-responsive">
                    <thead>
                        <th>S/N</th>
                        <th>Patient's Name</th>
                        <th>Date of Appointment</th>
                        <th>Time of appointment</th>
                        <th>Nature of appointment</th>
                        <th>Initial complaint</th>
                        <th>Payment Status</th>
                    </thead>

                    <tbody>
                        <?php
                        $sn = 1;
                        foreach($appointments as $key => $value){ ?>
                            <tr>
                                <td><?php echo $sn; ?></td>
                                <td><?php echo $appointments[$key]->fullname; ?></td>
                                <td><?php echo date('d M, Y', strtotime($appointments[$key]->date)); ?></td>
                                <td><?php echo date('h:m a', strtotime($appointments[$key]->time)); ?></td>
                                <td><?php echo $appointments[$key]->nature; ?></td>
                                <td><?php echo $appointments[$key]->complaint; ?></td>
                                <td><?php echo $appointments[$key]->status; ?></td>
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