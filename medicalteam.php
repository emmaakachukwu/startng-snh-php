<?php
include_once("lib/header.php");
require_once("functions/redirect.php");

if ( !isset($_SESSION['loggedIn']) ) {
    redirect_to("login.php");
} else {
    $userObject = json_decode(file_get_contents("db/users/".$_SESSION['email'].'.json'));
}

?>

<h3>Medical Team's Dashboard</h3>

<p>LoggedIn User ID: <?php echo $_SESSION['loggedIn'].'. ' ?>
Welcome, <?php echo $userObject->first_name.' '.$userObject->last_name; ?>, You are logged in as (<?php echo $userObject->designation; ?>), and your ID is <?php echo $_SESSION['loggedIn'].'.'; ?> </p>
<p><b>Department: </b> <?php echo $userObject->department; ?> </p>
<p><b>Date of Registration: </b> <?php echo $userObject->registered_on; ?> </p>
<p><b>Date of last login: </b> <?php echo $userObject->lastlogin; ?> </p>
<hr>

<?php
$all_appointments = scandir("db/appointments");
$dept_appointments = [];
foreach($all_appointments as $key => $value){
    $data = json_decode(file_get_contents("db/appointments/".$value));
    if ( $data != null && $userObject->department == $data->department ) {
        array_push($dept_appointments, $data);
    }
}
if ( count($dept_appointments) < 1 ) {
?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">You have no pending appointments</h1>
    </div>
<?php } else {
?>
    <div class="container">
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <th>S/N</th>
                    <th>Patient's Name</th>
                    <th>Date of Appoitment</th>
                    <th>Time of appointment</th>
                    <th>Nature of appointment</th>
                    <th>Initial complaint</th>
                    <th>Payment Status</th>
                </thead>

                <tbody>
                    <?php
                    $sn = 1;
                    foreach($dept_appointments as $key => $value){ ?>
                        <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo ucfirst($dept_appointments[$key]->fullname); ?></td>
                            <td><?php echo date('d M, Y', strtotime($dept_appointments[$key]->date)); ?></td>
                            <td><?php echo date('h:m a', strtotime($dept_appointments[$key]->time)); ?></td>
                            <td><?php echo $dept_appointments[$key]->nature; ?></td>
                            <td><?php echo $dept_appointments[$key]->complaint; ?></td>
                            <td><?php echo $dept_appointments[$key]->status; ?></td>
                        </tr>
                    <?php $sn++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    
<?php }

?>

<?php
include_once("lib/footer.php");
?>