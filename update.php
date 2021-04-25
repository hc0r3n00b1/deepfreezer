<?php
    include 'db_connect.php';

    $inventoryChange = $_GET["inventoryChange"];
    $buttonPressed = $_GET["buttonPressed"];
    $itemID = $_GET["itemID"];
    
    $sql = "SELECT itemQty FROM inventory WHERE id=$itemID";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $currentQty = $row["itemQty"];

    if ($buttonPressed == "minus") {
        $newQty = (int)$currentQty - (int)$inventoryChange;
        $sql = "UPDATE inventory SET itemQty=$newQty WHERE id=$itemID";
    
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
        echo "Error updating record: " . $conn->error;
        }
    } elseif ($buttonPressed == "plus") {
        $newQty = (int)$currentQty + (int)$inventoryChange;
        $sql = "UPDATE inventory SET itemQty=$newQty WHERE id=$itemID";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
        elseif ($buttonPressed == "delete") {
            $sql = "DELETE FROM inventory WHERE ID=$itemID";
    
            if ($conn->query($sql) === TRUE) {
                $msg = "Item Deleted from Database.";
header("Location:index.php?msg=$msg");
            } else {
                echo "Error updating record: " . $conn->error;
            }
    }

    $conn->close();
    ?> 