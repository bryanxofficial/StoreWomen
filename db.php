<?php
function connectToDatabase() {
    $servername = "srv1061.hstgr.io"; // Your database host
    $username = "u974074198_chess";    // Your database username
    $password = "Feliz2025@";    // Your database password
    $dbname = "u974074198_chess"; // Your database name

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>