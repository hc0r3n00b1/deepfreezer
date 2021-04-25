<?php
    include 'db_connect.php';

    $itemName = $_GET["itemName"];
    $initQty = $_GET["initQty"];
    $inventoryType = $_GET["inventoryType"];
    
    
$sql = "INSERT INTO inventory (itemName, itemQty, unitID)
VALUES ('$itemName','$initQty','$inventoryType')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
  $msg = "Unable to add item, Make sure their is a valid Item type.";
  header("Location:index.php?msg=$msg");
}

    $conn->close();
    ?> 