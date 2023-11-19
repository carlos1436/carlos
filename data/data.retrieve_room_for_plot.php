<?php
// DATABASE CONNECTION
include_once("database.php");



$retrieve_room_for_plot = $conn->prepare("
                SELECT *
                FROM room
                ORDER BY room_name ASC");
$retrieve_room_for_plot->execute();
echo '
                <option value="">Select Room</option>
            ';
while ($row = $retrieve_room_for_plot->fetch()) {
    echo '
                    <option value="' . $row["room_name"] . '">' . $row["room_name"] . '</option> 
                ';
}



$retrieve_room_for_plot = null;
$conn = null;