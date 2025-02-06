<?php

global $routes, $backend_routes, $image_routes;
require '../routes.php';

$error_message = "";
$loginController_file = $backend_routes['login_controller'];
$logo = $image_routes['user_icon_background_less'];

// Message from Backend
if (isset($_GET['message'])) {
    $error_message = htmlspecialchars($_GET['message']);
    $show_backend_error_modal = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hospital Management System - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: radial-gradient(circle, #1a1a1a, #000000);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Glassmorphism Card */
        .wrapper {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            box-shadow: 0px 10px 30px rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            width: 350px;
            position: relative;
            animation: fadeIn 1.2s ease-in-out;
        }

        /* Fade In */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Logo */
        .logo img {
            width: 90px;
            margin-bottom: 15px;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            color: white;
            /*background: linear-gradient(135deg, #ff4b2b, #ff416c);*/
            padding: 10px;
            border-radius: 50px;
            display: inline-block;
            /*box-shadow: 0px 5px 15px rgba(255, 77, 77, 0.4);*/
        }

        /* Input Fields */
        .form-field {
            margin: 15px 0;
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            color: white;
        }

        .form-field input {
            border: none;
            background: transparent;
            outline: none;
            flex: 1;
            padding: 8px;
            color: white;
            font-size: 16px;
        }

        .form-field span {
            color: white;
            padding-left: 10px;
        }

        .form-field:focus-within {
            border-color: #ff416c;
            box-shadow: 0px 0px 15px rgba(255, 65, 108, 0.7);
        }

        /* Login Button */
        .btn {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            cursor: pointer;
            box-shadow: 0px 5px 15px rgba(255, 77, 77, 0.3);
            transition: all 0.3s ease-in-out;
            margin-top: 20px;
            width: 100%;
        }

        .btn:hover {
            background: linear-gradient(135deg, #ff2e00, #e6005c);
            box-shadow: 0px 8px 20px rgba(255, 77, 77, 0.6);
            transform: scale(1.05);
        }

        /* Register Link */
        .fs-6 {
            color: white;
            margin-top: 15px;
        }

        .fs-6 a {
            color: #ff416c;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s;
        }

        .fs-6 a:hover {
            color: #ff2e00;
        }

        /* Validation Messages */
        /* General Alert Box */
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 350px;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
            display: none;
            font-family: 'Poppins', sans-serif;
            animation: fadeInSlide 0.5s ease-in-out;
        }

        /* Fade-In & Slide Animation */
        @keyframes fadeInSlide {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* User Input Error - Red & Bold */
        #validationModal {
            background: rgba(255, 208, 0, 0.2);
            color: white;
            border-left: 5px solid #ffcc00;
            backdrop-filter: blur(8px);
        }

        /* Backend Error - Yellow & Warn-Like */
        #backendValidationModal {
            background: rgba(255, 0, 0, 0.2);
            color: white;
            border-left: 5px solid #ff4b2b;
            backdrop-filter: blur(8px);
        }

        /* Close Button */
        .alert span {
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            position: absolute;
            top: 5px;
            right: 10px;
            transition: transform 0.3s ease;
        }

        .alert span:hover {
            transform: scale(1.2);
        }

        /* Alert Text */
        .alert p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }


    </style>

    <script>
        function showModal(message) {
            document.getElementById("validationMessage").innerHTML = message;
            document.getElementById("validationModal").style.display = "block";
        }

        function close_modal() {
            document.getElementById("validationModal").style.display = "none";
        }

        function validateForm() {
            var email = document.getElementById("login_email").value;
            var password = document.getElementById("login_password").value;

            if (email === "") {
                showModal("Email is Required");
                return false;
            }

            if (password === "") {
                showModal("Password is Required");
                return false;
            }

            return true;
        }

        window.onload = function () {
            var errorMessage = "<?php echo addslashes($error_message); ?>";
            if (errorMessage.trim() !== "") {
                document.getElementById('backendValidationModal').style.display = 'block';
            }
        };

        function close_backend_modal() {
            document.getElementById("backendValidationModal").style.display = "none";
        }
    </script>

</head>
<body>

<!-- Validation Modal -->
<div id="validationModal" class="alert">
    <span onclick="close_modal();">&times;</span>
    <p id="validationMessage"></p>
</div>

<!-- Backend Validation Modal -->
<div id="backendValidationModal" class="alert">
    <span onclick="close_backend_modal();">&times;</span>
    <p id="backendValidationMessage"><?php echo $error_message; ?></p>
</div>

<!-- Login Form -->
<div class="wrapper">
    <div class="logo">
        <img src="<?php echo $logo;?>" alt="">
    </div>
    <div class="text-center mt-4 name">Login</div>
    <form action="<?php echo $loginController_file; ?>" method="post" id="login_form" onsubmit="return validateForm();">
        <div class="form-field">
            <span class="far fa-user"></span>
            <input type="text" name="email" id="login_email" placeholder="Email">
        </div>
        <div class="form-field">
            <span class="fas fa-key"></span>
            <input type="password" name="password" id="login_password" placeholder="Password">
        </div>
        <button class="btn">Login</button>
    </form>
    <div class="text-center fs-6">
<!--        Don't Have an Account? <a href="--><?php //echo ""; ?><!--">Register</a>-->
    </div>
</div>

</body>
</html>
