<?php
    include 'db_connect.php';

    $unitType = $_GET["unitName"];
    
    $sql = "INSERT INTO units (unitType)
    VALUES ('$unitType')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    ?> 