<?php
    $connection = new mysqli('localhost', 'root', '', 'websitedetector');
    if($connection->connect_error) {
        echo $connection->connect_error;
    }
