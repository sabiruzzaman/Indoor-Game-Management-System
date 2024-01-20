<?php
include_once 'database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot Booking</title>
    <!-- Bootstrap CDN Link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Ubuntu Font CDN Link -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            /* Set a light background color */
            font-family: 'Ubuntu', sans-serif;
            /* Use the Ubuntu font */
        }

        .card {
            border-radius: 16px;
            margin-bottom: 30px;
        }

        .slot-btn {
            margin: 5px;
            padding: 10px;
            color: #007bff;
            transition: color 0.3s ease;
        }

        .slot-btn:hover {
            color: white;
        }
    </style>

</head>

<body class="bg-light">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Slot Booking</h1>
                    </div>
                    <div class="card-body">
                        <form action="book_slot.php" method="post" onsubmit="return validateSlot()">

                            <div class="form-group">
                                <label for="booking_game_type" class="font-weight-bold">Game Type:</label>
                                <select class="form-control" onchange="getGames()" name="booking_game_type"
                                    id="booking_game_type" required>
                                    <option value="" selected disabled>Select Game Type</option>
                                    <option value="1">Board Games</option>
                                    <option value="2">Card Games</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="booking_game_name" class="font-weight-bold">Game Name:</label>
                                <select class="form-control" name="booking_game_name" id="booking_game_name" required>
                                    <option value="" selected disabled>Select Game</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="booking_date" class="font-weight-bold">Date:</label>
                                <input type="date" class="form-control" name="booking_date" required>
                            </div>

                            <div class="form-group">
                                <label for="student_id" class="font-weight-bold">Student ID:</label>
                                <input type="text" class="form-control" name="student_id" required>
                            </div>

                            <div id="slotResults">
                                <p class="mb-2"><strong>Available Slots:</strong></p>

                                <div class="d-flex justify-content-center flex-wrap">
                                    <!-- Slots are statically added here -->
                                    <button type="button" class="btn btn-outline-primary slot-btn"
                                        data-value="1">Slot - 1 | Time: 10-11 AM</button>
                                    <button type="button" class="btn btn-outline-primary slot-btn"
                                        data-value="2">Slot - 2 | Time: 11-12 AM</button>
                                    <button type="button" class="btn btn-outline-primary slot-btn"
                                        data-value="3">Slot - 3 | Time: 02-03 PM</button>
                                    <button type="button" class="btn btn-outline-primary slot-btn"
                                        data-value="4">Slot - 4 | Time: 03-04 PM</button>
                                    <button type="button" class="btn btn-outline-primary slot-btn"
                                        data-value="5">Slot - 5 | Time: 04-05 PM</button>
                                    <button type="button" class="btn btn-outline-primary slot-btn"
                                        data-value="6">Slot - 6 | Time: 05-06 PM</button>
                                </div>
                            </div>

                            <div id="error-message" style="color: red;"></div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg"
                                style="margin-top: 30px;">Book Slot</button>

                            <input type="hidden" name="selectedSlot" id="selectedSlot" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery CDN links (required for Bootstrap features) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function inItSlots() {
            var slotButtons = document.querySelectorAll('.slot-btn');

            slotButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    slotButtons.forEach(function (btn) {
                        btn.classList.remove('btn-primary');
                        btn.style.color = '#007bff';
                    });
                    this.classList.add('btn-primary');
                    this.style.color = 'white';
                    document.querySelector('[name="selectedSlot"]').value = this.getAttribute('data-value');
                });

                button.addEventListener('mouseover', function () {
                    // Change color to white when the mouse is over the button
                    if (!this.classList.contains('btn-primary')) {
                        this.style.color = 'white';
                    }
                });

                button.addEventListener('mouseout', function () {
                    // Change color back to the original color when the mouse leaves the button
                    if (!this.classList.contains('btn-primary')) {
                        this.style.color = '#007bff';
                    }
                });
            });
        }

        function validateSlot() {
            var selectedSlot = document.querySelector('[name="selectedSlot"]').value;
            var errorMessage = document.getElementById('error-message');
            if (!selectedSlot) {
                errorMessage.textContent = 'Please select a slot.';
                event.preventDefault();
            } else {
                errorMessage.textContent = '';
            }
        }

        inItSlots();

        function getGames() {
            var dropdown = document.getElementById("booking_game_name");
            dropdown.innerHTML = '';
            var defaultOption = document.createElement("option");
            defaultOption.text = "Select Game";
            defaultOption.value = "";
            defaultOption.disabled = true;
            dropdown.add(defaultOption);

            var selectedValue = document.getElementById("booking_game_type").value
            var url = window.location.href

            if (url.includes('type')) {
                var newUrl = url.replace(new RegExp("type=[0-9]"), 'type=' + selectedValue)
                window.location.href = newUrl

            } else {
                window.location.href = window.location.href + "?type=" + selectedValue;
            }
        }

        <?php
        $t = $_GET['type'] ?? '';
        if ($t) {
            $qu = "SELECT * FROM games WHERE game_type= $t";
            $result = $con->query($qu);
            echo 'var options = []';
            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        var option = document.createElement('option');
                        option.value = {$row['game_type']};
                        option.text = '{$row['game_name']}';
                        options.push(option)
                    ";
                }
            }

            echo '
            options.forEach(it => {
                document.getElementById("booking_game_name").appendChild(it)
            });
            
            ';
            echo 'document.getElementById("booking_game_type").value = '; echo $t;

        }
         
        ?>
    </script>
</body>

</html>
