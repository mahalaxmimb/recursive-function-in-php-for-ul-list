<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mahalaxmi";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function membertree($parentId)
{
    global $conn;

    $data = $conn->prepare("SELECT * FROM members WHERE ParentId = :parentId");
    $data->bindParam(':parentId', $parentId);
    $data->execute();

    while($row = $data->fetch(PDO::FETCH_ASSOC)){
        $i = 0;
        if($i == 0) echo '<ul>';
        echo '<li id='.$row['Id'].'>'.$row['Name'];
        membertree($row['Id']);
        echo '</li>';
        $i++;
        if($i >0 ) echo '</ul>';
    }
}
