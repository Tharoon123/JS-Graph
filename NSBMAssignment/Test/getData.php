<?php
// Assuming you have a database connection
$db = new mysqli("localhost", "root", "password", "sensor_db");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$query = "SELECT dateTime, temp FROM data_value";
$result = $db->query($query);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$db->close();
?>
