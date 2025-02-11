<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
//include '../Loader.php';

// Navigation Routes Frontend
$Login_page = $routes['login'];
$ris_dashboard = $routes["ris_dashboard"];
$ris_all_reports = $routes["ris_all_reports"];
$ris_all_schedule = $routes["ris_all_schedules"];
$ris_create_report = $routes["ris_create_report"];
$ris_create_schedule = $routes["ris_create_schedule"];
$ris_single_report = $routes["ris_single_report"];
$ris_single_schedule = $routes["ris_single_schedule"];





// Backend Routes
$logout_controller = $backend_routes['logout_controller'];


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}


// Gather Necessary Data
$user_id = $_SESSION["user_id"];

$reportCounts = totalReports();
$scheduleCount = getScheduleCount();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: linear-gradient(45deg, #161b22, #0d1117);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .navbar h1 {
            color: #58a6ff;
            font-size: 24px;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            position: absolute;
            right: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: #c9d1d9;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 20px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .nav-links a:hover {
            background: #58a6ff;
            color: black;
            transform: scale(1.1);
        }

        .navbar .nav-links .active {
            background: #58a6ff;
            color: black;
            transform: scale(1.1);
        }


        .dashboard {
            display: flex;
            height: 100%;
            flex-direction: column;
            overflow-y: auto;
            padding: 20px;
            gap: 20px;
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
    </style>

    <style>
        /* Custom card styles */
        .stats-card {
            position: relative;
            overflow: hidden;
            padding: 25px;
            border-radius: 12px;
            transition: all 0.4s ease-in-out;
        }

        .stats-card::before {
            content: "";
            position: absolute;
            top: -100%;
            left: -100%;
            width: 250%;
            height: 250%;
            background: radial-gradient(circle, rgba(88, 166, 255, 0.2) 10%, transparent 70%);
            transition: all 0.5s ease-in-out;
        }

        .stats-card:hover::before {
            top: 0;
            left: 0;
        }

        .stats-card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0px 10px 20px rgba(88, 166, 255, 0.5);
        }

        .stats-card h3 {
            font-size: 22px;
            font-weight: bold;
            color: #58a6ff;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #c9d1d9;
            transition: all 0.5s ease;
        }
    </style>

    <style>
        /* Custom styles for the calendar */
        .calendar {
            background: #21262d;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(88, 166, 255, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .calendar:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(88, 166, 255, 0.5);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #58a6ff;
            margin-bottom: 10px;
        }

        .calendar-btn {
            background: none;
            border: none;
            color: #58a6ff;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .calendar-btn:hover {
            color: #ffffff;
            transform: scale(1.2);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            font-weight: bold;
        }

        .calendar-day {
            color: #c9d1d9;
            padding: 5px;
        }

        .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-date {
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            background: #161b22;
            color: #c9d1d9;
            height: 10vh;
        }

        .calendar-date:hover {
            background: #58a6ff;
            color: #000;
            transform: scale(1.1);
        }

        .scheduled {
            background: rgba(88, 166, 255, 0.3);
            border: 2px solid #58a6ff;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #21262d;
            padding: 20px;
            border-radius: 10px;
            color: #c9d1d9;
            width: 300px;
            text-align: center;
        }

        .close-modal {
            float: right;
            font-size: 20px;
            cursor: pointer;
            color: #58a6ff;
        }

        .close-modal:hover {
            color: red;
        }
    </style>

</head>
<body>
<nav class="navbar">
    <h1>RIS - Dashboard</h1>
    <div class="nav-links">
        <a class="active" href="<?php echo $ris_dashboard; ?>">Home</a>
        <a href="<?php echo $ris_all_reports; ?>">Reports</a>
        <a href="<?php echo $ris_all_schedule; ?>">Schedules</a>
        <a href="<?php echo $logout_controller; ?>">Logout</a>
    </div>
</nav>
<div class="dashboard">
    <div class="card-container">

