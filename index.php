<?php

global $routes;
require './routes.php';

session_start();
$login_page = $routes['login'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Hospital Management System</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Beautiful Background */
        body {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }

        /* Centered Loading Container */
        .welcome-container {
            text-align: center;
            color: white;
            max-width: 500px;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0px 8px 20px rgba(255, 65, 108, 0.3);
            animation: fadeIn 1.2s ease-in-out;
        }

        /* Fade-in Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Title Styling */
        .welcome-container h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ffeb3b, #ff9800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-container p {
            font-size: 16px;
            opacity: 0.8;
            margin-bottom: 20px;
        }

        /* Glowing Progress Bar */
        .progress-bar {
            width: 100%;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-inner {
            width: 0%;
            height: 12px;
            background: linear-gradient(135deg, #ffeb3b, #ff9800);
            border-radius: 30px;
            transition: width 0.1s ease-in-out;
            box-shadow: 0px 0px 10px rgba(255, 165, 0, 0.8);
        }

        /* Progress Text */
        .progress-text {
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* Loading Dots Animation */
        .loading-dots::after {
            content: "";
            display: inline-block;
            animation: dots 1.5s infinite;
        }

        @keyframes dots {
            0% { content: "."; }
            33% { content: ".."; }
            66% { content: "..."; }
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <h1><center>Welcome to <br>Hospital Management System</center></h1>
    <p class="loading-text">Loading your experience<span class="loading-dots"></span></p>

    <div class="progress-bar">
        <div class="progress-bar-inner" id="progress-bar-inner"></div>
    </div>

    <div class="progress-text" id="progress-text">0%</div>
</div>

<script>
    // JavaScript for progress bar animation
    window.onload = function() {
        var progressBar = document.getElementById("progress-bar-inner");
        var progressText = document.getElementById("progress-text");
        var percentage = 0;

        var interval = setInterval(function() {
            percentage += 1;
            progressBar.style.width = percentage + "%";
            progressText.textContent = percentage + "%";

            if (percentage >= 100) {
                clearInterval(interval);
                setTimeout(function() {
                    window.location.href = "<?php echo $login_page; ?>"; // Redirect
                }, 500);
            }
        }, 40);
    };
</script>

</body>
</html>
