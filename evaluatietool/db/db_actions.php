<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bachelorproef";

function create_tables()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `participants` (
                participant_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                gender VARCHAR(255) NOT NULL,
                age INT NOT NULL,
                expertise BOOL NOT NULL,
                colorblind BOOL NOT NULL,
                bad_vision BOOL NOT NULL
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Participants failed: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `images` (
                image_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL,
                extension INT NOT NULL
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Images failed: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `ratings` (
                participant_id INT NOT NULL,
                image_id INT NOT NULL,
                sharpness INT NOT NULL,
                color_contrast INT NOT NULL,
                general INT NOT NULL,
                primary key (participant_id, image_id)
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Ratings failed: " . $conn->error);
    }

    $conn->close();
}

function create_user($gender, $age, $expertise, $colorblind, $bad_vision)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO participants(gender, age, expertise, colorblind, bad_vision) VALUES ('$gender', '$age', '$expertise', '$colorblind', '$bad_vision')";

    $participant_id = false;

    if ($conn->query($sql) !== TRUE) {
        die("insert user failed: " . $conn->error);
    } else {
        $participant_id = $conn->insert_id;
    }

    $conn->close();
    return $participant_id;
}
