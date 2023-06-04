<?php require "layout/navbarleft.php"?>
<style>
    .text-field select{
    display: block;
    padding: 15px 10px;
    width: 100%;
    border:1px solid #2e59d9;
    border-radius:5px;
    color:#2e59d9;
    background-color:#f8f9fc;
}
.delete-btn{
    border:1px solid red;
    background-color: white !important;
    color:red !important;
    text-decoration:none;
    transition: all linear 0.3s;
}
.delete-btn:hover{
    text-decoration:none;
    background-color: red !important;
    color:white !important;
}
.btn-error_log{
    text-decoration:none;
    background-color: red !important;
    color:white !important;
}

</style>
<?php 
    require_once "../model/User.php";
    require_once "../config/config.php";
    require_once "../model/Role.php";
    require_once "../Controller/Validate.php";
    $imgUser='';
    if(isset($_GET['idUser'])){
        $idUser =$_GET['idUser'];
        $user = User::getUserById($idUser);
        $imgUser = $user['imgUser'];
    }
    $validateNameUser ='';
    $validatePhoneNumber ='';
    $validatePassword ='';
    $validateImg ='';
    $validateEmailUser ='';
    
    if(isset($_POST["submit"])){
        $nameUser = $_POST["nameUser"];
        $phoneNumber = $_POST["phoneNumber"];
        $dayOfBirth = $_POST["dayOfBirth"];
        $address = $_POST["address"];
        $gender = $_POST["gender"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_GET['idRole'];
        
        if(!Validate::validateUsername($nameUser)){
            $validateNamePro ='* Tên người dùng không hợp lệ, không được chứa ký tự đặc biệt';
        }
        if(!Validate::validatePhoneNumber($phoneNumber)){
            $validatePhoneNumber ='* Số điện thoại không hợp lệ';
        }
        if(!Validate::validateMatKhau($password)){
            $validatePassword ='* Mật khẩu không hợp lệ, phải bao gồm 1 chữ cái Hoa , chữ thường và 1 số';
        }
        if(User::checkEmailUser($email) != false ){
            $validateEmailUser =' * Email đã tồn tại vui lòng chọn một email khác';
        }
        //var_dump($imgPro,$_FILES['imageFile']);
        //echo "đây là tên ảnh ".$_FILES['imageFile']['name']."nè";
        if ($_FILES['imageFile']['name'] !=="" ) {
            $file = $_FILES['imageFile'];
            $imgUserNew = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $direction = ($_GET['idRole'] == 2)? 'Employee' : 'Customer';
            $fileDestination = "./assets/img/".$direction."/". $imgUserNew;
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $validateImg= 'Hình ảnh đã được tải lên và lưu thành công.';
                User::addUser($conn,$nameUser,$phoneNumber,$address,$email,$dayOfBirth,$password,$gender,$role,$imgUserNew);
            } else {
                $validateImg= '* Lỗi khi lưu hình ảnh.';
            }
        } else {
            if($imgUser ==''){
                $imgUser ='defaultImg.jpg';
            }
            User::addUser($conn,$nameUser,$phoneNumber,$address,$email,$dayOfBirth,$password,$gender,$role,$imgUser);
        }
    }
?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require "layout/wrapper.php"?>
        <div class="container-fluid">
            <div class="wrapper-content">
                <h2 class="wrapper-content-heading">
                    Thêm <?php echo ($_GET['idRole']==2)? 'Nhân Viên' : 'Khách Hàng'; ?>
                </h2>
            </div>
            <form method="POST" class="wrapper-content-list-form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-field">
                                    <label for="username3">
                                        Tên <?php echo ($_GET['idRole']==2)? 'Nhân Viên' : 'Khách Hàng'; ?> 
                                        <span><?php echo $validateNameUser ?></span>
                                    </label>
                                    <input 
                                        autocomplete="off" 
                                        type="text"
                                        name ="nameUser" 
                                        placeholder="Tên <?php echo ($_GET['idRole']==2)? 'Nhân Viên' : 'Khách Hàng'; ?>"
                                    />
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">
                                        Số điện thoại 
                                        <span><?php echo $validatePhoneNumber ?></span>
                                    </label>
                                    <input 
                                        autocomplete="off" 
                                        type="text"
                                        name ="phoneNumber" 
                                        placeholder="Số điện thoại"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">
                                        Ngày sinh 
                                    </label>
                                    <input 
                                        autocomplete="off" 
                                        type="date"
                                        name ="dayOfBirth"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="text-field">
                                    <label for="username3">
                                        Địa chỉ 
                                    </label>
                                    <input 
                                        autocomplete="off" 
                                        type="text"
                                        name ="address"
                                        placeholder="Địa chỉ"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="text-field">
                                    <label for="username3">Giới tính</label>
                                    <select name="gender">
                                        <option 
                                            value="Nam"
                                        >
                                            Nam
                                        </option>
                                        <option 
                                            value="Nữ"
                                        >
                                            Nữ
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">
                                        Email 
                                    </label>
                                    <input 
                                        autocomplete="off" 
                                        type="email"
                                        name ="email" 
                                        placeholder ="email"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">
                                        Password <span><?php echo $validatePassword ?></span>
                                    </label>
                                    <input 
                                        autocomplete="off" 
                                        type="text"
                                        name ="password" 
                                        placeholder ="password"
                                    />
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-4">
                        <h1 class="wrapper-content-list-form-name">
                            Ảnh <?php echo ($_GET['idRole']==2)? 'Nhân Viên' : 'Khách Hàng'; ?>
                        </h1>
                        <div class="wrapper-content-list-img">
                            <div class="wrapper-content-list-img-background">
                                <img  
                                    id="previewImage" 
                                    src="./assets/img/<?php echo ($_GET['idRole']==2)? 'Employee' : 'Customer'; ?>/defaultImg.jpg" 
                                    alt="ảnh người dùng"
                                >
                                <i class="fa-regular fa-plus"></i>
                                <span>Thêm hình ảnh </span>
                                <span style="display:block"><?php echo $validateImg ?></span>
                            </div>
                            <div class="wrapper-content-list-img-upload">
                                <input id="imageInput" type="file" name="imageFile" accept="image/*">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="wrapper-content-btn-submit">
                        <button type="submit" name="submit">
                            Thêm <?php echo ($_GET['idRole']==2)? 'Nhân viên' : 'Khách Hàng'; ?>
                        </button>
                        <a href="./<?php echo ($_GET['idRole']==2)? 'employee' : 'customer'; ?>.php">Trở về danh sách <?php echo ($_GET['idRole']==2)? 'nhân viên' : 'khách hàng'; ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2021</span>
            </div>
        </div>
    </footer>
</div>
<script>
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('previewImage');
    function editProfileImg(){
    if(imageInput != null || preview != null){
        imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];
        const reader = new FileReader();
    
        reader.addEventListener('load', () => {
            preview.src = reader.result;
        }, false);
    
        if (file) {
            reader.readAsDataURL(file);
        }
        });
    }
    
    }
    editProfileImg();


</script>
<?php require "layout/footer.php" ?>