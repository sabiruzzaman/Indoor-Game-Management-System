<?php
include_once "database.php";

// Get data from the form
$gameName = $_POST["game_name"];
$gameType = $_POST["game_type"];
$boardNumber = $_POST["board_number"];
$maxPlayers = $_POST["max_players"];

// Check if game_name already exists
$checkQuery = "SELECT game_name FROM games WHERE game_name = '$gameName'";
$checkResult = $con->query($checkQuery);

if ($checkResult->num_rows > 0) {
    // Duplicate game_name found, show an error alert
    echo "<script>
            alert('Error: Game with the same name already exists.');
            window.history.back(); // Go back to the previous page
          </script>";
} else {
    // Insert data into the games table
    $insertQuery = "INSERT INTO games (game_name, game_type, board_number, max_players) VALUES ('$gameName', '$gameType', $boardNumber, $maxPlayers)";

    if ($con->query($insertQuery) === true) {
        // Data stored successfully, now show an alert using JavaScript
        echo "<script>
                alert('Game registered successfully');
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
