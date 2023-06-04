<?php   
    $error = '';
    require_once "./config/config.php";
    session_start();
    require_once "./model/User.php";
    $count = count(User::getAllUser());
    function checkEmail($e,$db){
        $email = $db->prepare('select email from user where email= :email');
        $email->bindParam(':email', $e);
        $email->execute();
        $list = $email->fetchAll(PDO::FETCH_ASSOC);
        $count = count($list);
        if($count>0){
            return false;
        }else{
            return true;
        }
    }        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST['password'];
        $email = $_POST['email'];
        $nameUser = $_POST['username'];
        $pwdcf = $_POST['confirm_password'];
        if(checkEmail($email,$conn)){
            if($password === $pwdcf){
                try{
                    User::addUser($conn,$nameUser,'','',$email,'01-01-2000',$password,'Nam','3','defaultImg.jpg');
                    $user = User::checkUserAccount($email,$password);
                    $_SESSION["idUser"] = $user["idUser"];
                    $_SESSION["nameUser"] = $user["nameUser"];
                    $_SESSION["idRole"] = $user["idRole"];
                    $_SESSION["nameRole"] = $user["nameRole"];
                    header("Location: ./client/index.php");
                    exit();
                }catch(PDOException $e){
                    echo "Lỗi " .$e;
                }
            }else{
                $error = "Xác thực mật khẩu không đúng";
            }
        }else{
            $error = "Email đã tồn tại";
        }
    }
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./client/css/signinup.css">
</head>
<body>

<div class="loginpanel">
    <span style="color:red;"><?php echo $error ?></span>
    <form action="register.php" method="post">
        <div class="txt">
            <input id="name" name="username" type="text" placeholder="Tên người dùng" />
            <label for="name" class="entypo-user"></label>
        </div>
        <div class="txt">
            <input id="user" name="email" type="text" placeholder="Email" />
            <label for="user" class="entypo-user"></label>
        </div>
        <div class="txt">
            <input id="pwd" name="password" type="password" placeholder="Mật khẩu" />
            <label for="pwd" class="entypo-lock"></label>
        </div>
        <div class="txt">
            <input id="pwdcf" name="confirm_password" type="password" placeholder="Xác nhận mật khẩu" />
            <label for="pwdcf" class="entypo-lock"></label>
        </div>
        <div class="buttons">
            <input type="submit" value="Đăng ký"/>
            <span>
            <a href="login.php" class="entypo-user-add register">Đăng nhập</a>
            </span>
        </div>
    </form>
  
  
  <div class="hr">
    <div></div>
    <div>hoặc</div>
    <div></div>
  </div>
  
  <div class="social">
    <a href="javascript:void(0)" class="facebook"></a>
    <a href="javascript:void(0)" class="twitter"></a>
    <a href="javascript:void(0)" class="googleplus"></a>
  </div>
</div>

<span class="resp-info"></span>
</body>
</html>