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
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 10px;
        border: 1px solid #888;
        width: 90%;
        max-width: 288px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        border-radius: 6px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 16px;
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
        max-width: 100%;
        margin: 0 auto;
    }

    /* Responsive design for mobile */
    @media (max-width: 600px) {
        .modal-content {
            width: 100%;
            margin: 0;
            padding: 6px;
        }

        .close {
            font-size: 14px;
        }
    }

    /* Button styling */
    .bg-blue-500 {
        background-color: #3b82f6;
    }

    .text-white {
        color: #fff;
    }

    .px-4 {
        padding-left: 0.7rem;
        padding-right: 0.7rem;
    }

    .py-2 {
        padding-top: 0.36rem;
        padding-bottom: 0.36rem;
    }

    .rounded-lg {
        border-radius: 0.36rem;
    }

    .shadow-lg {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .hover\:bg-blue-600:hover {
        background-color: #2563eb;
    }

    .transition {
        transition: background-color 0.2s ease;
    }

    .duration-200 {
        transition-duration: 200ms;
    }
</style>

<!-- Button to Add Event -->
<button id="addEventBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200 mb-6">+ เพิ่มข้อมูล</button>

<div class="w-full h-[30%]" id='calendar'></div>

<!-- Modal for event details -->
<div id="eventModal" class="modal ">
    <div class="modal-content ">
        <span class="close">&times;</span>
        <h2 id="eventTitle" class="text-lg font-bold mb-2"></h2>
        <p id="eventDescription" class="text-gray-700 mb-2"></p>
        <p id="eventDate" class="text-gray-600"></p>
    </div>
</div>

<!-- Modal for event details -->
<!-- <div id="eventModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 text-2xl" onclick="closeModal()">&times;</button>
        <h2 id="eventTitle" class="text-xl font-semibold mb-3 text-gray-800"></h2>
        <p id="eventDescription" class="text-gray-700 mb-3"></p>
        <p id="eventDate" class="text-gray-600"></p>
    </div>
</div> -->



<!-- Modal for adding new event -->
<div id="addEventModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="text-lg font-bold mb-4">เพิ่มเหตุการณ์ใหม่</h2>
        <form id="addEventForm">
            <div class="mb-4">
                <label for="eventTitleInput" class="block text-gray-700 mb-2">หัวข้อเหตุการณ์</label>
                <input type="text" id="eventTitleInput" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="eventDescriptionInput" class="block text-gray-700 mb-2">รายละเอียดเหตุการณ์</label>
                <textarea id="eventDescriptionInput" class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mb-4">
                <label for="eventStartDateInput" class="block text-gray-700 mb-2">วันที่เริ่มต้น</label>
                <input type="date" id="eventStartDateInput" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="eventEndDateInput" class="block text-gray-700 mb-2">วันที่สิ้นสุด</label>
                <input type="date" id="eventEndDateInput" class="w-full p-2 border rounded">
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
                fetch('../pages/dashboard/calendar/fetch_data.php')
                    .then(response => response.json())
                    .then(data => {
                        // console.log('Fetched events:', data); // Debugging line
                        successCallback(data);
                    })
                    .catch(error => {
                        // console.error('Error fetching events:', error);
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

        document.getElementById('addEventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var title = document.getElementById('eventTitleInput').value;
            var description = document.getElementById('eventDescriptionInput').value;
            var startDate = document.getElementById('eventStartDateInput').value;
            var endDate = document.getElementById('eventEndDateInput').value;

            if (title && startDate) {
                fetch('../pages/dashboard/calendar/add_event.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'eventTitle': title,
                            'eventDescription': description,
                            'eventStartDate': startDate,
                            'eventEndDate': endDate
                        })
                    }).then(response => response.text())
                    .then(data => {
                        console.log('Server response:', data);
                        if (data.includes('successfully')) {
                            calendar.addEvent({
                                title: title,
                                start: startDate,
                                end: endDate,
                                description: description
                            });
                            addEventModal.style.display = "none";
                        } else {
                            alert('Error saving event: ' + data);
                        }
                    }).catch(error => {
                        console.error('Fetch error:', error);
                        alert('Fetch error: ' + error.message);
                    });
            } else {
                alert('Please fill in all required fields.');
            }
        });

    });
</script>