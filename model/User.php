<?php 
    class User {
        private $idUser;
        private $nameUser;
        private $gender;
        private $password;
        private $idRole;
        private $dayOfBirth;
        private $email;
        private $address;
        private $phoneNumber;

        public function __construct($idUser, $nameUser, $gender, $password, $idRole, $dayOfBirth, $email, $address, $phoneNumber) {
            $this->idUser = $idUser;
            $this->nameUser = $nameUser;
            $this->gender = $gender;
            $this->password = $password;
            $this->idRole = $idRole;
            $this->dayOfBirth = $dayOfBirth;
            $this->email = $email;
            $this->address = $address;
            $this->phoneNumber = $phoneNumber;
        }
    
        public function getIdUser() {
            return $this->idUser;
        }
    
        public function setIdUser($idUser) {
            $this->idUser = $idUser;
        }
    
        public function getNameUser() {
            return $this->nameUser;
        }
    
        public function setNameUser($nameUser) {
            $this->nameUser = $nameUser;
        }
    
        public function getGender() {
            return $this->gender;
        }
    
        public function setGender($gender) {
            $this->gender = $gender;
        }
    
        public function getPassword() {
            return $this->password;
        }
    
        public function setPassword($password) {
            $this->password = $password;
        }
    
        public function getIdRole() {
            return $this->idRole;
        }
    
        public function setIdRole($idRole) {
            $this->idRole = $idRole;
        }
    
        public function getDayOfBirth() {
            return $this->dayOfBirth;
        }
    
        public function setDayOfBirth($dayOfBirth) {
            $this->dayOfBirth = $dayOfBirth;
        }
    
        public function getEmail() {
            return $this->email;
        }
    
        public function setEmail($email) {
            $this->email = $email;
        }
    
        public function getAddress() {
            return $this->address;
        }
    
        public function setAddress($address) {
            $this->address = $address;
        }
    
        public function getPhoneNumber() {
            return $this->phoneNumber;
        }
    
        public function setPhoneNumber($phoneNumber) {
            $this->phoneNumber = $phoneNumber;
        }
        public static function getUserById($idUser) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from user where idUser=:idUser");
            $stdm->bindParam(":idUser",$idUser);
            $stdm->execute();
            $list = $stdm->fetch(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function getAllUser() {
            require_once "./config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from user");
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function getAllUserByRole($idRole) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * from user where idRole =:idRole");
            $stdm->bindParam(":idRole",$idRole);
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function checkUserAccount($email,$password) {
            require_once "./config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * FROM user,role WHERE email= :email AND password = :password and user.idRole = role.idRole;");
            $stdm->bindParam(":email",$email);
            $stdm->bindParam(":password",$password);
            $stdm->execute();
            $list = $stdm->fetch(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function checkEmailUser($email) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * FROM user WHERE email= :email;");
            $stdm->bindParam(":email",$email);
            $stdm->execute();
            $list = $stdm->fetch(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function updateUserById($idUser,$nameUser,$phoneNumber,$address,$email,$dayOfBirth,$password,$gender,$idRole,$imgUser) {
            try{
                require_once "../config/config.php";
                global $conn;
                $stdm= $conn->prepare("
                UPDATE `user` SET `nameUser` = :nameUser,`phoneNumber` =:phoneNumber,`address` = :address,`email` = :email,`dayOfBirth` = :dayOfBirth,`password` = :password,`gender` = :gender,`idRole`=:idRole,`imgUser` = :imgUser  WHERE `idUser` = :idUser");
                $stdm->bindParam(":nameUser",$nameUser);
                $stdm->bindParam(":phoneNumber",$phoneNumber);
                $stdm->bindParam(":address",$address);
                $stdm->bindParam(":email",$email);
                $stdm->bindParam(":dayOfBirth",$dayOfBirth);
                $stdm->bindParam(":password",$password);
                $stdm->bindParam(":gender",$gender);
                $stdm->bindParam(":idUser",$idUser);
                $stdm->bindParam(":idRole",$idRole);
                $stdm->bindParam(":imgUser",$imgUser);
                $stdm->execute();
            }catch (PDOException $e) {
                // Xử lý lỗi khi thêm dữ liệu vào MySQL
                echo "Lỗi: " . $e->getMessage();
            }
        }
        public static function addUser($conn,$nameUser,$phoneNumber,$address,$email,$dayOfBirth,$password,$gender,$idRole,$imgUser){
            $stdm = $conn->prepare("INSERT INTO user (nameUser, email, password,idRole,dayOfBirth,gender,imgUser,address,phoneNumber) VALUES (:nameUser, :email, :password,:idRole,:dayOfBirth,:gender,:imgUser,:address,:phoneNumber);");
            $stdm->bindParam(":nameUser",$nameUser);
            $stdm->bindParam(":phoneNumber",$phoneNumber);
            $stdm->bindParam(":address",$address);
            $stdm->bindParam(":email",$email);
            $stdm->bindParam(":dayOfBirth",$dayOfBirth);
            $stdm->bindParam(":password",$password);
            $stdm->bindParam(":gender",$gender);
            $stdm->bindParam(":idRole",$idRole);
            $stdm->bindParam(":imgUser",$imgUser);
            $stdm->execute();
        } 
        public static function deleteUserById($idUser) {
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("DELETE from user where idUser =:idUser");
            $stdm->bindParam(":idUser",$idUser);
            $stdm->execute();
        }

        public static function checkPhoneNumber($conn,$phoneNumber) {
            $stdm= $conn->prepare("SELECT * FROM user WHERE phoneNumber= :phoneNumber");
            $stdm->bindParam(":phoneNumber",$phoneNumber);
            $stdm->execute();
            $list = $stdm->fetch(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function getAllUserCustomer($key){
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * FROM user WHERE nameUser LIKE :search and idRole = 3");
            $stdm->execute(array(':search' => '%'.$key.'%'));
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
        public static function getAllUserEmployee($key){
            require_once "../config/config.php";
            global $conn;
            $stdm= $conn->prepare("SELECT * FROM user WHERE nameUser LIKE :search and idRole =2");
            $stdm->execute(array(':search' => '%'.$key.'%'));
            $stdm->execute();
            $list = $stdm->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
    }
?>