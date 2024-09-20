<style>
    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
        box-sizing: border-box;
    }

    .marquee {
        display: inline-block;
        padding-left: 40%;
        /* เริ่มต้นจากนอกหน้าจอทางขวา */
        animation: marquee 20s linear infinite;
    }

    @keyframes marquee {
        from {
            transform: translateX(100%);
            /* เริ่มต้นจากนอกหน้าจอทางขวา */
        }

        to {
            transform: translateX(-100%);
            /* เคลื่อนที่ไปที่นอกหน้าจอทางซ้าย */
        }
    }
</style>


<div class="marquee-container ">
    <div class="marquee text-2xl font-semibold text-white">
        ยินดีต้อนรับเข้าสู่ระบบการจัดการข้อมูล
    </div>
</div>