<!--   Place your Cards here     -->

        <div class="card-container">
            <div class="card stats-card" id="total-reports">
                <h3>Total Reports</h3>
                <p><span class="stat-number"><?php echo $reportCounts['total_report_count_today']; ?></span> (Today)</p>
                <p><span class="stat-number"><?php echo $reportCounts['total_report_count_this_week']; ?></span> (This Week)</p>
                <p><span class="stat-number"><?php echo $reportCounts['total_report_count_this_month']; ?></span> (This Month)</p>
            </div>

            <div class="card stats-card" id="total-scheduled">
                <h3>Total Scheduled</h3>
                <p>📅 <span class="stat-number"><?php echo $scheduleCount['total_report_count_future'];?></span> Upcoming</p>
                <p>✅ <span class="stat-number"><?php echo $scheduleCount['total_report_count_past'];?></span> Completed</p>
            </div>

            <div class="card stats-card" id="pending-reports">
                <h3>Pending Reports</h3>
                <p>⏳ <span class="stat-number"><?php echo $reportCounts['total_pending']?></span> Yet to be completed</p>
            </div>

            <div class="card stats-card" id="todays-appointments">
                <h3>Today's Appointments</h3>
                <p>📅 <span class="stat-number"><?php echo $scheduleCount['total_report_count_today'];?></span> Scheduled for Today</p>
            </div>
        </div>
    </div>


    <!-- Calendar Container -->
    <div id="calendar-container">
        <div class="calendar">
            <div class="calendar-header">
                <button id="prev-month" class="calendar-btn">❮</button>
                <h2 id="month-year"></h2>
                <button id="next-month" class="calendar-btn">❯</button>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day">Sun</div>
                <div class="calendar-day">Mon</div>
                <div class="calendar-day">Tue</div>
                <div class="calendar-day">Wed</div>
                <div class="calendar-day">Thu</div>
                <div class="calendar-day">Fri</div>
                <div class="calendar-day">Sat</div>
            </div>
            <div id="calendar-dates" class="calendar-dates"></div>
        </div>
    </div>

    <!-- Event Modal -->
    <div id="event-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3 id="event-date"></h3>
            <ul id="event-list"></ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const monthYear = document.getElementById("month-year");
        const calendarDates = document.getElementById("calendar-dates");
        const prevMonth = document.getElementById("prev-month");
        const nextMonth = document.getElementById("next-month");
        const modal = document.getElementById("event-modal");
        const closeModal = document.querySelector(".close-modal");
        const eventDate = document.getElementById("event-date");
        const eventList = document.getElementById("event-list");

        let currentDate = new Date();
        let scheduledEvents = {}; // Stores fetched events

        // Fetch events from the backend
        function fetchScheduledEvents() {
            fetch("getScheduledEvents.php")
                .then(response => response.json())
                .then(data => {
                    scheduledEvents = data;
                    loadCalendar();
                })
                .catch(error => console.error("Error fetching scheduled events:", error));
        }

        function loadCalendar() {
            calendarDates.innerHTML = "";
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();

            monthYear.innerText = currentDate.toLocaleString("default", { month: "long", year: "numeric" });

            // Add empty divs for previous month's empty slots
            for (let i = 0; i < firstDay; i++) {
                calendarDates.innerHTML += `<div class="empty-slot"></div>`;
            }

            // Add actual days
            for (let day = 1; day <= totalDays; day++) {
                const dateKey = `${year}-${(month + 1).toString().padStart(2, "0")}-${day.toString().padStart(2, "0")}`;
                const hasEvent = scheduledEvents[dateKey];

                calendarDates.innerHTML += `
                    <div class="calendar-date ${hasEvent ? "scheduled" : ""}" data-date="${dateKey}">
                        ${day} ${hasEvent ? "📌" : ""}
                    </div>
                `;
            }

            // Attach click event for dates
            document.querySelectorAll(".calendar-date").forEach(dateElement => {
                dateElement.addEventListener("click", function () {
                    const selectedDate = this.getAttribute("data-date");
                    eventDate.innerText = selectedDate;
                    eventList.innerHTML = "";

                    if (scheduledEvents[selectedDate]) {
                        scheduledEvents[selectedDate].forEach(event => {
                            eventList.innerHTML += `<li>${event}</li>`;
                        });
                    } else {
                        eventList.innerHTML = "<li>No events scheduled.</li>";
                    }

                    modal.style.display = "flex";
                });
            });
        }

        closeModal.addEventListener("click", function () {
            modal.style.display = "none";
        });

        prevMonth.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            loadCalendar();
        });

        nextMonth.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            loadCalendar();
        });

        fetchScheduledEvents(); // Load events on page load
    });
</script>



</body>
</html>





