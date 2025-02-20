

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="//s3-us-west-2.amazonaws.com/s.cdpn.io/157670/">
    <style>
        html {
            height: 100%;
        }

        body {
            height: 100%;
            background: url("https://wallpapercave.com/wp/6SLzBEY.jpg") no-repeat left top;
            background-size: cover;
            overflow: hidden;
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
        }

        .text h1 {
            color: #011718;
            margin-top: -200px;
            font-size: 15em;
            text-align: center;
            text-shadow: -5px 5px 0px rgba(0, 0, 0, 0.7), -10px 10px 0px rgba(0, 0, 0, 0.4), -15px 15px 0px rgba(0, 0, 0, 0.2);
            font-family: monospace;
            font-weight: bold;
        }

        .text h2 {
            color: black;
            font-size: 5em;
            text-shadow: -5px 5px 0px rgba(0, 0, 0, 0.7);
            text-align: center;
            margin-top: -150px;
            font-family: monospace;
            font-weight: bold;
        }

        .text h3 {
            color: white;
            margin-left: 30px;
            font-size: 2em;
            text-shadow: -5px 5px 0px rgba(0, 0, 0, 0.7);
            margin-top: -40px;
            font-family: monospace;
            font-weight: bold;
        }

        .torch {
            margin: -150px 0 0 -150px;
            width: 200px;
            height: 200px;
            box-shadow: 0 0 0 9999em #000000f7;
            opacity: 1;
            border-radius: 50%;
            position: fixed;
            background: rgba(0, 0, 0, 0.3);
            pointer-events: none; /* Allows clicks to pass through */
        }
        .torch:after {
            content: "";
            display: block;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            box-shadow: inset 0 0 40px 2px #000, 0 0 20px 4px rgba(13, 13, 10, 0.2);
        }
    </style>

    <!-- Add this inside <style> -->
    <style>
        .button-container {
            margin-top: 50px;
            text-align: center;
        }

        .glow-button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 1.2em;
            font-family: monospace;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
            background: #011718;
            border: 2px solid #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
            z-index: 100; /* Ensures it's on top */
        }

        .glow-button:hover {
            background: #fff;
            color: #011718;
            border-color: #011718;
            box-shadow: 0 0 20px rgba(255, 255, 255, 1);
            transform: scale(1.1);
        }

        .glow-button:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.2);
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }

        .glow-button:hover:after {
            transform: scaleX(1);
        }
    </style>

</head>
<body>
<!-- partial:index.partial.html -->
<div class="text">
    <h1>404</h1>
    <h2>Uh, Ohh</h2>
    <h3>Sorry we cant find what you are looking for 'cuz its so dark in here</h3>

    <!-- Add this inside <body>, below <h3> -->
    <div class="button-container">
        <button onclick="window.history.go(-1)" class="glow-button">Go Back</button>
    </div>
</div>
<div class="torch"></div>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script><script  src="./script.js"></script>
<script>
    $(document).mousemove(function (event) {
        $('.torch').css({
            'top': event.pageY,
            'left': event.pageX
        });
    });
</script>
</body>
</html>

