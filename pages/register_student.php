<?php
include_once "database.php";

// Get data from the form
$studentName = $_POST["student_name"];
$studentId = $_POST["student_id"];
$batchNo = $_POST["batch_no"];
$department = $_POST["department"];

// Check if student_id already exists
$checkQuery = "SELECT student_id FROM students WHERE student_id = '$studentId'";
$checkResult = $con->query($checkQuery);

if ($checkResult->num_rows > 0) {
    // Duplicate student_id found, show an error alert
    echo "<script>
            alert('Error: Student with the same ID already exists.');
            window.history.back(); // Go back to the previous page
          </script>";
} else {
    // Insert data into the students table
    $insertQuery = "INSERT INTO students (student_name, student_id, batch_no, department) VALUES ('$studentName', '$studentId', '$batchNo', '$department')";

    if ($con->query($insertQuery) === true) {
        // Data stored successfully, now show an alert using JavaScript
        echo "<script>
                alert('Student registered successfully');
                window.location.href = 'home.html'; // Replace 'your_target_page.html' with the actual page you want to redirect to
              </script>";
    } else {
        // Error occurred during insertion, show an alert with the error message
        echo "<script>
                alert('Error: " .
            $con->error .
            "');
                window.history.back(); // Go back to the previous page
              </script>";
    }
}

?>
