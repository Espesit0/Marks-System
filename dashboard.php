<?php
// Include the dbconnect.php file to establish the database connection
require_once "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["insert_student_marks"])) {
        // Redirect to the insert student marks page
        header("Location: marks.php");
        exit();
    } elseif (isset($_POST["edit_student_marks"])) {
        // Redirect to the edit student marks page
        header("Location: edit_marks.php");
        exit();
    } elseif (isset($_POST["delete_student_info"])) {
        // Redirect to the delete student information page
        header("Location: delete_student.php");
        exit();
    } elseif (isset($_POST["search_view_student_info"])) {
        // Redirect to the search and view student information page
        header("Location: search_view_student.php");
        exit();
    } elseif (isset($_POST["pass_and_failed"])) {
        // Redirect to the student pass and failed information page
        header("Location: pass_failed.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            padding: 300px;
            background-image: url('blurbackground.jpg');
            background-size: cover;
            background-position: center;
            margin: 50;
        }

        h1 {
            color: #FFFFFF;
            text-align: center;
        }

        .container {
            max-width: 3000px;
            margin: 0 auto;
            border-radius: 50px;
            padding: 100px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: row; /* Change from 'column' to 'row' */
            justify-content: space-between; /* Add space between form elements */
            align-items: center;
                    }

        /* Adjust input styles to fit in a row */
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 50px;
            border: none;
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lecturer Dashboard</h1>
        <br>
        <form method="post" action="dashboard.php">
            <input type="submit" name="insert_student_marks" value="Insert Student Marks">
            <input type="submit" name="edit_student_marks" value="Edit Student Marks">
            <input type="submit" name="delete_student_info" value="Delete Student Information">
            <input type="submit" name="search_view_student_info" value="Search and View Student Information">
            <input type="submit" name="pass_and_failed" value="Student Pass and Failed ">
        </form>
    </div>
</body>
</html>

