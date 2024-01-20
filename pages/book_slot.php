<?php
include_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $gameType = $_POST["booking_game_type"];
    $gameId = $_POST["booking_game_name"];
    $bookingDate = $_POST["booking_date"];
    $studentId = $_POST["student_id"];
    $slotId = $_POST["selectedSlot"]; // Assuming you have a hidden input field for the selected slot

    // Check if the student is valid
    $studentQuery = "SELECT * FROM students WHERE student_id = '$studentId'";
    $studentResult = $con->query($studentQuery);

    if ($studentResult->num_rows > 0) {
        // Check if the slot is available
        $gamesQuery = "SELECT * FROM games WHERE id = '$gameId'";
        $gameResult = $con->query($gamesQuery);

        if ($gameResult->num_rows > 0) {
            $row = $gameResult->fetch_assoc();

            $maxEntry = (int) $row["board_number"] * (int) $row["max_players"];

            $slotCountQuery = "SELECT count(*) FROM slot_booking WHERE game_type = '$gameType' AND game_id = '$gameId' AND booking_date = '$bookingDate' AND slot_id = '$slotId'";
            $slotCountResult = $con->query($slotCountQuery);

            if ($slotCountResult === false) {
                // Handle query execution error
                echo "<script>alert('Error executing query: " .
                    $con->error .
                    "');</script>";
            } else {
                $slotCountFetch = $slotCountResult->fetch_assoc();

                if ($slotCountFetch) {
                    $a = $slotCountFetch["count(*)"];

                    if ($a < $maxEntry) {
                        // Book the slot
                        $bookSlotQuery = "INSERT INTO slot_booking (student_id, game_id, booking_date, slot_id, game_type)
                                          VALUES ('$studentId', '$gameId', '$bookingDate', '$slotId', '$gameType')";

                        if ($con->query($bookSlotQuery) === true) {
                            // Alert message

                            echo "<script>
                            alert('Slot booked successfully!');
                            window.location.href = 'home.html';
                          </script>";
                        } else {
                            // Alert message

                            echo "<script>
                            alert('Error booking slot: " .
                                $con->error .
                                "');
                            window.history.back();
                          </script>";
                        }
                    } else {
                        // Alert message
                        // echo "<script>alert('Slot is not available.');</script>";

                        echo "<script>
                        alert('Slot is not available.');
                        window.history.back(); 
                      </script>";
                    }
                } else {
                    // Handle no results returned
                    echo "<script>alert('No results found.');</script>";
                }
            }
        } else {
            // Alert message
            echo "<script>alert('Invalid game ID.');</script>";
        }
    } else {
        echo "<script>
        alert('Invalid student ID. Please register a student.');
        window.location.href = 'home.html';
      </script>";
    }
} else {
    // Alert message
    echo "<script>alert('Invalid request.');</script>";
}
?>
