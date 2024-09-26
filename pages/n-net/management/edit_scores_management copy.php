<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขคะแนน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body>

    <div class="p-8 mt-6 lg:mt-0 rounded-lg shadow bg-white">
        <div class="modal-header flex justify-between items-center border-b pb-2">
            <h1 class="text-3xl font-semibold text-indigo-500 dark:text-white mb-5">แก้ไขคะแนน</h1>
        </div>
        <div class="modal-body mt-4">
            <form id="editScoreForm" method="POST" action="?page=update_score">
                <input type="hidden" id="edit_nnet_scores_id" name="nnet_scores_id">

                <div class="mb-4">
                    <label for="edit_student_id" class="block text-sm font-medium text-gray-700">รหัสนักเรียน</label>
                    <input type="text" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_student_id" name="student_id" required>
                </div>

                <div class="mb-4">
                    <label for="edit_exam_id" class="block text-sm font-medium text-gray-700">รหัสการสอบ</label>
                    <input type="text" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_exam_id" name="exam_id" required>
                </div>

                <div class="mb-4">
                    <label for="edit_score" class="block text-sm font-medium text-gray-700">คะแนน</label>
                    <input type="number" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_score" name="score" required>
                </div>

                <div class="mb-4">
                    <label for="edit_exam_date" class="block text-sm font-medium text-gray-700">วันที่สอบ</label>
                    <input type="date" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_exam_date" name="exam_date" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">บันทึกการเปลี่ยนแปลง</button>
            </form>
        </div>
    </div>

</body>

</html>