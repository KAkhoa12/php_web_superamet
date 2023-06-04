<?php require_once "../config/config.php" ?>
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
</style>
<?php require "layout/navbarleft.php"?>
<?php 
    require_once "../model/Category.php";
    require_once "../model/Product.php";
    require_once "../Controller/Validate.php";
    if(isset($_GET['idPro'])){
        $idPro =$_GET['idPro'];
        $product = Product::getProductWhenHaveID($idPro);
    }
    $validateNamePro ='';
    $validateNewPrice ='';
    $validateOldPrice ='';
    $validateImg ='';
    if(isset($_POST["submit"])){
        $namePro = $_POST["namePro"];
        $oldPrice = $_POST["oldPrice"];
        $newPrice = $_POST["newPrice"];
        $idCate = $_POST["type"];
        $status = $_POST["status"];
        $dvt = $_POST["dvt"];
        $decription = $_POST["decription"];
        $imgPro = '';
        
        $validateImg ='';
        if(!ctype_digit($newPrice) || empty($newPrice)){
            $validateNewPrice='* Giá không hợp lệ';
        }
        if(!empty($oldPrice) ){
            if(!ctype_digit($oldPrice)){
                $validateOldPrice='* Giá không hợp lệ';
            }
        }
        if(!Validate::validateUsername($namePro)){
            $validateNamePro ='* Tên sản phẩm không hợp lệ, không được chứa ký tự đặc biệt';
        }
        if (isset($_FILES['imageFile'])) {
            $file = $_FILES['imageFile'];
            $imgPro = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileDestination = '../client/img/product/'. $imgPro;
    
            // Di chuyển file hình ảnh từ thư mục tạm sang thư mục đích
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // File đã được lưu thành công
                $validateImg= 'Hình ảnh đã được tải lên và lưu thành công.';
                Product::addProduct($namePro, $decription, $oldPrice, $newPrice, '0',$imgPro, $idCate,$dvt);
            } else {
                $validateImg= '* Lỗi khi lưu hình ảnh.';
            }
        } else {
            $validateImg= '* Vui lòng chọn một hình ảnh.';
        }
    }

?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require "layout/wrapper.php"?>
        <div class="container-fluid">
            <div class="wrapper-content">
                <h2 class="wrapper-content-heading">Thêm sản phẩm</h2>
            </div>
            <form action="" method="POST" class="wrapper-content-list-form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="text-field">
                            <label for="username3">Tên Sản Phẩm <span><?php echo $validateNamePro ?></span></label>
                            <input autocomplete="off" type="text" id="username3" placeholder="VD : Táo mỹ " name ="namePro"/>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">Giá cũ <?php echo $validateOldPrice ?></span> </label>
                                    <input autocomplete="off" type="text" id="username3" placeholder="VD:40000" name ="oldPrice" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">Giá mới <span><?php echo $validateNewPrice ?></span> </label>
                                    
                                    <input autocomplete="off" type="text" id="username3" placeholder="VD : 50000 " name ="newPrice" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="text-field">
                                    <label for="username3">Loại</label>
                                    <select name="type">
                                        <?php 
                                            $listType = Category::getAllCategory();
                                            foreach($listType as $row){
                                            ?>
                                                <option 
                                                    value="<?php echo $row['idCate'] ?>" 
                                                >
                                                    <?php echo $row['nameCategory'] ?>
                                                </option>
                                            <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-field">
                                    <label for="username3">Trạng thái</label>
                                    <select name="status">
                                        <option 
                                            value="Show"
                                        >
                                            Hiển thị
                                        </option>
                                        <option 
                                            value="Hidden" 
                                        >
                                            Ẩn đi
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-field">
                                    <label for="username3">Đơn vị tính</label>
                                    
                                    <input autocomplete="off" type="text" id="username3" placeholder="VD : kg " name ="dvt" />
                                </div>
                            </div>
                        </div>
                        <div class="text-field">
                            <label for="username3">Mô Tả </label>
                            <textarea 
                                name="decription" 
                                id="username3" 
                            >
                            </textarea>
                        </div>  
                    </div>
                    <div class="col-lg-4">
                        <h1 class="wrapper-content-list-form-name">Ảnh Sản Phẩm</h1>
                        <div class="wrapper-content-list-img">
                            <div class="wrapper-content-list-img-background">
                                <img  id="previewImage" src="../client/img/product/defaultImg.jpg" alt="">
                                <i class="fa-regular fa-plus"></i>
                                <span>Thêm hình ảnh</span>
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
                            Thêm sản phẩm
                        </button>
                        <a href="./product.php">Trở về danh sách sản phẩm</a>
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