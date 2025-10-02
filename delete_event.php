<?php
include 'db_connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ---- Handle Deletion ----
if(isset($_POST['delete'])) {
    $id = $_POST['id'];

    if(!empty($id)) {
        $stmt = $conn->prepare("DELETE FROM events WHERE id=?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()) {
            echo "<p style='color:green;'>Event deleted successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// ---- Fetch all events for dropdown ----
$all_events = $conn->query("SELECT * FROM events ORDER BY event_date DESC");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Event</title>
</head>
<body>
<h2>Delete Event</h2>

<?php if($all_events->num_rows > 0): ?>
<form method="post" action="">
    <label>Select Event to Delete:</label>
    <select name="id" required>
        <option value="">--Select--</option>
        <?php while($row = $all_events->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['name'] . " (" . $row['event_date'] . ")"; ?>
            </option>
        <?php endwhile; ?>
    </select>
    <input type="submit" name="delete" value="Delete Event" onclick="return confirm('Are you sure you want to delete this event?')">
</form>
<?php else: ?>
<p>No events available to delete.</p>
<?php endif; ?>

<br>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
