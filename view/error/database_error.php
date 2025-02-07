<?php

global $routes, $backend_routes;
require '../../routes.php';


@session_start();

$database_error = "";
$logout_controller = $backend_routes["logout_controller"];



if(isset($_SESSION['database_error']) && isset($_SESSION['error_location'])){
    $database_error = $_SESSION['database_error'];
}else{
    header("Location: {$logout_controller}");
}



?>


<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="../css/database_error/style.css">


</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">
    <div class="error">
        <h1>500</h1>
        <h2>error</h2>
        <p><b>Ohh No! <span style="color: #ff2e00; "><?php echo $_SESSION['error_location']; ?></span> issue. Call your Software Engineer immediately.</b> <br><br> Issue : <p style="color: #ff2e00;"><?php echo $database_error; ?></p></p>
    </div>
    <div class="stack-container">
        <div class="card-container">
            <div class="perspec" style="--spreaddist: 125px; --scaledist: .75; --vertdist: -25px;">
                <div class="card">
                    <div class="writing">
                        <div class="topbar">
                            <div class="red"></div>
                            <div class="yellow"></div>
                            <div class="green"></div>
                        </div>
                        <div class="code">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="perspec" style="--spreaddist: 100px; --scaledist: .8; --vertdist: -20px;">
                <div class="card">
                    <div class="writing">
                        <div class="topbar">
                            <div class="red"></div>
                            <div class="yellow"></div>
                            <div class="green"></div>
                        </div>
                        <div class="code">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="perspec" style="--spreaddist:75px; --scaledist: .85; --vertdist: -15px;">
                <div class="card">
                    <div class="writing">
                        <div class="topbar">
                            <div class="red"></div>
                            <div class="yellow"></div>
                            <div class="green"></div>
                        </div>
                        <div class="code">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="perspec" style="--spreaddist: 50px; --scaledist: .9; --vertdist: -10px;">
                <div class="card">
                    <div class="writing">
                        <div class="topbar">
                            <div class="red"></div>
                            <div class="yellow"></div>
                            <div class="green"></div>
                        </div>
                        <div class="code">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="perspec" style="--spreaddist: 25px; --scaledist: .95; --vertdist: -5px;">
                <div class="card">
                    <div class="writing">
                        <div class="topbar">
                            <div class="red"></div>
                            <div class="yellow"></div>
                            <div class="green"></div>
                        </div>
                        <div class="code">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="perspec" style="--spreaddist: 0px; --scaledist: 1; --vertdist: 0px;">
                <div class="card">
                    <div class="writing">
                        <div class="topbar">
                            <div class="red"></div>
                            <div class="yellow"></div>
                            <div class="green"></div>
                        </div>
                        <div class="code">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- partial -->
<script src="../js/database_error/script.js"></script>

</body>
</html>
