<?php
include 'db_connect.php';

if(isset($_POST['submit'])) {
    $event_name = $_POST['name'];
    $event_date = $_POST['date'];

    // Validate input
    if(empty($event_name) || empty($event_date)) {
        echo "Please fill in all fields.";
    } else {
        $sql = "INSERT INTO events (name, event_date) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $event_name, $event_date);

        if($stmt->execute()) {
            echo "Event added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
</head>
<body>
    <h2>Add New Event</h2>
    <form method="post" action="">
        Event Name: <input type="text" name="name" required><br><br>
        Event Date: <input type="date" name="date" required><br><br>
        <input type="submit" name="submit" value="Add Event">
    </form>
</body>
</html>
