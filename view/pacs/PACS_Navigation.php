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
            <li class="active" onclick="loadPage('./PACS_Dashboard.php', this)">Overview</li>
            <li onclick="loadPage('view_images.php', this)">View Images</li>
            <li onclick="loadPage('reports.php', this)">Radiology Reports</li>
            <li onclick="loadPage('schedule.php', this)">Manage Schedule</li>
            <li onclick="loadPage('access_logs.php', this)">Access Logs</li>
        </ul>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>

    <div class="content">
        <div class="top-bar">
            <h1>Welcome to PACS</h1>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>

        <div id="main-content">
            <!-- Dashboard content will be loaded here dynamically -->
        </div>
    </div>
</div>

<script>
    function loadPage(page, element) {
        fetch(page)
            .then(response => response.text())
            .then(data => {
                document.getElementById("main-content").innerHTML = data;
                document.querySelectorAll(".menu li").forEach(li => li.classList.remove("active"));
                element.classList.add("active");
            })
            .catch(error => console.error('Error loading page:', error));
    }

    function logout() {
        alert("Logging out...");
        window.location.href = "login.html";
    }

    // Load the default page on startup
    window.onload = function() {
        loadPage('dashboard.php', document.querySelector(".menu li.active"));
    };

    window.onload = function() {
        let defaultTab = document.querySelector(".menu li.active");
        loadPage('./PACS_Dashboard.php', defaultTab);
    };
</script>

</body>
</html>
