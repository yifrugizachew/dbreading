<?php
include "connection.php";  // Include database connection

// Set headers to force download as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="report.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// Open PHP output as a file pointer
$output = fopen('php://output', 'w');

// Add column headers to CSV
fputcsv($output, ['Fiscal Year', 'Reading Month', 'Customer Name', 'Kebele', 'Contract Number', 'Current Reading', 'Phone Number']);

// Fetch data from MySQL
$sql = "SELECT * FROM readings ORDER BY fiscal_year DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    // Write each row of data to CSV
    fputcsv($output, [
        $row['fiscal_year'],
        $row['reading_month'],
        $row['customer_name'],
        $row['kebele'],
        $row['contract_number'],
        $row['current_reading'],
        $row['phone_number']
    ]);
}

// Close the file pointer
fclose($output);
exit();
?>
