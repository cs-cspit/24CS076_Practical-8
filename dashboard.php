<?php
include 'db_connect.php';

$sql = "SELECT * FROM events ORDER BY event_date DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['name'] . " - " . $row['event_date'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No events found.";
}

$conn->close();
?>
