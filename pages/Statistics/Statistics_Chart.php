<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="bg-white shadow-lg rounded-lg p-6 flex flex-1 justify-between h-[40%]">
    <!-- ส่วนสำหรับกราฟแท่ง -->
    <div class="mb-6 w-[60%] ">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">กราฟแท่ง: จำนวนผู้สมัครตามสถานะ</h2>
        <canvas id="barChart"></canvas>
    </div>
    <!-- ส่วนสำหรับกราฟโดนัท -->
    <div class="mb-6 w-[30%]">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">กราฟโดนัท: สถานะการสมัคร</h2>
        <canvas id="donutChart"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ข้อมูลสำหรับกราฟแท่ง
        const barChartData = {
            labels: ['ทั้งหมด', 'สมัครผ่าน', 'สมัครไม่ผ่าน'],
            datasets: [{
                label: 'จำนวนผู้สมัคร',
                data: [<?php echo $total_students; ?>, <?php echo $accepted_count; ?>, <?php echo $rejected_count; ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)', // สีของแท่งข้อมูล
                    'rgba(75, 192, 192, 0.2)', // สีของแท่งข้อมูล
                    'rgba(255, 99, 132, 0.2)' // สีของแท่งข้อมูล
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', // สีเส้นขอบของแท่งข้อมูล
                    'rgba(75, 192, 192, 1)', // สีเส้นขอบของแท่งข้อมูล
                    'rgba(255, 99, 132, 1)' // สีเส้นขอบของแท่งข้อมูล
                ],
                borderWidth: 1
            }]
        };

        // ข้อมูลสำหรับกราฟโดนัท
        const donutChartData = {
            labels: ['ทั้งหมด', 'สมัครผ่าน', 'สมัครไม่ผ่าน'],
            datasets: [{
                label: 'จำนวนผู้สมัคร',
                data: [<?php echo $total_students; ?>, <?php echo $accepted_count; ?>, <?php echo $rejected_count; ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)', // สีของโดนัท
                    'rgba(75, 192, 192, 0.2)', // สีของโดนัท
                    'rgba(255, 99, 132, 0.2)' // สีของโดนัท
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', // สีเส้นขอบของโดนัท
                    'rgba(75, 192, 192, 1)', // สีเส้นขอบของโดนัท
                    'rgba(255, 99, 132, 1)' // สีเส้นขอบของโดนัท
                ],
                borderWidth: 1
            }]
        };

        // สร้างกราฟแท่ง
        new Chart(document.getElementById('barChart').getContext('2d'), {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        // สร้างกราฟโดนัท
        new Chart(document.getElementById('donutChart').getContext('2d'), {
            type: 'doughnut',
            data: donutChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    });
</script>