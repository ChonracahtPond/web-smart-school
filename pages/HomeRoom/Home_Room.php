<!--  -->



<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ปฏิทิน - ระบบสารสนเทศ Homeroom</title>
<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.0.0/dist/fullcalendar.min.css" rel="stylesheet">
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
</style>



<!-- Main Content -->
<main class="container mx-auto p-6">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold">ระบบสารสนเทศ Homeroom</h1>
    </div>


    <!-- Add Home Room Button -->
    <div class="text-center">
        <a href="?page=Create_Room" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 text-lg font-semibold">สร้างห้องออนไลน์</a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">ปฏิทิน</h2>
        <!-- <div>
            <h1 class="text-3xl ">ระบบสารสนเทศ Homeroom</h1>
        </div> -->

        <div class="w-full ">
            <?php include "dashboard/calendar/calendar.php"; ?>
        </div>
    </div>


</main>


<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.0.0/dist/fullcalendar.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar-container');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'th'
        });
        calendar.render();
    });
</script>