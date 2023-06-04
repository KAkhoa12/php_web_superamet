<?php 
    class Category {
        private $idCate;
        private $nameCate;

        public function __construct($idCate, $nameCate) {
            $this->idCate = $idCate;
            $this->nameCate = $nameCate;
        }
        
        public function getIdCate() {
            return $this->idCate;
        }
        
        public function setIdCate($idCate) {
            $this->idCate = $idCate;
        }

        public function getNameCate() {
            return $this->nameCate;
        }
        
        public function setNameCate($nameCate) {
            $this->nameCate = $nameCate;
        }
        public static function getAllCategory() {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from category");
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function getCategoryName($idCate) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT `nameCategory` from category where idCate= :idCate");
            $stdm->bindParam(":idCate",$idCate);
            $stdm->execute();
            $list = $stdm->fetch(PDO::FETCH_ASSOC);
            return $list;
        }
        
    }
    

?>