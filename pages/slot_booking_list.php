<?php
include_once 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Indoor Game Management System</title>

    <!-- Add Bootstrap CSS link -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    />

    <!-- Ubuntu Font CDN Link -->
    <link
      href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <!-- CSS Link -->
    <link rel="stylesheet" href="../assets/css/booking_slot_list_page.css" />
  </head>

  <body>
    <div class="container">
      <div class="row justify-content-center mt-2">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <div class="logo-container text-center mb-6">
                <img
                  src="../assets/images/logo.png"
                  alt="seu logo"
                  class="logo-img"
                />
              </div>

              <h1 class="card-title text-center">
                Indoor Game Management System
              </h1>

              <p class="text-center">Slot Booking List</p>


              <div class="tableWrapper">
              <table class="table">
                <thead>
                  <tr>
                    <th>Student Name</th>
                    <th>Game Name</th>
                    <th>Booking Date</th>
                    <th>Slots</th>
                  </tr>
                </thead>
                <tbody>
             
                  <?php
include "helper.php";
// SQL query to retrieve data
$sql = "SELECT * FROM slot_booking";
$result = get($con, $sql);
// Output data from database
if ($result != "") {
    while ($row = $result->fetch_assoc()) {
        $sid = (int)$row["student_id"];
        $gid = (int)$row["game_id"];
        $sql = "SELECT student_name FROM students WHERE student_id = " . $sid;
        $stdResutl = getSingle($con, $sql);
        $gSql = "SELECT game_name FROM games WHERE id = " . $gid;
        $gameResutl = getSingle($con, $gSql);
        $slotName = getSlotName((int)$row["slot_id"]);
        echo "<tr><td>" . $stdResutl['student_name'] . "</td><td>" . $gameResutl['game_name'] . "</td><td>" . $row["booking_date"] . "</td><td>" . $slotName . "</td></tr>";
    }
} else {
    echo "<tr><td style='text-align:center' colspan='4'>No data available</td></tr>";
}
?>




                </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
