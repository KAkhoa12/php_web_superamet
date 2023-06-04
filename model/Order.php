<?php
    class Order {
        private $idOrder;
        private $idUser;
        private $sumMoney;
    
        public function __construct($idOrder, $idUser, $invoiceDate, $sumMoney) {
            $this->idOrder = $idOrder;
            $this->idUser = $idUser;
            $this->invoiceDate = $invoiceDate;
            $this->sumMoney = $sumMoney;
        }
    
        public function getIdOrder() {
            return $this->idOrder;
        }
    
        public function setIdOrder($idOrder) {
            $this->idOrder = $idOrder;
        }
    
        public function getIdUser() {
            return $this->idUser;
        }
    
        public function setIdUser($idUser) {
            $this->idUser = $idUser;
        }
        public function getSumMoney() {
            return $this->sumMoney;
        }
        public function setSumMoney($sumMoney) {
            $this->sumMoney = $sumMoney;
        } 

        public static function addOrderForUser($idUser) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("INSERT INTO `order` (`idOder`, `idUser`, `sumMoney`) VALUES (NULL, :idUser, '');");
            $stdm->bindValue(":idUser",$idUser);
            $stdm->execute();
            return;
        } 

        public static function updateTotalByOrder($total,$idOrder) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("UPDATE `order` set `sumMoney` = :total,`dayCreate`=NOW() WHERE `idOder`=:idOrder;");
            $stdm->bindParam(":total",$total);
            $stdm->bindParam(":idOrder",$idOrder);
            $stdm->execute();
            return;
        } 
        public static function getOrderByIdUser($idUser) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("
                SELECT DISTINCT `order`.idOder, `order`.`dayCreate`,`order`.`idUser`,`order`.`sumMoney`
                FROM `order`, `detailOrder`
                WHERE `idUser` = :idUser AND `order`.idOder = `detailOrder`.idOder AND `status` = 'Confirmed';");
                $stdm->bindParam(":idUser",$idUser);
                $stdm->execute();
                $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
                return $list;
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }
    
?>
