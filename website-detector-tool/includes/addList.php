<?php
    if(isset($_POST["detect"])) {
        $url = $_POST["url"];
        $duration = $_POST["duration"];
        if(empty($url) || empty($duration)) {
            header('Location: ../index.php');
        } else {
            require_once("conn.php");
            $sqlInsert = "INSERT INTO `list`(`url`, `duration`) VALUES ('$url', '$duration');";
            $resultInsert = $connection->query($sqlInsert)
                or die ("Problem with query! " . $connection->error);
            if($resultInsert) {
                header("Location: ../index.php?AddedSuccessfully");
            }
        }
    }
