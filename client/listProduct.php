<?php require_once "layout/header.php" ?>
<?php 
    require_once "../model/Category.php";
    require_once "../model/Product.php";
    $listCategory = Category::getAllCategory();
?>
<style>
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
    .item-group-heading{
        color:#7fad39;
        font-weight: bold;
    }
    .items-group{
        margin-bottom:40px;
    }
    .items-group .line{
        display: block;
        height: 3px;
        width: 100%;
        background-color:#7fad39;
    }
    .items-group-list{
        margin-top: 40px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="hero__categories">
                <div class="hero__categories__all">
                    <i class="fa fa-bars"></i>
                    <span>Tất cả mặt hàng </span>
                </div>
                <ul>
                    <?php
                        foreach($listCategory as $row){
                        ?>
                            <li><a href="listProduct.php?idCate=<?php echo $row['idCate']?>"><?php echo $row['nameCategory'] ?></a></li>
                        <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
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
    <div class="row">
        <?php 
            if(isset($_GET['idCate'])){
                $nameCate =Category::getCategoryName($_GET['idCate']);
                ?>
                <div class="col-lg-12">
                    <div class="items-group">
                        <h2 class="item-group-heading"><?php echo $nameCate['nameCategory'] ?></h2>
                        <span class="line"></span>
                        <div class="items-group-list">
                            <div class="row">
                            <?php 
                                $listProduct = Product::getAllProductByType($_GET['idCate']);
                                foreach($listProduct as $product){
                                ?>
                                    <div class="col-lg-3">
                                        <a href="productDetail.php?idPro=<?php echo $product['idPro'] ?>" class="product-search-item">
                                            <img src="img/product/<?php echo $product['imgPro'] ?>" alt="">
                                            <div class="content">
                                                <span class="content-name"><?php echo $product['namePro']?> </span>
                                                <s><?php echo $product['oldPrice']?> VND</s>
                                                <span><?php echo $product['newPrice']?> VND</span>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                foreach($listCategory as $category){
                    ?>
                    <div class="col-lg-12">
                        <div class="items-group">
                            <h2 class="item-group-heading"><?php echo $category['nameCategory'] ?></h2>
                            <span class="line"></span>
                            <div class="items-group-list">
                                <div class="row">
                                <?php 
                                    $listProduct = Product::getAllProductByType($category['idCate']);
                                    foreach($listProduct as $product){
                                    ?>
                                        <div class="col-lg-3">
                                            <a href="productDetail.php?idPro=<?php echo $product['idPro'] ?>" class="product-search-item">
                                                <img src="img/product/<?php echo $product['imgPro'] ?>" alt="">
                                                <div class="content">
                                                    <span class="content-name"><?php echo $product['namePro']?> </span>
                                                    <s><?php echo $product['oldPrice']?> VND</s>
                                                    <span><?php echo $product['newPrice']?> VND</span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>
        
    </div>
</div>
<?php require_once "layout/footer.php" ?>