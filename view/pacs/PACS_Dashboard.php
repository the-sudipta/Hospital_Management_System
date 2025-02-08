<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
//include '../Loader.php';

$Login_page = $routes['login'];
$pacs_dashboard = $routes["pacs_dashboard"];


$logout_controller = $backend_routes['logout_controller'];


require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';

@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}

$user_id = $_SESSION["user_id"];



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACS Dashboard</title>
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
        }

        #lineChart {
            height: 500px; /* Increase the height */
            width: 100%;
            margin-top: 20px;
        }


        .dashboard {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #161b22;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: width 0.3s ease;
        }

        .sidebar h2 {
            text-align: center;
            color: #58a6ff;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            padding: 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .menu li:hover, .menu li.active {
            background: #58a6ff;
            transform: scale(1.05);
            color: black;
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #161b22;
            border-radius: 10px;
        }

        .top-bar h1 {
            font-size: 24px;
        }

        .logout-btn {
            padding: 10px 20px;
            background: #ff5555;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background: #ff2222;
            transform: scale(1.1);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: #21262d;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(88, 166, 255, 0.3);
        }

        .card h3 {
            margin-bottom: 10px;
            color: #58a6ff;
        }

        .fun-section {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .fun-box {
            flex: 1;
            min-width: 200px;
            background: #21262d;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .fun-box:hover {
            background: #58a6ff;
            color: black;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: fixed;
                height: 100vh;
                left: -100%;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }
        }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>PACS Dashboard</h2>
        <ul class="menu">
            <li class="active" onclick="showContent('overview', this)">Overview</li>
            <li onclick="showContent('images', this)">View Images</li>
            <li onclick="showContent('reports', this)">Radiology Reports</li>
            <li onclick="showContent('schedule', this)">Manage Schedule</li>
            <li onclick="showContent('access-log', this)">Access Logs</li>
        </ul>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>

    <div class="content">
        <div class="top-bar">
            <h1>Welcome to PACS</h1>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>

        <div id="main-content">
            <div id="overview" class="section">
                <div class="card-container">
                    <div class="card">
                        <h3>Total Images</h3>
                        <p>1200+</p>
                    </div>
                    <div class="card">
                        <h3>Pending Reports</h3>
                        <p>35</p>
                    </div>
                    <div class="card">
                        <h3>Completed Reports</h3>
                        <p>220</p>
                    </div>
                </div>

                <div class="fun-section">
                    <div class="fun-box">💡 Quick Tip: Always verify report accuracy!</div>
                    <div class="fun-box">📌 Fun Fact: The first MRI scan was in 1977.</div>
                    <div class="fun-box">⏳ Current Server Load: %</div>
                    <div class="fun-box">🚀 Daily Scans Processed: 580</div>
                </div>
            </div>


            <div id="lineChart">

            </div>

        </div>
    </div>
</div>

<script>
    function showContent(section, element) {
        document.querySelectorAll(".section").forEach(el => el.style.display = "none");
        document.getElementById(section).style.display = "block";

        document.querySelectorAll(".menu li").forEach(li => li.classList.remove("active"));
        element.classList.add("active");
    }

    function logout() {
        alert("Logging out...");
        window.location.href = "login.html";
    }
</script>

<!-- Add Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Add Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    var SERVER_LOAD = 0; // Global server load variable

    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.createElement("canvas");
        document.getElementById("lineChart").appendChild(ctx);

        const serverLoadChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "Server Load (%)",
                    borderColor: "#58a6ff",
                    backgroundColor: "rgba(88, 166, 255, 0.2)",
                    data: [],
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: { display: true, text: "Time (seconds)" }
                    },
                    y: {
                        title: { display: true, text: "CPU Load (%)" },
                        min: 0,
                        max: 140
                    }
                }
            }
        });

        function getApproximateCPULoad() {
            const start = performance.now();
            let workloadFactor = (performance.now() % 200) + 50;
            let iterations = 1e6 + workloadFactor * 20000;

            for (let i = 0; i < iterations; i++) {
                Math.sqrt(i * workloadFactor) + Math.log(i + 1);
            }

            const end = performance.now();
            let cpuLoad = Math.min(100, Math.max(10, ((end - start) * workloadFactor) / 5));

            return cpuLoad.toFixed(2);
        }

        function fetchServerLoad() {
            SERVER_LOAD = getApproximateCPULoad(); // Update global server load

            // Update Chart
            if (serverLoadChart.data.labels.length >= 10) {
                serverLoadChart.data.labels.shift();
                serverLoadChart.data.datasets[0].data.shift();
            }

            serverLoadChart.data.labels.push(new Date().toLocaleTimeString());
            serverLoadChart.data.datasets[0].data.push(SERVER_LOAD);
            serverLoadChart.update();

            updateServerLoadText(); // Update text along with the graph
        }

        setInterval(fetchServerLoad, 5000); // Sync both updates every 5 seconds

    });

    function updateServerLoadText() {
        const serverLoadBox = document.querySelector(".fun-box:nth-child(3)");
        if (!serverLoadBox) return;

        serverLoadBox.innerHTML = `⏳ Current Server Load: ${SERVER_LOAD}%`;
    }

</script>

</body>
</html>

