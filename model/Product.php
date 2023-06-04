<?php 
    class Product {
        private $idPro;
        private $namePro;
        private $description;
        private $oldPrice;
        private $newPrice;
        private $amount;
        private $imgPro;
        private $idCate;

        public function __construct($idPro, $namePro, $description, $oldPrice = null, $newPrice, $amount, $imgPro, $idCate) {
            $this->idPro = $idPro;
            $this->namePro = $namePro;
            $this->description = $description;
            $this->oldPrice = $oldPrice;
            $this->newPrice = $newPrice;
            $this->amount = $amount;
            $this->imgPro = $imgPro;
            $this->idCate = $idCate;
        }
        
        public function getIdPro() {
            return $this->idPro;
        }
        
        public function setIdPro($idPro) {
            $this->idPro = $idPro;
        }
        
        public function getNamePro() {
            return $this->namePro;
        }
        
        public function setNamePro($namePro) {
            $this->namePro = $namePro;
        }
        
        public function getDescription() {
            return $this->description;
        }
        
        public function setDescription($description) {
            $this->description = $description;
        }
        
        public function getOldPrice() {
            return $this->oldPrice;
        }
        
        public function setOldPrice($oldPrice) {
            $this->oldPrice = $oldPrice;
        }
        
        public function getNewPrice() {
            return $this->newPrice;
        }
        
        public function setNewPrice($newPrice) {
            $this->newPrice = $newPrice;
        }
        
        public function getAmount() {
            return $this->amount;
        }
        
        public function setAmount($amount) {
            $this->amount = $amount;
        }
        
        public function getImgPro() {
            return $this->imgPro;
        }
        
        public function setImgPro($imgPro) {
            $this->imgPro = $imgPro;
        }
        
        public function getIdCate() {
            return $this->idCate;
        }
        
        public function setIdCate($idCate) {
            $this->idCate = $idCate;
        }
        
        public static function getAllProducts() {
            try {
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("SELECT * from product");
                $stdm->execute();
                $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
                return $list;
            } catch (PDOException $e) {
                // Xử lý ngoại lệ
                echo "Lỗi: " . $e->getMessage();
            }
            
            
        }

        public static function getAllProductByType($type){
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from product where idCate = :idCate");
            $stdm->bindParam(":idCate",$type);
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }

        public static function getAllProductWhenSearch($key){
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * FROM product WHERE namePro LIKE :search");
            $stdm->execute(array(':search' => '%'.$key.'%'));
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }

        public static function getDetailProduct($idkey){
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from product where idPro = :idPro");
            $stdm->bindValue(":idPro", intval($idkey), PDO::PARAM_INT);
            $stdm->execute();
            $list = $stdm->fetch(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function getRelatedProducts($idkey,$idPro) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * FROM `product` WHERE idCate =:idCate and idPro <> :idPro");
            $stdm->bindParam(":idCate",$idkey);
            $stdm->bindParam(":idPro",$idPro);
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function getProductWhenHaveID($idPro) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from product where idPro =:idPro");
            $stdm->bindParam(":idPro",$idPro);
            $stdm->execute();
            $list = $stdm->fetch(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function addProduct($namePro, $description, $oldPrice, $newPrice, $amount,$imgPro, $idCate,$dvt) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("
                INSERT INTO `product` (`idPro`, `namePro`, `decription`, `oldPrice`, `newPrice`, `amount`, `imgPro`, `idCate`,`status`,`dvt`) VALUES (NULL, :namePro, :decription, :oldPrice, :newPrice, :amount, :imgPro,:idCate,'Show',:dvt)");
            $stdm->bindParam(":namePro",$namePro);
            $stdm->bindParam(":decription",$description);
            $stdm->bindParam(":oldPrice",$oldPrice);
            $stdm->bindParam(":newPrice",$newPrice);
            $stdm->bindParam(":amount",$amount);
            $stdm->bindParam(":imgPro",$imgPro);
            $stdm->bindParam(":idCate",$idCate);
            $stdm->bindParam(":dvt",$dvt);
            $stdm->execute();
        }
        public static function updateProductById($idPro,$namePro, $description, $oldPrice, $newPrice, $amount,$imgPro, $idCate,$status,$dvt) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("UPDATE `product` SET  `namePro`=:namePro,`decription`= :decription,`oldPrice`= :oldPrice,`newPrice`= :newPrice,`amount`= :amount,  `imgPro`=:imgPro, `idCate`=:idCate,`status`=:status,`dvt`=:dvt   WHERE `product`.`idPro` = :idPro;");
            $stdm->bindParam(":idPro",$idPro);
            $stdm->bindParam(":namePro",$namePro);
            $stdm->bindParam(":decription",$description);
            $stdm->bindParam(":oldPrice",$oldPrice);
            $stdm->bindParam(":newPrice",$newPrice);
            $stdm->bindParam(":amount",$amount);
            $stdm->bindParam(":imgPro",$imgPro);
            $stdm->bindParam(":idCate",$idCate);
            $stdm->bindParam(":status",$status);
            $stdm->bindParam(":dvt",$dvt);
            $stdm->execute();
        }
        public static function deleteProductById($idPro) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("DELETE from product where idPro =:idPro");
            $stdm->bindParam(":idPro",$idPro);
            $stdm->execute();
        }
        public static function updateProductAmount($idPro,$amount) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("UPDATE `product` SET `amount`= :amount WHERE `product`.`idPro` = :idPro;");
            $stdm->bindParam(":amount",$amount);
            $stdm->bindParam(":idPro",$idPro);
            $stdm->execute();
        }
    }
    

?>