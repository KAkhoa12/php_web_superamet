<?php
    require_once "layout/header.php" 
 ?>
<?php 
    require_once "../model/Product.php";
    require_once "../model/Category.php";
    require_once "../model/Order.php";
    require_once "../model/detailOrder.php";
    
    $categoryList = Category::getAllCategory();
    if(isset($_GET['idPro'])){
        $idPro = $_GET['idPro'];
        $product = Product::getDetailProduct($idPro);
        $productCateName = Category::getCategoryName($product['idCate']);
        $relatedProduct = Product::getRelatedProducts($product['idCate'],$idPro);
    }else{
        header("Location: index.php");
    }
    
    
?>
<style>
    .header-title{
        color:#7fad39;
        font-weight:bold;
        margin: 20px 0;
    }
    .input-group {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .btn-minus, .btn-plus {
        background-color: #7fad39;
        color:white;
        border:none;
        font-size: 16px;
        padding: 8px;
        cursor: pointer;
        user-select: none;
    }
    .input-group input{
        width: 50px;
        height: 100%;
        padding: 4px;
        border:none;
        text-align:center;
    }
    .btn-minus {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .btn-plus {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .product-img{
        padding: 10px;
        border:1px solid #7fad39;
        border-radius:5px;
        margin: 10px 0 20px;
    }
    .product-img img{
        width: 100%;
        aspect-ratio: 1 / 1;
    }
    .product-info h2{
        color:#7fad39;
        font-weight:bold;
        
    }
    .price{
        display: flex;
        align-items: center;  
        gap: 20px;
    }
    .price s{
        font-size: 27px;
        color:#ccc;
    }
    .price .new{
        font-size: 35px;
        color:red;
        font-weight:600;
    }
    .product p{
        color:#999;
    }
    .btn-box{
        display: flex;
        align-items:center;
        gap: 20px;
    }
    .btn-box a,.btn-box button{
        padding: 8px;
        border:1px solid #7fad39;
        border-radius:5px;
        font-size:20px;
    }
    .addCart{
        color:#7fad39;
        background-color:white;
        transition: all linear 0.3s;
    }
    .addCart:hover{
        background-color:#7fad39;
        color:white;
    }
    .buynow{
        background-color:#7fad39;
        color:white;
        transition: all linear 0.3s;
    }
    .buynow:hover{
        color:red;
    }
    .product-des{
        margin: 30px 0;
    }
    .product-des .des{
        font-size: 20px;
    }
    .product-search-item{
        margin-bottom: 20px;
        padding: 8px;
        border:1px solid #7fad39;
        border-radius:5px;
        display: block;
    }
    .product-search-item img{
        width: 100%;
        aspect-ratio: 1 / 1;
    }
    .product-search-item .content .content-name{
        color:#7fad39;
        font-weight:bold;
        padding: 10px;
        display: block;
        font-size: 30px;
    }
    .product-search-item .content s{
        color:#ccc;
        font-size: 15px;
    }
    .product-search-item .content span{
        color:red;
        font-size: 25px;
        font-weight:600;
        padding-left: 10px;

    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-9">
            <div class="hero__search">
                <div class="hero__search__form">
                    <form action="./search.php" method="post">
                        <div class="hero__search__categories">
                            All Categories
                            <span class="arrow_carrot-down"></span>
                        </div>
                        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm?">
                        <button type="submit" name="submit" class="site-btn">Tìm kiếm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form action="cart.php" method="post" style="width:100%">
    <input type="text" hidden value="<?php echo $product['idPro'] ?>" name="idPro">
    <div class="row">
        <div class="col-lg-5">
            <div class="product-img">
                <img src="img/product/<?php echo $product['imgPro'] ?>" alt="ảnh sản phẩm">
            </div>
        </div>
        <div class="col-lg-7">
            <div class="product-info">
                <h2><?php echo $product['namePro'] ?></h2>
                <div class="price">
                    <?php
                        $newPrice = number_format($product['newPrice'], 0, ',', ',');
                        $oldPrice = number_format($product['oldPrice'], 0, ',', ',');
                    ?>
                    <s class="old"><?php echo $oldPrice ?> VND</s>
                    <span class="new"><?php echo $newPrice ?> VND</span>\
                    <input type="text" hidden value="<?php echo $product['newPrice'] ?>" name="newPrice">
                </div>
                <p>Số lượng còn lại: <?php echo $product['amount'] ?></p>
                <div class="input-group">
                    <span class="btn-minus">-</span>
                    <input type="text" id="quantity" value="1" name="quantity" min="0" max="99">
                    <span class="btn-plus">+</span>
                </div>
                <div class="btn-box">
                    <button type="submit" name="submit" class="addCart">Thêm vào giỏ hàng</button>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="product-des">
                <h3>Mô tả sản phẩm</h3>
                <p class="des"><?php echo $product['decription'] ?></p>
                <h5>Phân loại sản phẩm: <?php echo $productCateName['nameCategory'] ?></h5>
                <h5>Đơn vị tính: <?php echo $product['dvt'] ?></h5>
            </div>
        </div>
    </div>
    </form>
    <h2 class="header-title">Các sản phẩm liên quan</h2>
    <div class="row">
        <?php 
            $count =1;
            foreach($relatedProduct as $row){
                if($count>4){
                    break;
                }
                $newPrice = number_format($product['newPrice'], 0, ',', ',');
                $oldPrice = number_format($product['oldPrice'], 0, ',', ',');
            ?>
                <div class="col-lg-3">
                    <a href="productDetail.php?idPro=<?php echo $row['idPro'] ?>" class="product-search-item">
                        <img src="img/product/<?php echo $row['imgPro'] ?>" alt="">
                        <div class="content">
                            <span class="content-name"><?php echo $row['namePro']?> </span>
                            <s><?php echo $oldPrice?> VND</s>
                            <span><?php echo $newPrice?> VND</span>
                        </div>
                    </a>
                </div>
            <?php
            $count++;
            }
        ?>
    </div>
</div>
<script>
    var quantityInput = document.getElementById("quantity");
    var minusButton = document.querySelector(".btn-minus");
    var plusButton = document.querySelector(".btn-plus");

    minusButton.addEventListener("click", function() {
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > 0) {
            quantityInput.value = currentValue - 1;

        }
    });

    plusButton.addEventListener("click", function() {
        var currentValue = parseInt(quantityInput.value);
        if (currentValue < <?php echo$product['amount']  ?>) {
            quantityInput.value = currentValue + 1;
        }
    });

</script>
<?php require_once "layout/footer.php" ?>
