<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "supermarket";
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo "Kết nối thành công";
    } catch(PDOException $e) {
      echo "Kết nối thất bại: " . $e->getMessage();
    }
?>