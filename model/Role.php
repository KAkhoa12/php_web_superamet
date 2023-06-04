<?php
    class Role{
        public static function getAllRole() {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from Role ");
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
    }
?>