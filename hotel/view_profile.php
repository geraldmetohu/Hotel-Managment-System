<?php
// Vendos titullin e faqes
$title = "Profile";
// Përfshij skedarin e header-it
include('includes/header.html');
// Importo lidhjen me bazën e të dhënave
require('includes/hotel_connect.php');

// Kontrollo nëse sesionet 'user' dhe 'emp_id' nuk janë të vendosura
if (!isset($_SESSION['user']) && !isset($_SESSION['emp_id'])) {
    header('location: index.php'); // Ridrejto në faqen index.php
    exit(); // Dal nga skripti për të shmangur ekzekutimin e kodit vijues
}

if (isset($_SESSION['user'])) {
    // Nëse sesioni 'user' është i vendosur, merr të dhënat e përdoruesit nga tabela 'staf' duke përdorur ID-në e stafit të ruajtur në sesion
    $q = "SELECT * FROM staf WHERE staffID={$_SESSION['user']['staffID']}";
    $r = mysqli_query($dbc, $q);
    $row = mysqli_fetch_assoc($r);
} elseif (isset($_SESSION['emp_id'])) {
    // Përndryshe, nëse sesioni 'emp_id' është i vendosur, merr të dhënat e përdoruesit nga tabela 'staf' duke përdorur ID-në e stafit të ruajtur në sesion
    $q = "SELECT * FROM staf WHERE staffID={$_SESSION['emp_id']}";
    $r = mysqli_query($dbc, $q);
    $row = mysqli_fetch_assoc($r);
}

?>

<div class="page-header">
    <h1 id="amenities" class="text-center"> Your account </h1>
</div>
<!-- <div class="row"> -->
<div class="col-md-12">
    <div class="well">
        <div class="row">
            <div class=" col-md-4">
                <?php
                // Kontrollo nëse sesioni 'user' është i vendosur
                if (isset($_SESSION['user'])) {
                    $pictureUrl = $row['profile_pic'];
                } else {
                    $pictureUrl = "uploads/" . $row['profile_pic'];
                }
                ?>
                <img src="<?php echo $pictureUrl; ?>" style="width:350px; height:350px;" alt="" class="img-rounded img-responsive" />
            </div>
            <div class="info col-md-8">
                <h1>
                    <?php echo "  " . $row['fname'] . ' ' . $row['lname']; ?>
                </h1>
                <br>
                <small><cite title="Hotel Staff"> Hotel Staff<i class="glyphicon glyphicon-map-user">
                        </i></cite></small><br><br>
                <p>
                    <i class="glyphicon glyphicon-globe"></i> Tirana, Albania
                    <br /><br>
                    <i class="glyphicon glyphicon-envelope"></i>
                    <?php echo " " . $row['email']; ?>
                    <br /><br>
                    <i class="glyphicon glyphicon-earphone"></i>
                    <?php echo " " . $row['tel']; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
