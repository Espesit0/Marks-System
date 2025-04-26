<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Student Information</title>
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

    </style>
</head>
<body>
   <div class="container">
        <h2>Search and View Student Information</h2>
            <div class="container">
        <h2>View Student Information</h2>

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

        // Step 2: Search student information based on user input
        if (isset($_POST['search'])) {
            $search_input = mysqli_real_escape_string($connection, $_POST['search_input']);

            // Construct the SQL query to search for student information
            $query = "SELECT * FROM student_marks WHERE student_name LIKE '%$search_input%' OR student_id LIKE '%$search_input%'";

            $result = mysqli_query($connection, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    // Display the search results in a table
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Student ID</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Course ID</th>";
                    echo "<th>Total Marks</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['student_name'] . "</td>";
                        echo "<td>" . $row['course_id'] . "</td>";
                        echo "<td>" . $row['total_marks'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p class='no-data'>No matching student found.</p>";
                }
            } else {
                echo "Error executing the query: " . mysqli_error($connection);
            }
        } else {
            // Step 3: Fetch all student information if no search is performed
            $query = "SELECT * FROM student_marks";

            $result = mysqli_query($connection, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    // Display the table header
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Student ID</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Course ID</th>";
                    echo "<th>Total Marks</th>";
                    echo "</tr>";

                    // Display the table rows with student information
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['student_name'] . "</td>";
                        echo "<td>" . $row['course_id'] . "</td>";
                        echo "<td>" . $row['total_marks'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    // Display a message if no student information found
                    echo "<p class='no-data'>No student information found.</p>";
                }
            } else {
                // Display an error message if the query fails
                echo "Error executing the query: " . mysqli_error($connection);
            }
        }

        // Step 4: Close the database connection
        mysqli_close($connection);
        ?>
    </div>
</body>
</html>