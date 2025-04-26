<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Student Information</title>
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

        input[type="text"] {
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

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        
       

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

// Step 2: Handle student deletion
if (isset($_POST['delete']) && isset($_POST['student_id'])) {
    $student_id = (int)$_POST['student_id'];

    // Step 3: Construct the SQL DELETE query
    $delete_query = "DELETE FROM student_marks WHERE student_id = $student_id";

    // Step 4: Execute the DELETE query
    if (mysqli_query($connection, $delete_query)) {
        echo "<div class='result success'>Student profile deleted successfully.</div>";
    } else {
        echo "<div class='result error'>Error deleting student profile: " . mysqli_error($connection) . "</div>";
    }
}

// Step 5: Construct the SQL SELECT query to retrieve all student records
$select_query = "SELECT * FROM student_marks";

// Check if a search is performed
if (isset($_POST['search']) && !empty($_POST['search_query'])) {
    $search_query = $_POST['search_query'];
    $select_query = "SELECT * FROM student_marks WHERE student_name LIKE '%$search_query%'";
}

// Step 6: Execute the SELECT query
$result = mysqli_query($connection, $select_query);

?>

<div class="container">
    <h2>Student Information</h2>

    <form method="post">
        <label for="search_query">Search by Student Name:</label>
        <input type="text" id="search_query" name="search_query" placeholder="Enter student name">
        <button type="submit" name="search">Search</button>
    </form>
     <form action="newdashboard.php">
            <button type="submit">Home</button>
        </form>

    <?php
    // Check if the query was successful
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Display the search results in a table
            echo "<table>";
            echo "<tr>";
            echo "<th>Student ID</th>";
            echo "<th>Student Name</th>";
            echo "<th>Course ID</th>";
            echo "<th>Total Marks</th>";
            echo "<th>Delete</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['student_id'] . "</td>";
                echo "<td>" . $row['student_name'] . "</td>";
                echo "<td>" . $row['course_id'] . "</td>";
                echo "<td>" . $row['total_marks'] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='student_id' value='" . $row['student_id'] . "'>";
                echo "<button type='submit' name='delete'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p class='no-data'>No matching student found.</p>";
        }
    } else {
        echo "Error executing the query: " . mysqli_error($connection);
    }

    // Step 7: Close the database connection
    mysqli_close($connection);
    ?>
</div>
</body>
</html>
    </div>
</body>
</html>
