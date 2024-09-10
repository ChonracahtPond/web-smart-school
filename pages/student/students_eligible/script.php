<!-- Add JavaScript for filter dropdowns -->
<script>
    document.getElementById('termFilter').addEventListener('change', function() {
        updateFilters();
    });

    document.getElementById('yearFilter').addEventListener('change', function() {
        updateFilters();
    });

    function updateFilters() {
        const term = document.getElementById('termFilter').value;
        const year = document.getElementById('yearFilter').value;
        const url = new URL(window.location.href);
        if (term) {
            url.searchParams.set('term', term);
        } else {
            url.searchParams.delete('term');
        }
        if (year) {
            url.searchParams.set('academic_year', year);
        } else {
            url.searchParams.delete('academic_year');
        }
        window.location.href = url.toString();
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // เปิด modal เมื่อคลิกปุ่มเพิ่มนักเรียน
    $('#addStudentBtn').click(function() {
        $('#addStudentModal').show();
    });

    // ปิด modal เมื่อคลิกที่ปุ่มปิด
    $('#closeModal').click(function() {
        $('#addStudentModal').hide();
    });

    // ปิด modal เมื่อคลิกที่ด้านนอกของ modal
    $(window).click(function(event) {
        if ($(event.target).is('#addStudentModal')) {
            $('#addStudentModal').hide();
        }
    });
</script>
<script>
    // เปิด modal แก้ไขเมื่อคลิกปุ่มแก้ไข
    function openEditModal(editId) {
        // Fetch the edit form and populate it if needed
        $.ajax({
            url: '?edit_id=' + editId,
            type: 'GET',
            success: function(response) {
                $('#editStudentModal').show();
            }
        });
    }

    // ปิด modal เมื่อคลิกที่ปุ่มปิด
    $('#closeEditModal').click(function() {
        $('#editStudentModal').hide();
    });

    // ปิด modal เมื่อคลิกที่ด้านนอกของ modal
    $(window).click(function(event) {
        if ($(event.target).is('#editStudentModal')) {
            $('#editStudentModal').hide();
        }
    });

    // ฟังก์ชันที่ถูกเรียกใช้เมื่อคลิกปุ่มแก้ไข
    $('.edit-btn').click(function() {
        var editId = $(this).data('id');
        openEditModal(editId);
    });
</script>