<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();

            echo '<h1>Excel Data</h1>';
            echo '<table border="1">';
            foreach ($data as $row) {
                echo '<tr>';
                foreach ($row as $cell) {
                    echo '<td>' . htmlspecialchars($cell) . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        } catch (Exception $e) {
            echo 'Error reading file: ' . htmlspecialchars($e->getMessage());
        }
    } else {
        echo 'File upload error!';
    }
} else {
    echo 'No file uploaded!';
}
