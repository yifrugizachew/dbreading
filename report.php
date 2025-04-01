<?php
include "connection.php";
// Fetch fiscal years and months for the dropdowns
$fiscalYears = $conn->query("SELECT DISTINCT fiscal_year FROM readings ORDER BY fiscal_year DESC");
if (!$fiscalYears) {
    die("Error fetching fiscal years: " . $conn->error);
}

$months = $conn->query("SELECT DISTINCT `reading_month` FROM readings ORDER BY `reading_month` ASC");
if (!$months) {
    die("Error fetching months: " . $conn->error);
}

// Handle form submission
$fiscalYear = isset($_POST['fiscal_year']) ? $_POST['fiscal_year'] : '';
$month = isset($_POST['reading_month']) ? $_POST['reading_month'] : '';

$query = "SELECT * FROM readings WHERE 1=1";
if ($fiscalYear) {
    $query .= " AND fiscal_year = '$fiscalYear'";
}
if ($month) {
    $query .= " AND reading_month = '$month'";
}

$result = $conn->query($query);

// Handle CSV download
if (isset($_POST['download_csv'])) {
    if ($result->num_rows > 0) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="filtered_data.csv"');

        $output = fopen('php://output', 'w');
        // Add CSV headers
        fputcsv($output, ['Fiscal Year', 'Reading Month', 'Customer Name', 'Kebele', 'Contract Number', 'Current Reading', 'Phone Number']);

        // Add rows to CSV
        while ($row = $result->fetch_assoc()) {
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

        fclose($output);
        exit;
    } else {
        echo "<script>alert('No data available to download.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Report</title>
</head>
<body>
    <h2>Filtered Data</h2>
    <form method="POST" action="">
        <label for="fiscal_year">Fiscal Year:</label>
        <select name="fiscal_year" id="fiscal_year">
            <option value="">Select Fiscal Year</option>
            <?php while ($row = $fiscalYears->fetch_assoc()): ?>
                <option value="<?= $row['fiscal_year']; ?>" <?= $fiscalYear == $row['fiscal_year'] ? 'selected' : ''; ?>>
                    <?= $row['fiscal_year']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="reading_month">Month:</label>
        <select name="reading_month" id="reading_month">
            <option value="">Select Month</option>
            <?php while ($row = $months->fetch_assoc()): ?>
                <option value="<?= $row['reading_month']; ?>" <?= $month == $row['reading_month'] ? 'selected' : ''; ?>>
                    <?= $row['reading_month']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Filter</button>
        <button type="submit" name="download_csv">Download CSV</button>
    </form>

   
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 8px; border: 1px solid #ddd;">Fiscal Year</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Reading Month</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Customer Name</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Kebele</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Contract Number</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Current Reading</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr style="background-color: <?= $row['current_reading'] > 100 ? '#ffcccc' : '#ffffff'; ?>;">
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $row['fiscal_year']; ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $row['reading_month']; ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $row['customer_name']; ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $row['kebele']; ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $row['contract_number']; ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $row['current_reading']; ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $row['phone_number']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="padding: 8px; border: 1px solid #ddd; text-align: center;">No data found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>