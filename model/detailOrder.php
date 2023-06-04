<?php 
    class detailOrder {
        private $idPro;
        private $idOrder;
        private $numPro;
        private $pricePro;
        private $status;
        private $total;
    
        public function __construct($idPro, $idOrder, $numPro, $pricePro, $status, $total) {
            $this->idPro = $idPro;
            $this->idOrder = $idOrder;
            $this->numPro = $numPro;
            $this->pricePro = $pricePro;
            $this->status = $status;
            $this->total = $total;
        }
    
        public function getIdPro() {
            return $this->idPro;
        }
    
        public function setIdPro($idPro) {
            $this->idPro = $idPro;
        }
    
        public function getIdOrder() {
            return $this->idOrder;
        }
    
        public function setIdOrder($idOrder) {
            $this->idOrder = $idOrder;
        }
    
        public function getNumPro() {
            return $this->numPro;
        }
    
        public function setNumPro($numPro) {
            $this->numPro = $numPro;
        }
    
        public function getPricePro() {
            return $this->pricePro;
        }
    
        public function setPricePro($pricePro) {
            $this->pricePro = $pricePro;
        }
    
        public function getStatus() {
            return $this->status;
        }
    
        public function setStatus($status) {
            $this->status = $status;
        }
    
        public function getTotal() {
            return $this->total;
        }
    
        public function setTotal($total) {
            $this->total = $total;
        }
        
        public static function addDetailOrderForUser($idOrder,$idPro,$numPro,$pricePro) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("INSERT INTO `detailorder` (`idOder`, `idPro`, `numPro`,`pricePro`,`status`,`total`) VALUES (:idOrder, :idPro, :numPro,:pricePro,'unconfirmed',`numPro`*`pricePro`);");
                $stdm->bindValue(":idOrder",$idOrder);
                $stdm->bindValue(":idPro",$idPro);
                $stdm->bindParam(":numPro",$numPro);
                $stdm->bindParam(":pricePro",$pricePro);
                $stdm->execute();
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function checkStatusUserOrder($idUser) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("SELECT `order`.idOder FROM `order`,`detailorder` WHERE STATUS = 'unconfirmed' and `order`.`idUser` =:idUser and  `order`.`idOder` = `detailorder`.`idOder`");
                $stdm->bindParam(":idUser",$idUser);
                $stdm->execute();
                $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
                if(count($list)>0){
                    //echo 'Có chứa danh sách ';
                    return false;
                }else{ 
                    //echo 'không chưa danh sách ';
                    return true;
                }
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }

        public static function getIdOrderUnconfirmed($idUser) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("SELECT `order`.`idOder` FROM `order`,`detailorder` WHERE status ='unconfirmed' and `idUser` = :idUser and `order`.`idOder` = `detailorder`.`idOder`;");
                $stdm->bindParam(":idUser",$idUser);
                $stdm->execute();
                $list = $stdm->fetch(PDO::FETCH_ASSOC);
                return $list;
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function getProductFromIdOrder($idOrder,$idUser) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("SELECT * FROM `detailorder`,`order`,`product` WHERE `detailorder`.`idOder`=:idOrder and `idUser` = :idUser and `detailorder`.`idOder` = `order`.`idOder`and`detailorder`.`idPro` = `product`.`idPro`;");
                $stdm->bindParam(":idOrder",$idOrder);
                $stdm->bindParam(":idUser",$idUser);
                $stdm->execute();
                $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
                return $list;
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function checkIdProInOrder($idOrder,$idPro) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("SELECT `detailorder`.idPro FROM `detailorder` WHERE`detailorder`.`idOder` =:idOrder and `detailorder`.`idPro` = :idPro");
                $stdm->bindParam(":idOrder",$idOrder);
                $stdm->bindParam(":idPro",$idPro);
                $stdm->execute();
                $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
                if(count($list) == 0){
                    return true;
                }else{ return false;}
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function updateQuantityProInOrder($idOrder,$idPro,$quantity) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("UPDATE `detailorder` SET `numPro` = :quantity,`total` =:quantity*`pricePro`  WHERE `idPro` = :idPro and `idOder` = :idOrder ");
                $stdm->bindParam(":idOrder",$idOrder);
                $stdm->bindParam(":idPro",$idPro);
                $stdm->bindParam(":quantity",$quantity);
                $stdm->execute();
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function getIdOrderNewCreate($idUser) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("SELECT idOder FROM `order` WHERE idOder NOT IN (SELECT idOder FROM `detailorder`) and `idUser` = :idUser");
                $stdm->bindParam(":idUser",$idUser);
                $stdm->execute();
                $list = $stdm->fetch(PDO::FETCH_ASSOC);
                return $list;
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function deleteProInOrder($idOrder,$idPro) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("DELETE from `detailorder` WHERE idOder = :idOrder and idPro =:idPro");
                $stdm->bindParam(":idOrder",$idOrder);
                $stdm->bindParam(":idPro",$idPro);
                $stdm->execute();
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function updateProductConfirmed($idUser,$idOrder) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("
                update `detailorder` SET `status` = 'Confirmed' WHERE `idOder`=:idOrder;");
                $stdm->bindParam(":idOrder",$idOrder);
                $stdm->execute();
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }
    
?>