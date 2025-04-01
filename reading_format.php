<?php
// Include the database connection file
include "connection.php"; // Ensure the path to connection.php is correct

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fiscal_year = $_POST['fiscal_year'];
    $reading_month = $_POST['reading_month'];
    $customer_name = $_POST['customer_name'];
    $kebele = $_POST['kebele'];
    $contract_number = $_POST['contract_number'];
    $current_reading = $_POST['current_reading'];
    $phone_number = $_POST['phone_number'];

    // Use prepared statements to prevent SQL injection

    $stmt = $conn->prepare("INSERT INTO readings (fiscal_year, reading_month, customer_name, kebele, contract_number, current_reading, phone_number) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fiscal_year, $reading_month, $customer_name, $kebele, $contract_number, $current_reading, $phone_number);

    // Execute query and display result
    if ($stmt->execute()) {
        echo "<div class='result-container'>";
        echo "<h3>✅ Data Submitted Successfully:</h3>";
        echo "<p><strong>📅 Fiscal Year:</strong> $fiscal_year</p>";
        echo "<p><strong>📆 Reading Month:</strong> $reading_month</p>";
        echo "<p><strong>👤 Customer Name:</strong> $customer_name</p>";
        echo "<p><strong>🏠 Kebele:</strong> $kebele</p>";
        echo "<p><strong>🔢 Contract Number:</strong> $contract_number</p>";
        echo "<p><strong>🔢 Current Reading:</strong> $current_reading</p>";
        echo "<p><strong>📞 Phone Number:</strong> $phone_number</p>";
        echo "</div>";
    } else {
        echo "<div class='result-container'>";
        echo "<h3>❌ Error:</h3>";
        echo "<p>Failed to insert data. " . $stmt->error . "</p>";
        echo "</div>";
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Meter Reading Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        /* Form Heading */
        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Labels */
        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin: 10px 0 5px;
        }

        /* Input Fields */
        input, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus, select:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        /* Submit Button */
        button {
            width: 100%;
            background: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        /* Result Display */
        .result-container {
            background: white;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .result-container p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="margin-top: 35px;">📊 ቆጣሪ ማንበቢያ ፎርም</h2>
        <form method="POST" action="reading_format.php">
            <!-- Fiscal Year Dropdown -->
            <label for="fiscal_year">📅 Fiscal Year/በጀት አመት:</label>
            <select name="fiscal_year" id="fiscal_year" required>
                <option value="">በጀት አመት ምረጥ</option>
                <?php
                $fiscal_years = [2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025];
                foreach ($fiscal_years as $year) {
                    echo "<option value='$year'>$year</option>";
                }
                ?>
            </select>

            <!-- Reading Month Dropdown -->
            <label for="reading_month">📆 Reading Month/ወር:</label>
            <select name="reading_month" id="reading_month" required>
                <option value="">Select Month</option>
                <?php
                $months = [
                    "January/ ጥር", "February/ የካቲት", "March/ መጋቢት", "April/ ማዚያ", "May/ ግንቦት", "June/ ሰኔ",
                    "July/ ሃምሌ", "August/  ነሃሴ", "September/ መስከረም", "October/ ጥቅምት", "November/ሀዳር", "December/ታሀሳስ"
                ];
                foreach ($months as $month) {
                    echo "<option value='$month'>$month</option>";
                }
                ?>
            </select>

            <!-- Customer Name Input -->
            <label for="customer_name">👤 Customer Name/የደንበኛው ስም:</label>
            <input type="text" name="customer_name" id="customer_name" required>
            <!-- Kebele Dropdown -->
            <label for="kebele">🏠 Kebele/ከተማ:</label >
            <select name="kebele" id="kebele" required>
                <option value="">Select Kebele</option>
                <?php
                $kebeles = ["Loret Afewerk", "Nigest Eleni", "Fit Awrary", "Ansas Mariam", "Selam Chora", "Eyerus Alem",
                            "Andnet", "Debre Eba", "Ureal", "Midre Genet", "Hailemariam Mamo",
                            "Ayer Tena", "Giyorgis", "Lche", "Shewareged",
                            "Gebreal", "Mesalemia", "Bahir Hail", "Addis Genet", "Sahile Selassie",
                            "Selam Ber", "Kebede Michael", "Niguse HaileMelkot", "Misrak Tsehay"];
                    foreach ($kebeles as $kebele) {
                        echo "<option value='$kebele'>$kebele</option>";
                    }
                    ?>
                </select>
                

            <!-- Contract Number Input -->
            <label for="contract_number">🔢 Contract Number/መክፈያ ቁጥር:</label>
            <input type="text" name="contract_number" id="contract_number" required>

            <!-- Current Reading Input -->
            <label for="current_reading">🔢 Current Reading/ንባብ:</label>
            <input type="text" name="current_reading" id="current_reading" required>

            <!-- Phone Number Input -->
            <label for="phone_number">📞 Phone Number/ስልክ ቁጥር:</label>
            <input type="text" name="phone_number" id="phone_number" required>

            <!-- Submit Button -->
            <button type="submit">🚀 Submit</button>
        </form>
    </div>
</body>
</html>
