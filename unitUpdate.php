<?php
    include 'db_connect.php';

    $ID = $_GET["ID"];
    
    $sql = "DELETE FROM units WHERE unitID=$ID";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
  $msg = "Cannot Delete Unit, Please remove item that is using unit.";
header("Location:index.php?msg=$msg");
}

    $conn->close();
    ?> 