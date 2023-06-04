<?php require_once "layout/header.php" ?>
<?php
    require_once "../model/Product.php";
    require_once "../model/Category.php";
    $productList = Product::getAllProducts();
    $categoryList = Category::getAllCategory();
    $nameSearch ="";
    if(isset($_POST['submit']) || !empty($_POST['submit'])){
        $nameSearch = $_POST['search'];
        $listSearch = Product::getAllProductWhenSearch($nameSearch);
        if(count($listSearch) == 0 || empty($nameSearch)){
            $nameSearch = "Sản phẩm không có hoặc tìm kiếm sai tên!";
            $listSearch =[];
        }else{
            $nameSearch = $_POST['search'];
        }
    }
?>
<style>
    .product-search-item{
        margin-bottom: 20px;
        padding: 8px;
        border:1px solid #7fad39;
        border-radius:5px;
        display: inline-block;
    }
    .product-search-item img{
        width: 100%;
        aspect-ratio: 1 / 1;
    }
    .product-search-item .content h4{
        color:#7fad39;
        font-weight:bold;
        padding: 10px;
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
    .search_title{
        margin: 20px 0;
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
                        foreach($categoryList as $row){
                        ?>
                            <li><a href="listProduct.php?dCate=<?php echo $row['idCate']?>"><?php echo $row['nameCategory'] ?></a></li>
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
                        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit" name="submit" class="site-btn">Tìm kiêm</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <h3 class="search_title">Bạn đang tìm "<?php echo $nameSearch ?>"</h3>
            </div>
            <div class="row">
                <?php
                    foreach($listSearch as $row){
                    ?>
                        <div class="col-lg-4">
                            <a href="productDetail.php?idPro=<?php echo $row['idPro'] ?>" class="product-search-item">
                                <img src="img/product/<?php echo $row['imgPro'] ?>" alt="">
                                <div class="content">
                                    <h4><?php echo $row['namePro']?> </h4>
                                    <s><?php echo $row['oldPrice']?> VND</s>
                                    <span><?php echo $row['newPrice']?> VND</span>
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

<?php require_once "layout/footer.php" ?>