<?php 
require('config.php');
$name = $_POST['name'];
    $parentid = $_POST['parentid'];
    try {
        $insert = "INSERT INTO members (Name, ParentId, CreatedDate)
                       VALUES (:name, :parentid,now())";
        $query = $conn->prepare($insert);
        $query->execute(array(':name' => $name, ':parentid' => $parentid,));
        if ($query->rowCount() == 1) {
            // echo "<p>Insert Successfull</p>";
        }
    } catch (PDOException $e) {
        echo  "<p>An error occured: " . $e->getMessage() . "</p>";
        exit;
    }
?>