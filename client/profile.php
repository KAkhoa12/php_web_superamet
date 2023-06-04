<?php require_once "layout/header.php" ?>
<?php 
    require_once "../config/config.php";
    require_once "../model/User.php";
    require_once "../controller/Validate.php";
    $user = User::getUserById($_SESSION['idUser']);
    $result_validate_name='';
    $result_validate_phoneNumber='';
    $result_validate_password='';
    $result_validate_dayOB='';
    $result_validate_email='';
    $result_validate_success='';
    if(isset($_POST['submit'])){
        $nameUser = $_POST['username'] ;
        $gender = $_POST['gioitinh'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['sdt'];
        $dayOfBirth = $_POST['dayOB'];
        $address = $_POST['address'];
        $password = $_POST['pwd'];
        $idUser = $_SESSION["idUser"];
        if(!Validate::validateUserName($nameUser)){
            $result_validate_name = '*Tên không hợp lệ, tên phải lớn hơn 2 và nhỏ hơn 50 ký tự và không được chứa ký tự đặc biệt ';
        }
        if(!Validate::validatePhoneNumber($phoneNumber)){
            $result_validate_phoneNumber='*Số điện thoại không hợp lệ';
        }
        if(!Validate::validateEmail($email)){
            $result_validate_email=' *email không hợp lệ';
        }
        if(!Validate::validateMatKhau($password)){
            $result_validate_password='*Mật khẩu phải lớn hơn 8 ký tự, tồn tại ít nhất 1 chữ Hoa, 1 chữ cái thường, một số ';
        }else{
            $result_validate_success='Cập nhập thành công';
            User::updateUserById($idUser,$nameUser,$phoneNumber,$address,$email,$dayOfBirth,$password,$gender,'3','defaultImg.jpg');

        }
    }

?>
<style>
    .profile-form{
    width: 100%;
    padding: 30px;
}
.profile-form button{
    padding: 5px 10px;
    background-color:#7fad39;
    border-radius:5px;
    color:white;
    outline:none;
    border:none;
}
.profile-heading{
    color:#1f1c45;
    font-size: 26px;
    font-weight: bold;
}
.text-field label {
  display: inline-block;
  font-weight: 600;
  cursor: pointer;
  margin-bottom: 2px;
  color: #1f1c45;
}
.text-field select{
    display: block;
    padding: 5px 0;
    width: 100%;
    border:1px solid #7fad39;
    border-radius:5px;
}
.text-field input {
  outline: none;
  padding: 5px 0;
  display: block;
  width: 100%;
  color: #7fad39 !important;
  font-size: 14px;
  border-top-width:0px;
  border-left-width:0px;
  border-right-width:0px;
  border-bottom: 2px solid #7fad39;
  background-color: transparent;
  color: #6a5af9;
  margin-bottom: 30px;
}
.validate_err{
    color:red;
    font-weight: 500;
    padding-left: 20px;
}
.success-result{
    color:green;
    font-weight: 600;
    padding-left: 30px;
}
.heading-link{
    text-decoration:none;
    color: white;
    background-color:#7fad39;
    padding: 8px 12px;
    border-radius:4px;
    display: inline-block;
    margin-left: 50px;
}
</style>
<div class="container">
    <div class="row">
        <h2>Thông tin chi tiết người dùng</h2>
        <a class="heading-link"  href="billDetail.php">
            Lịch sử mua hàng
        </a>
    </div>
    <div class="row">
        <form action="profile.php" method="post" class="profile-form">
            <div class="text-field">
                <label for="username2">Tên tài khoản</label>
                <span class="validate_err"><?php echo $result_validate_name ?></span>
                <input autocomplete="off" name="username" type="text" id="username2" placeholder="Enter your username" value="<?php echo $user['nameUser'] ?>" />
            </div>
            <div class="text-field">
                <label for="email">Email</label>
                <span class="validate_err"><?php echo $result_validate_email ?></span>
                <input autocomplete="off" type="text" id="email" name="email" placeholder="Enter your username" value="<?php echo $user['email'] ?>" />
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="text-field">
                        <label for="gioitinh">Giới tính</label>
                        <select name="gioitinh">
                            <option value="Nam" <?php if(isset($user['gender']) && $user['gender'] == 'Nam') echo 'selected'; ?>>Nam</option>
                            <option value="Nữ" <?php if(isset($user['gender']) && $user['gender'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                        </select>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-field">
                        <label for="sdt">Số điện thoại</label>
                        <span class="validate_err"><?php echo $result_validate_phoneNumber ?></span>
                        <input autocomplete="off" type="text" id="sdt" name="sdt" placeholder="Nhập số điện thoại" value="<?php echo $user['phoneNumber'] ?>"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-field">
                        <label for="dayOB">Ngày sinh</label>
                        <span class="validate_err"></span>
                        <input autocomplete="off" type="date" id="dayOB" name="dayOB" value="<?php echo $user['dayOfBirth'];?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-field">
                        <label for="address">Địa chỉ</label>
                        <input autocomplete="off" type="text" id="address" name="address" placeholder="Nhập địa chỉ" value="<?php echo $user['address'] ?>"/>
                    </div>
                </div>
            </div>
            <div class="text-field">
                <label for="pwd">Mật khẩu</label>
                <span class="validate_err"><?php echo $result_validate_password ?></span>
                <input autocomplete="off" type="text" id="pwd" name="pwd" placeholder="Nhập mật khẩu" value="<?php echo $user['password'] ?>"/>
            </div>
            <button type="submit" name="submit">Lưu</button> 
            <span class="success-result"><?php echo $result_validate_success ?></span>
        </form>
    </div>
</div>
<?php require_once "layout/footer.php" ?>