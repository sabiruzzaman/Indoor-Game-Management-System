<?php
function get($con, $sql) {
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    }
    return "";
}
function getSingle($con, $sql) {
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return "";
}
function getSlotName($slotId) {
    if ($slotId != 0) {
        switch ($slotId) {
            case 1:
                return "Slot - 1 | Time: 10-11 AM";
            break;
            case 2:
                return "Slot - 2 | Time: 11-12 AM";
            break;
            case 3:
                return "Slot - 3 | Time: 02-03 PM";
            break;
            case 4:
                return "Slot - 4 | Time: 03-04 PM";
            break;
            case 5:
                return "Slot - 5 | Time: 04-05 PM";
            break;
            case 6:
                return "Slot - 6 | Time: 05-06 PM";
            break;
        }
    }
    return "";
}
?>