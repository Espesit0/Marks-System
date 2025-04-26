<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lecturer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url("blurbackground.jpg");
            background-size: cover;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .action-buttons button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
    </header>
    <div class="container">
        <div class="action-buttons">
            <button onclick="location.href='insert_marks.php'">Insert Marks</button>
            <button onclick="location.href='edit_marks.php'">Edit Marks</button>
            <button onclick="location.href='delete_student.php'">Delete Student Info</button>
            <button onclick="location.href='view_student.php'">View Student Info</button>
            <button onclick="location.href='view_pass_fail.php'">View Pass/Fail Info</button>
        </div>
    </div>
</body>
</html>
