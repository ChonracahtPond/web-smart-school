<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- การ์ดแสดงสถิติ -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="card bg-blue-100 p-6 rounded-lg shadow-md hover:bg-blue-200 transition-transform transform hover:scale-105">
        <div class="flex items-center mb-4">
            <i class="fas fa-users fa-2x text-blue-800 mr-4"></i>
            <h2 class="text-xl font-semibold text-blue-800">จำนวนผู้สมัครทั้งหมด</h2>
        </div>
        <p class="text-3xl font-bold text-blue-900"><?php echo htmlspecialchars($total_students); ?> คน</p>
    </div>
    <div class="card bg-green-100 p-6 rounded-lg shadow-md hover:bg-green-200 transition-transform transform hover:scale-105">
        <div class="flex items-center mb-4">
            <i class="fas fa-check-circle fa-2x text-green-800 mr-4"></i>
            <h2 class="text-xl font-semibold text-green-800">สมัครผ่าน</h2>
        </div>
        <p class="text-3xl font-bold text-green-900"><?php echo htmlspecialchars($accepted_count); ?> คน</p>
    </div>
    <div class="card bg-red-100 p-6 rounded-lg shadow-md hover:bg-red-200 transition-transform transform hover:scale-105">
        <div class="flex items-center mb-4">
            <i class="fas fa-times-circle fa-2x text-red-800 mr-4"></i>
            <h2 class="text-xl font-semibold text-red-800">สมัครไม่ผ่าน</h2>
        </div>
        <p class="text-3xl font-bold text-red-900"><?php echo htmlspecialchars($rejected_count); ?> คน</p>
    </div>
</div>