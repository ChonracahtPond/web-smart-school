<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar Example</title>
    <!-- Include FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.15/main.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.15/index.global.min.js'></script>
    <style>
        /* Custom styles for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Custom styles for calendar */
        #calendar {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <!-- Button to Add Event -->
    <button id="addEventBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200 mb-10">+ เพิ่มข้อมูล</button>

    <div class="w-full" id='calendar'></div>

    <!-- Modal for event details -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="eventTitle"></h2>
            <p id="eventDescription"></p>
            <p id="eventDate"></p>
        </div>
    </div>

    <!-- Modal for adding new event -->
    <div id="addEventModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>เพิ่มเหตุการณ์ใหม่</h2>
            <form id="addEventForm">
                <div class="mb-4">
                    <label for="eventTitleInput" class="block text-gray-700">หัวข้อเหตุการณ์</label>
                    <input type="text" id="eventTitleInput" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="eventDescriptionInput" class="block text-gray-700">รายละเอียดเหตุการณ์</label>
                    <textarea id="eventDescriptionInput" class="w-full p-2 border rounded"></textarea>
                </div>
                <div class="mb-4">
                    <label for="eventDateInput" class="block text-gray-700">วันที่เหตุการณ์</label>
                    <input type="date" id="eventDateInput" class="w-full p-2 border rounded" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">บันทึกเหตุการณ์</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventModal = document.getElementById("eventModal");
            var addEventModal = document.getElementById("addEventModal");
            var spans = document.getElementsByClassName("close");
            var addEventBtn = document.getElementById("addEventBtn");

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('get_event.php') // URL to your PHP file
                        .then(response => response.json())
                        .then(data => {
                            console.log('Events data received:', data); // Log received data
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },

                eventClick: function(info) {
                    document.getElementById("eventTitle").textContent = info.event.title;
                    document.getElementById("eventDescription").textContent = info.event.extendedProps.description || 'No description';
                    document.getElementById("eventDate").textContent = `Date: ${info.event.start.toISOString().split('T')[0]}${info.event.end ? ' - ' + info.event.end.toISOString().split('T')[0] : ''}`;
                    eventModal.style.display = "block";
                }
            });

            calendar.render();

            // Open Add Event Modal
            addEventBtn.onclick = function() {
                addEventModal.style.display = "block";
            }

            // Close modals
            Array.from(spans).forEach(span => {
                span.onclick = function() {
                    eventModal.style.display = "none";
                    addEventModal.style.display = "none";
                }
            });

            window.onclick = function(event) {
                if (event.target === eventModal || event.target === addEventModal) {
                    eventModal.style.display = "none";
                    addEventModal.style.display = "none";
                }
            }

            // Handle form submission
            document.getElementById('addEventForm').addEventListener('submit', function(e) {
                e.preventDefault();
                var title = document.getElementById('eventTitleInput').value;
                var description = document.getElementById('eventDescriptionInput').value;
                var date = document.getElementById('eventDateInput').value;

                if (title && date) {
                    fetch('add_event.php', { // URL to your PHP file
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                'eventTitle': title,
                                'eventDescription': description,
                                'eventDate': date
                            })
                        }).then(response => response.text())
                        .then(data => {
                            console.log('Server response:', data); // Log server response
                            if (data.includes('successfully')) {
                                calendar.addEvent({
                                    title: title,
                                    start: date,
                                    description: description
                                });
                                addEventModal.style.display = "none";
                            } else {
                                alert('Error saving event: ' + data);
                            }
                        }).catch(error => {
                            console.error('Fetch error:', error); // Log fetch error
                            alert('Fetch error: ' + error.message);
                        });
                } else {
                    alert('Please fill in all required fields.');
                }
            });
        });
    </script>
</body>

</html>