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
    require_once "../model/Category.php";
    require_once "../model/Product.php";
    require_once "../Controller/Validate.php";
    $imgPro='';
    $amount='';
    if(isset($_GET['idPro'])){
        $idPro =$_GET['idPro'];
        $product = Product::getProductWhenHaveID($idPro);
        $imgPro = $product['imgPro'];
        $amount = $product['amount'];
    }
    $validateNamePro ='';
    $validateNewPrice ='';
    $validateOldPrice ='';
    $validateImg ='';
    if(isset($_POST["submit"])){
        $idPro = $_GET["idPro"];
        $namePro = $_POST["namePro"];
        $oldPrice = $_POST["oldPrice"];
        $newPrice = $_POST["newPrice"];
        $idCate = $_POST["idCate"];
        $status = $_POST["type"];
        $decription = $_POST["decription"];
        // var_dump($idPro,$namePro,$oldPrice,$newPrice,$idCate,$status,$decription);
        if(!ctype_digit($newPrice) || empty($newPrice)){
            $validateNewPrice='*, Giá không hợp lệ...';
        }
        if(!empty($oldPrice) ){
            if(!ctype_digit($oldPrice)){
                $validateOldPrice='* Giá không hợp lệ...';
            }
        }
        if(!Validate::validateUsername($namePro)){
            $validateNamePro ='* Tên sản phẩm không hợp lệ, không được chứa ký tự đặc biệt';
        }
        // var_dump($imgPro,$_FILES['imageFile']);
        echo "đây là tên ảnh ".$_FILES['imageFile']['name']."nè";
        if ($_FILES['imageFile']['name'] !=="" ) {
            $file = $_FILES['imageFile'];
            $imgProNew = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileDestination = '../client/img/product/'. $imgProNew;
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $validateImg= 'Hình ảnh đã được tải lên và lưu thành công.';
                Product::updateProductById($idPro,$namePro, $decription, $oldPrice, $newPrice, $amount,$imgProNew, $idCate,$status);
            } else {
                $validateImg= '* Lỗi khi lưu hình ảnh.';
            }
        } else {
            Product::updateProductById($idPro,$namePro, $decription, $oldPrice, $newPrice, $amount,$imgPro, $idCate,$status);
        }
    }
?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require "layout/wrapper.php"?>
        <div class="container-fluid">
            <div class="wrapper-content">
                <h2 class="wrapper-content-heading">Chi tiết sản phẩm</h2>
            </div>
            <form method="POST" class="wrapper-content-list-form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="text-field">
                            <label for="username3">Tên Sản Phẩm <span><?php echo $validateNamePro ?></span></label>
                            <input autocomplete="off" type="text" id="username3" placeholder="VD : Táo mỹ " name ="namePro" value="<?php echo $product['namePro'] ?>"/>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">Giá cũ <span><?php echo $validateOldPrice ?></span></label>
                                    <input autocomplete="off" type="text" id="username3" placeholder="VD:40000" name ="oldPrice" value="<?php echo $product['oldPrice'] ?>"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-field">
                                    <label for="username3">Giá mới <span><?php echo $validateNewPrice ?></span></label>
                                    <input autocomplete="off" type="text" id="username3" placeholder="VD : 50000 " name ="newPrice" value="<?php echo $product['newPrice'] ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="text-field">
                                    <label for="username3">Loại</label>
                                    <select name="idCate">
                                        <?php 
                                            $listType = Category::getAllCategory();
                                            foreach($listType as $row){
                                            ?>
                                                <option 
                                                    value="<?php echo $row['idCate'] ?>" 
                                                    <?php 
                                                        if($product['idCate'] == $row['idCate'])
                                                        echo 'selected'; 
                                                    ?>
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
                                    <select name="type">
                                        <option 
                                            value="Show" 
                                            <?php 
                                                if($product['status'] == 'Show')
                                                echo 'selected'; 
                                            ?>
                                        >
                                            Hiển thị
                                        </option>
                                        <option 
                                            value="Hidden" 
                                            <?php 
                                                if($product['status'] == 'Hidden')
                                                echo 'selected'; 
                                            ?>
                                        >
                                            Ẩn đi
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="text-field">
                                    <label for="username3">Đơn vị tính</label>
                                    
                                    <input autocomplete="off" type="text" id="username3" placeholder="VD : kg " name ="dvt" value="<?php echo $product['dvt'] ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="text-field">
                            <label for="username3">Mô Tả </label>
                            <textarea 
                                name="decription" 
                                id="username3" 
                            >
                                <?php echo $product['decription'] ?>
                            </textarea>
                        </div>  
                    </div>
                    <div class="col-lg-4">
                        <h1 class="wrapper-content-list-form-name">Ảnh Sản Phẩm</h1>
                        <div class="wrapper-content-list-img">
                            <div class="wrapper-content-list-img-background">
                                <img  id="previewImage" src="../client/img/product/<?php echo $product['imgPro']; ?>" alt="">
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
                            Cập nhập sản phẩm
                        </button>
                        <a href="./product.php">Trở về danh sách sản phẩm</a>
                        <a href="#" class="delete-btn" data-toggle="modal" data-target="#deleteItem">Xóa sản phẩm</a>
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
    <div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Bạn có muốn xóa sản phẩm này?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Trờ về</button>
                    <a class="btn btn-error_log"  href="./product.php?idDel=<?php echo $_GET['idPro'];?> " >Xóa </a>
                </div>
            </div>
        </div>
    </div>
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