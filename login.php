<?php require_once "./config/config.php"; ?>
<?php
    session_start();
    require_once "./model/User.php";
    $error_message ="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = $_POST["username"];
        $password = $_POST["password"];
        var_dump($password);
        $user = User::checkUserAccount($username,$password);
        if ($user) {
            $_SESSION["idUser"] = $user["idUser"];
            $_SESSION["nameUser"] = $user["nameUser"];
            $_SESSION["idRole"] = $user["idRole"];
            $_SESSION["nameRole"] = $user["nameRole"];
            if($user['idRole'] == 3){
                header("Location: ./client/index.php");
                exit();
            }else if($user['idRole'] == 1 || $user['idRole'] == 2) {
                header("Location: ./server/index.php");
                exit();
            } 
            
        } else {
            // Thông báo lỗi đăng nhập nếu thông tin đăng nhập không chính xác
            $error_message = "Tên đăng nhập hoặc mật khẩu không chính xác.";
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
     <!-- ICON FONTAWESOME CDN -->
     <link href="https://site-assets.fontawesome.com/releases/v6.1.2/css/all.css?fbclid=IwAR2Lefv1ZTLJsKEsnl4HGMf5XRZuPqx5yOFnFaOFbVgCiCeU87S0up6ptKU"  rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="./client/css/signinup.css">
    <style>
        .icon{
            display: inline-block;
            width: 50px;
            height: 50px;
            border-radius:50%;
            transition: all linear 0.3s;
            display: flex;
            align-items: center;  
            justify-content: center;
            text-decoration:none;
        }
        .icon .fa-brands{
            color:#333;
            font-size: 22px;
            padding: 10px;
        }
        .icon:hover .fa-brands{
            color:#fff;
        }
        .icon:hover.icon-face{
            background-color: blue;
        }
        .icon:hover.icon-twitter{
            background-color: cyan;
        }
        .icon:hover.icon-gg{
            background-color: red;
        }
        .center{
            display: flex;
            align-items:center;
            justify-content:space-around;
        }
    </style>
</head>
<body>
<div class="loginpanel">
    <form action="login.php" method="post">
        <span style="color:red;"><?php echo $error_message ?></span>
        <div class="txt">
            <input id="user" name="username" type="text" placeholder="Username" />
            <label for="user" class="entypo-user"></label>
        </div>
        <div class="txt">
            <input id="pwd" name="password" type="password" placeholder="Password" />
            <label for="pwd" class="entypo-lock"></label>
        </div>
        <div class="buttons">
            <input type="submit" value="Đăng nhập" />
            <span>
            <a href="register.php" class="entypo-user-add register">Đăng ký</a>
            </span>
        </div>
    </form>
  
  <div class="hr">
    <div></div>
    <div>hoặc</div>
    <div></div>
  </div>
  
  <div class="center">
    <a href="#" class="icon icon-face">
        <i class="fa-brands fa-facebook"></i>
    </a>
    <a href="#" class="icon icon-twitter">
        <i class="fa-brands fa-twitter"></i>
    </a>
    <a href="#" class="icon icon-gg">
        <i class="fa-brands fa-google-plus-g"></i>
    </a>
  </div>
</div>

<span class="resp-info"></span>
</body>
</html>