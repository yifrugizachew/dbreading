<?php 
require_once 'connection.php'; // Include the configuration file
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user was found
    if($result->num_rows > 0){
        // Redirect to the "manage.php" page after successful login
        header("Location: report.php");
        exit(); // Ensure no further code is executed after the redirect
        
        
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/
font-awesome/5.15.2/css/all.min.css"/>
  <link rel="stylesheet" href="login-style.css">
  <title>Login Form</title>
  </head>
<body>

<form action="login.php" method="post" class="login-form">
    <h1>Admin Login</h1>
    <div class="input-container">
        <i class="fa fa-user"></i>
        <input type="text" name="username" placeholder="Username" required>
    </div>
    <div class="input-container">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit" name="submit" class="btn">Login</button>
</form>

<style>
    body {
        font-family: Arial, sans-serif;
        background:rgb(14, 45, 219);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }


    .login-form {
        background: #ffffff;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .login-form h1 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .input-container {
        position: relative;
        margin-bottom: 20px;
    }

    .input-container i {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #888;
    }

    .input-container input {
        width: 100%;
        padding: 10px 10px 10px 35px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s;
    }

    .input-container input:focus {
        border-color: #007bff;
    }

    .btn {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn:hover {
        background: #0056b3;
    }
</style>

<?php 

if(isset($error_msg)){
    echo "<span class='error'>".$error_msg."</span>";
}

?>

</form>

</body>
</html>
