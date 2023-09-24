<?php
    if(isset($_GET["listid"])) {
        require_once("conn.php");
        $listid = $_GET["listid"];
        $sqlDelete = "DELETE FROM `list` WHERE `listid`='$listid'";
        $resultDelete = $connection->query($sqlDelete)
            or die ("Problem with query! " . $connection->error);
        if($resultDelete) {
            $file = fopen("../data/hash".$listid, "w");
            $hash = @file_get_contents("../data/hash".$listid);
            fwrite($file, $hash);
            fclose($file);
            unlink("../data/hash".$listid);
            header("Location: ../index.php?DeletedSuccessfully");
        } else {
            echo "Delete Failed!";
        }
    }
