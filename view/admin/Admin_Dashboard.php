<?php

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Circular Navigation Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #0d1117;
            color: #c9d1d9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .circle-nav {
            position: relative;
            width: 350px;
            height: 350px;
            background: #161b22;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 15px rgba(88, 166, 255, 0.3);
        }

        .circle-nav .nav-item {
            position: absolute;
            width: 60px;
            height: 60px;
            background: #21262d;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .circle-nav .nav-item:hover {
            transform: scale(1.5);
            background: #58a6ff;
        }

        .circle-nav .nav-item span {
            display: none;
            position: absolute;
            top: 75px;
            background: #58a6ff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        .circle-nav .nav-item:hover span {
            display: block;
        }

        .nav-item:nth-child(1) { top: 20px; left: 50%; transform: translateX(-50%); }
        .nav-item:nth-child(2) { top: 80px; left: 80px; }
        .nav-item:nth-child(3) { top: 50%; left: 20px; transform: translateY(-50%); }
        .nav-item:nth-child(4) { bottom: 80px; left: 80px; }
        .nav-item:nth-child(5) { bottom: 20px; left: 50%; transform: translateX(-50%); }
        .nav-item:nth-child(6) { bottom: 80px; right: 80px; }
        .nav-item:nth-child(7) { top: 50%; right: 20px; transform: translateY(-50%); }
        .nav-item:nth-child(8) { top: 80px; right: 80px; }
    </style>
</head>
<body>
<div class="circle-nav">
    <div class="nav-item"><span>Home</span>🏠</div>
    <div class="nav-item"><span>Profile</span>👤</div>
    <div class="nav-item"><span>Settings</span>⚙️</div>
    <div class="nav-item"><span>Logout</span>🚪</div>
    <div class="nav-item"><span>Dashboard</span>📊</div>
    <div class="nav-item"><span>Messages</span>💬</div>
    <div class="nav-item"><span>Notifications</span>🔔</div>
    <div class="nav-item"><span>Help</span>❓</div>
</div>
</body>
</html>




