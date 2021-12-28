<?php
    function db_connect() {
        $dbHost = "ID331293_sortinghat.db.webhosting.be";
        $dbUsername = "ID331293_sortinghat";
        $dbName = "ID331293_sortinghat";
        $dbPassword = "sortinghat123";

        $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

        if ($conn == false){
            die("connection failed");
        }
        return $conn;
    }

    function getQuery($sql) {
        $conn = db_connect();
        $result = mysqli_query($conn, $sql);
        // var_dump($result->fetch_all(MYSQLI_ASSOC));
        $conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function insertQuery($sql) {
        $conn = db_connect();
        $result = mysqli_query($conn, $sql);
        $conn->close();
        return $result;
    }
?>