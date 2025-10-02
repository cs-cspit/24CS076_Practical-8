<?php
include 'db_connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ---- Handle Update ----
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];

    if(!empty($name) && !empty($date)) {
        $stmt = $conn->prepare("UPDATE events SET name=?, event_date=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $date, $id);
        if($stmt->execute()) {
            echo "<p style='color:green;'>Event updated successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Please fill in all fields.</p>";
    }
}

// ---- Determine which event to edit ----
$event = null;

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM events WHERE id=$id");
    $event = $result->fetch_assoc();
}

// ---- If no ID provided, show dropdown to select event ----
$all_events = $conn->query("SELECT * FROM events ORDER BY event_date DESC");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Event</title>
</head>
<body>
<h2>Update Event</h2>

<!-- Select Event if no ID passed -->
<?php if(!$event && $all_events->num_rows > 0): ?>
<form method="get" action="">
    <label>Select Event to Edit:</label>
    <select name="id" required>
        <option value="">--Select--</option>
        <?php while($row = $all_events->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " (" . $row['event_date'] . ")"; ?></option>
        <?php endwhile; ?>
    </select>
    <input type="submit" value="Edit">
</form>
<?php elseif(!$event): ?>
<p>No events available to edit.</p>
<?php endif; ?>

<!-- Edit Form -->
<?php if($event): ?>
<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
    Event Name: <input type="text" name="name" value="<?php echo $event['name']; ?>" required><br><br>
    Event Date: <input type="date" name="date" value="<?php echo $event['event_date']; ?>" required><br><br>
    <input type="submit" name="update" value="Update Event">
</form>
<?php endif; ?>

<br>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
