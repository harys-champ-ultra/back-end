<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="wrap">
        <div class="wrap-white">
            <h1>Tool</h1>
            <h2>Website Detector</h2>
            <p>The tool refreshes every given specific time to check and detect any update in the Website by giving URL.</p>
            <form action="./includes/addList.php" method="post">
                <input type="url" name="url" id="url" placeholder="http://example.com" required>
                <input type="number" name="duration" id="duration" min="0" placeholder="0s" required>
                <input type="submit" value="Detect" name="detect">
            </form>
        </div>
        <div class="wrap-green" id="list">
            <h2>URL List</h2>
            <?php
            require_once("./includes/conn.php");
            $sqlSelect = "SELECT * FROM `list`;";
            $resultSelect = $connection->query($sqlSelect);

            if ($resultSelect) {
                while ($row = $resultSelect->fetch_assoc()) {
            ?>
                    <div class="list">
                        <p>URL: <span><a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['url']; ?></a></span></p>
                        <p>Duration: <span><?php echo $row['duration']; ?>s</span></p>
                        <?php
                        $url = $row["url"];
                        $duration = $row["duration"];
                        $requestURL = $_SERVER["REQUEST_URI"];
                        header("Refresh:" . $duration . "; URL=$requestURL");
                        $contents = @file_get_contents($url);
                        $hash = @file_get_contents("./data/hash" . $row["listid"]);
                        
                        if ($hash === ($pageHash = md5($contents))) {
                        ?>
                            <p>Status: <span class="same">Same</span></p>
                        <?php
                        } else {
                            $file = fopen("./data/hash" . $row["listid"], "w");
                            if ($file) {
                                fwrite($file, $pageHash);
                                fclose($file);
                            }
                        ?>
                            <p>Status: <span class="update">Update</span></p>
                            <script>
                                const success = new Audio("./sounds/success.mp3");
                                success.play();
                            </script>
                        <?php
                        }
                        ?>
                        <button onclick="window.location.href='./includes/deleteList.php?listid=<?php echo $row['listid']; ?>'">Delete</button>
                    </div>
            <?php
                }
            } else {
                echo "<p>List is Empty!</p>";
            }
            $connection->close();
            ?>
        </div>
    </div>
</body>
</html>
