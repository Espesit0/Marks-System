<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Insert Student Marks</title>
    <style>
        /* Add your CSS styles here */
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url("blurbackground.jpg");
            background-size: cover;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .result {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .pass {
            color: green;
        }

        .fail {
            color: red;
        }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <h2>Insert Student Marks</h2>
        <form method="post">
            <label for="course_id">Course ID:</label>
            <input type="text" id="course_id" name="course_id" required><br>
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required><br>
            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" required><br>
            <label for="quiz1">Quiz 1 (30 marks):</label>
            <input type="number" id="quiz1" name="quiz1" min="0" max="30" required><br>
            <label for="quiz2">Quiz 2 (30 marks):</label>
            <input type="number" id="quiz2" name="quiz2" min="0" max="30" required><br>
            <label for="quiz3">Quiz 3 (30 marks):</label>
            <input type="number" id="quiz3" name="quiz3" min="0" max="30" required><br>
            <label for="test1">Test 1 (50 marks):</label>
            <input type="number" id="test1" name="test1" min="0" max="50" required><br>
            <label for="test2">Test 2 (50 marks):</label>
            <input type="number" id="test2" name="test2" min="0" max="50" required><br>
            <label for="midterm">Midterm (100 marks):</label>
            <input type="number" id="midterm" name="midterm" min="0" max="100" required><br>
            <label for="project">Project (100 marks):</label>
            <input type="number" id="project" name="project" min="0" max="100" required><br>
            <label for="final_exam">Final Exam (100 marks):</label>
            <input type="number" id="final_exam" name="final_exam" min="0" max="100" required><br>
            <button type="submit" name="calculate">Calculate</button>
        </form>
        <form action="newdashboard.php">
            <button type="submit">Home</button>
        </form>

    <?php
    if (isset($_POST['calculate'])) {
    // Replace these variables with your actual database credentials
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'grades_db';

    // Include the dbconnect.php file to establish the database connection
    require_once "dbconnect.php";


    // Full marks for each assessment
    $full_marks_quiz = 30;
    $full_marks_test = 50;
    $full_marks_midterm = 100;
    $full_marks_project = 100;
    $full_marks_final_exam = 100;

    // Replace these variables with your actual weightage percentages
    $quiz_weightage = 0.10;
    $test_weightage = 0.10;
    $midterm_weightage = 0.20;
    $project_weightage = 0.20;
    $final_exam_weightage = 0.40;

    // Get the marks entered by the lecturer
    $course_id = $_POST['course_id'];
    $student_name = $_POST['student_name'];
    $quiz1 = $_POST['quiz1'];
    $quiz2 = $_POST['quiz2'];
    $quiz3 = $_POST['quiz3'];
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $midterm = $_POST['midterm'];
    $project = $_POST['project'];
    $final_exam = $_POST['final_exam'];

    // Calculate formative marks (out of 60)
    $total_formative_marks = ($quiz1 + $quiz2 + $quiz3) / 3 +
                            ($test1 + $test2) / 2 +
                            $midterm +
                            $project;
    $total_formative_marks /= 7; // Divide by the number of formative assessments
    $total_formative_marks *= 60;

    // Calculate summative marks (out of 40)
    $total_summative_marks = $final_exam;

    // Calculate the final total marks (out of 100)
    $total_marks = (($quiz1 + $quiz2 + $quiz3) / 90) * 10
                     + (($test1 + $test2) / 100) * 10
                     + ($midterm / 100) * 20
                     + ($project / 100) * 20
                     + ($total_summative_marks / $full_marks_final_exam) * 40;

    // Scale the total marks to a maximum of 100
    $total_marks_scaled = ($total_marks / 100) * 100;

    // Check if the student passed or failed
    $pass_fail_status = ($total_marks_scaled >= 40) ? "Pass" : "Fail";
        // Step 1: Establish a connection to the database
        $connection = mysqli_connect($hostname, $username, $password, $database);

        // Check if the connection was successful
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Step 2: Insert the student marks into the database
        $query = "INSERT INTO student_marks (course_id, student_name, quiz1, quiz2, quiz3, test1, test2, midterm_exam, project, final_exam, formative_marks, summative_marks, total_marks, pass_status)
                  VALUES ('$course_id', '$student_name', $quiz1, $quiz2, $quiz3, $test1, $test2, $midterm, $project, $final_exam, $total_formative_marks, $total_summative_marks, $total_marks, '$pass_fail_status')";

    if (mysqli_query($connection, $query)) {
        echo "<div class='result'>";
        echo "Student Name: $student_name<br>";
        echo "Course ID: $course_id<br>";
        echo "Total Marks: $total_marks<br>";
        echo "Result: <span class='" . ($pass_fail_status === 'Pass' ? 'pass' : 'fail') . "'>$pass_fail_status</span>";
        echo "<p>Student marks inserted into the database successfully!</p>";
        echo "</div>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    // Step 3: Close the database connection
    mysqli_close($connection);
}
?>
</div>
</body>
</html>


<style>
    body {
            
            
            background-image: url("blurbackground.jpg");
            background-size: cover;
        }
    </style>