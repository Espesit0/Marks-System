<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Pass/Fail Students</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

         button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .no-data {
            text-align: center;
            font-weight: bold;
        }

        /* Bar chart styles */
        .bar-chart-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .bar {
            height: 30px;
            margin-right: 10px;
            border-radius: 5px;
        }

        .pass-bar {
            background-color: #4CAF50;
        }

        .fail-bar {
            background-color: #F44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Pass/Fail Students</h2>

        <!-- Search Form -->
        <form method="post">
            <label for="search_input">Search Student:</label>
            <input type="text" id="search_input" name="search_input" placeholder="Enter Student Name or Student ID">
            <button type="submit" name="search">Search</button>
        </form>
        <form action="newdashboard.php">
            <button type="submit">Home</button>
        </form>

        <?php
        // Replace these variables with your actual database credentials
        $hostname = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'grades_db';

        // Include the dbconnect.php file to establish the database connection
        require_once "dbconnect.php";

        // Step 1: Establish a connection to the database
        $connection = mysqli_connect($hostname, $username, $password, $database);

        // Check if the connection was successful
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Step 2: Search pass/fail students based on user input
        if (isset($_POST['search'])) {
            $search_input = mysqli_real_escape_string($connection, $_POST['search_input']);

            // Construct the SQL query to search for pass students
            $pass_query = "SELECT * FROM student_marks WHERE (student_name LIKE '%$search_input%' OR student_id LIKE '%$search_input%') AND pass_status = 'Pass'";

            $pass_result = mysqli_query($connection, $pass_query);

            if ($pass_result) {
                if (mysqli_num_rows($pass_result) > 0) {
                    // Display the pass students in a table
                    echo "<h3>Pass Students:</h3>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Student ID</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Course ID</th>";
                    echo "<th>Total Marks</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($pass_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['student_name'] . "</td>";
                        echo "<td>" . $row['course_id'] . "</td>";
                        echo "<td>" . $row['total_marks'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p class='no-data'>No pass students found.</p>";
                }
            } else {
                echo "Error executing the query: " . mysqli_error($connection);
            }

            // Construct the SQL query to search for fail students
            $fail_query = "SELECT * FROM student_marks WHERE (student_name LIKE '%$search_input%' OR student_id LIKE '%$search_input%') AND pass_status = 'Fail'";

            $fail_result = mysqli_query($connection, $fail_query);

            if ($fail_result) {
                if (mysqli_num_rows($fail_result) > 0) {
                    // Display the fail students in a table
                    echo "<h3>Fail Students:</h3>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Student ID</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Course ID</th>";
                    echo "<th>Total Marks</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($fail_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['student_name'] . "</td>";
                        echo "<td>" . $row['course_id'] . "</td>";
                        echo "<td>" . $row['total_marks'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p class='no-data'>No fail students found.</p>";
                }
            } else {
                echo "Error executing the query: " . mysqli_error($connection);
            }
        } else {
            // If no search query, display all students
            $all_students_query = "SELECT * FROM student_marks";

            $all_students_result = mysqli_query($connection, $all_students_query);

            if ($all_students_result) {
                if (mysqli_num_rows($all_students_result) > 0) {
                    // Display all students in a table
                    echo "<h3>All Students:</h3>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Student ID</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Course ID</th>";
                    echo "<th>Total Marks</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($all_students_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['student_name'] . "</td>";
                        echo "<td>" . $row['course_id'] . "</td>";
                        echo "<td>" . $row['total_marks'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p class='no-data'>No students found.</p>";
                }
            } else {
                echo "Error executing the query: " . mysqli_error($connection);
            }
        }
        
        if (isset($_POST['search']) || !isset($_POST['search_input'])) {
    // If there's a search query or no search input, recalculate pass and fail statistics based on all students

    // Construct the SQL queries to get pass and fail counts
    $pass_count_query = "SELECT COUNT(*) as pass_count FROM student_marks WHERE pass_status = 'Pass'";
    $fail_count_query = "SELECT COUNT(*) as fail_count FROM student_marks WHERE pass_status = 'Fail'";

    // Execute the queries
    $pass_count_result = mysqli_query($connection, $pass_count_query);
    $fail_count_result = mysqli_query($connection, $fail_count_query);

    if ($pass_count_result && $fail_count_result) {
        // Get the pass and fail counts
        $pass_count_row = mysqli_fetch_assoc($pass_count_result);
        $fail_count_row = mysqli_fetch_assoc($fail_count_result);

        $total_students = mysqli_num_rows($all_students_result);
        $pass_count = $pass_count_row['pass_count'];
        $fail_count = $fail_count_row['fail_count'];

        // Calculate pass and fail percentages
        $pass_percentage = ($total_students > 0) ? (($pass_count / $total_students) * 100) : 0;
        $fail_percentage = ($total_students > 0) ? (($fail_count / $total_students) * 100) : 0;


        // Display the statistics
        echo "<h3>Pass/Fail Statistics:</h3>";
        echo "<p>Total Students: $total_students</p>";
        echo "<p>Pass: $pass_count students ($pass_percentage%)</p>";
        echo "<p>Fail: $fail_count students ($fail_percentage%)</p>";
    } else {
        echo "Error executing the queries: " . mysqli_error($connection);
    }
}

        // Step 3: Close the database connection
        mysqli_close($connection);
        ?>
    </div>

</body>
</html>
