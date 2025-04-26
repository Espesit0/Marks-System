<?php
// Include the dbconnect.php file to establish the database connection
require_once "dbconnect.php";


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to check lecturer credentials
    $sql = "SELECT id, username FROM lecturers WHERE username = '$username' AND password = '$password' LIMIT 1";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        // Login successful
        $row = mysqli_fetch_assoc($result);

        // Start a session and store lecturer details in session variables
        session_start();
        $_SESSION["id"] = $row["id"];
        $_SESSION["name"] = $row["name"];

        // Redirect to the lecturer dashboard or any other desired page
        header("Location: newdashboard.php");
        exit();
    } else {
        // Login failed
        $loginError = "Invalid username or password. Please try again.";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("world.jpg");
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .login-container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
        
        h2 {
            text-align: center;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 3px;
            width: 100%;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
       <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
        <p>Username: "jimy" and password: "12345" to log in.</p>
    </div>
</body>
</html>

