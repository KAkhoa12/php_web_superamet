<?php require "layout/header.php"?>
<?php
    require_once "../model/Product.php";
    require_once "../model/Category.php";
    $productList = Product::getAllProducts();
    $categoryList = Category::getAllCategory();
?>
<style>
</style>
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Tất cả mặt hàng</span>
                        </div>
                        <ul>
                            <?php
                                foreach($categoryList as $row){
                                ?>
                                    <li>
                                        <a href="listProduct.php?idCate=<?php echo $row['idCate'] ?>">
                                            <?php echo $row['nameCategory'] ?>
                                        </a>
                                    </li>
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
                                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm">
                                <button type="submit" name="submit" class="site-btn">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                        <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                <?php
                    $count = 0;
                    foreach($productList as $row){
                        if ($count == 5) {
                            break;
                        }
                        ?>
                            <div class="col-lg-3">
                                <div class="categories__item set-bg" data-setbg="img/product/<?php echo $row['imgPro'] ?>">
                                    <h5><a href="productDetail.php?idPro=<?php echo $row['idPro'] ?>"><?php echo $row['namePro'] ?></a></h5>
                                </div>
                            </div>
                        <?php
                        $count++;
                    }
                ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Trái cây</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <?php
                                    $count =0;
                                    $listTraiCay = Product::getAllProductByType(1);
                                    foreach($listTraiCay as $row){
                                        if($count>2){
                                            break;
                                        }
                                        else{
                                            $priceFormat = number_format($row['newPrice'] , 0, ',', ',')
                                        ?>
                                            <a href="productDetail.php?idPro=<?php echo $row['idPro'];?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $row['imgPro']?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $row['namePro'] ?></h6>
                                                    <span><?php echo $priceFormat; ?> VND</span>
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        $count++;
                                    }
                                ?>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <?php
                                    $count = 0;
                                    foreach($listTraiCay as $row){
                                        if($count<=2){
                                            $count++;
                                            continue;
                                        }
                                        else if($count > 2){
                                            $priceFormat = number_format($row['newPrice'] , 0, ',', ',')
                                        ?>
                                            <a href="productDetail.php?idPro=<?php echo $row['idPro'];?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $row['imgPro']?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $row['namePro'] ?></h6>
                                                    <span><?php echo $priceFormat ?> VND</span>
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Thịt tươi sống</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <?php
                                    $count =0;
                                    $listTraiCay = Product::getAllProductByType(4);
                                    foreach($listTraiCay as $row){
                                        if($count>2){
                                            break;
                                        }
                                        else{
                                            $priceFormat = number_format($row['newPrice'] , 0, ',', ',')
                                        ?>
                                            <a href="productDetail.php?idPro=<?php echo $row['idPro'];?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $row['imgPro']?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $row['namePro'] ?></h6>
                                                    <span><?php echo $priceFormat ?> VND</span>
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        $count++;
                                    }
                                ?>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <?php
                                    $count = 0;
                                    foreach($listTraiCay as $row){
                                        if($count<=2){
                                            $count++;
                                            continue;
                                        }
                                        else if($count > 2){
                                            $priceFormat = number_format($row['newPrice'] , 0, ',', ',')
                                        ?>
                                            <a href="productDetail.php?idPro=<?php echo $row['idPro'];?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $row['imgPro']?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $row['namePro'] ?></h6>
                                                    <span><?php echo $priceFormat?> VND</span>
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Rau củ</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <?php
                                    $count =0;
                                    $listTraiCay = Product::getAllProductByType(3);
                                    foreach($listTraiCay as $row){
                                        if($count>2){
                                            break;
                                        }
                                        else{
                                            $priceFormat = number_format($row['newPrice'] , 0, ',', ',')
                                        ?>
                                            <a href="productDetail.php?idPro=<?php echo $row['idPro'];?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $row['imgPro']?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $row['namePro'] ?></h6>
                                                    <span><?php echo $priceFormat ?> VND</span>
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        $count++;
                                    }
                                ?>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <?php
                                    $count = 0;
                                    foreach($listTraiCay as $row){
                                        if($count<=2){
                                            $count++;
                                            continue;
                                        }
                                        else if($count > 2){
                                            $priceFormat = number_format($row['newPrice'] , 0, ',', ',')
                                        ?>
                                            <a href="productDetail.php?idPro=<?php echo $row['idPro'];?>" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/product/<?php echo $row['imgPro']?>" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6><?php echo $row['namePro'] ?></h6>
                                                    <span><?php echo $priceFormat ?> VND</span>
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->
<?php require "layout/footer.php" ?>