<?php require "layout/navbarleft.php"?>
<style>
    .table-list{
        width: 100%;
    }
    .table-list thead td{
        font-weight:bold;
        font-size:16px;
        color:#2e59d9;
    }
    .table-list tr{
        border-bottom:1px solid #2e59d9;
        padding: 10px 0;
    }
    .img-pro{
        height: 90px;
        border-radius:3px;
        aspect-ratio:1/1
    }
    .paging{
        width: 100%;
        margin-top: 50px;
    }
    .paging ul{
        display: flex;
        align-items: center;  
        justify-content: center;   
        list-style-type: none; 
        gap: 20px;
        
    }
    .wrapper-content-add-product:hover{
        color:white;
        text-decoration:none;
    }
    .paging ul{
    }
    .paging ul a.active{
        background-color: #2e59d9;
        color:white;
    }
    .paging ul a{
        text-decoration:none;
        display: inline-block;
        width: 100%;
        border:1px solid #2e59d9;
        background-color: white;
        height: 100%;
        color:#2e59d9;
        padding: 5px 8px;
        overflow:hidden;
        border-radius:5px;
        transition: all linear 0.3s;
    }
    .paging ul a:hover{
        background-color: #2e59d9;
        color:white;
    }
    .linkItem{
        text-decoration:none;
        color:#2e59d9;
        border-radius:5px;
        border:1px solid #2e59d9;
        padding: 3px 10px;
        font-size: 15px;
        transition: all linear 0.3s;
    }
    .linkItem:hover{
        text-decoration:none;
        background-color: #2e59d9;
        color:white;
    }
</style>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require "layout/wrapper.php"?>
        <?php 
            require_once "../model/Product.php";
            $numberProductEachPage = 5;
            if(isset($_GET['idDel'])){
                Product::deleteProductById($_GET['idDel']);
            }
            if (!isset($_GET['page'])) {
                $_GET['page']=1;
                $numpage = 0;
            } else {
                $numpage = (intval($_GET['page']) - 1 ) * $numberProductEachPage;
            }
            $danhsachmonan = $conn->prepare("SELECT * FROM `product`");
            $list = $conn->prepare("SELECT * FROM `product` LIMIT :numpage, :numlist");
            $list->bindValue(':numpage', intval($numpage), PDO::PARAM_INT);
            $list->bindValue(':numlist', intval($numberProductEachPage), PDO::PARAM_INT);
            $list->execute();
            $danhsachmonan->execute();
            $listPro = $list->fetchAll(PDO::FETCH_ASSOC);
            $listAllPro = Product::getAllProducts();
            $numberProduct = count($listAllPro);
            $numberOfPage = ceil($numberProduct / $numberProductEachPage);
        ?>
        <div class="container-fluid">
            <div class="wrapper-content">
                <h2 class="wrapper-content-heading">Danh sách sản phẩm</h2>
                <a href="./addproduct.php" class="wrapper-content-add-product" >
                    <i class="fa-regular fa-plus"></i>
                    Thêm sản phẩm 
                </a>
            </div>
            <div class="wrapper-content-list">
                <div class="row">
                    <table class="table-list">
                        <thead>
                            <td>Id</td>
                            <td>Hình ảnh</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá cũ(vnd)</td>
                            <td>Giá mới(vnd)</td>
                            <td>Số lượng</td>
                            <td>Đơn vị tính</td>
                            <td>Trạng thái</td>
                            <td></td>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($listPro as $row){
                                    $priceOld = number_format($row['oldPrice'], 0, ',', ',');
                                    $priceNew = number_format($row['newPrice'], 0, ',', ',');
                                    $status = ($row['status'] == 'Show')?'Hiển thị' : 'Ẩn đi';
                                ?>

                                    <tr>
                                        <td style="color:#2e59d9;font-weight:700"><?php echo $row['idPro'] ?></td>
                                        <td>
                                            <img 
                                                src="../client/img/product/<?php echo $row['imgPro'];?>" class="img-pro" alt=""
                                            >
                                        </td>
                                        <td><?php echo $row['namePro'] ?></td>
                                        <td><?php echo $priceOld ?></td>
                                        <td><?php echo $priceNew ?></td>
                                        <td><?php echo $row['amount'] ?></td>
                                        <td><?php echo $row['dvt'] ?></td>
                                        <td><?php echo $status ?></td>
                                        <td>
                                            <a 
                                                href="productDetail.php?idPro=<?php echo $row['idPro'] ?>"
                                                class="linkItem"
                                            >
                                                Xem chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            ?>

                        </tbody>
                    </table>
                    <div class="paging">
                        <ul>
                            <li>
                                <a href="product.php?page=1">
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>

                            </li>
                            <li>
                                <a href="product.php?page=<?php echo ($_GET['page'] == 1) ? 1 : ($_GET['page'] - 1); ?>">
                                    <i class="fa-solid fa-angle-left"></i>
                                </a>
                            </li>

                            <?php
                                for ($i = 1; $i <= $numberOfPage; $i++) {
                                    if($i == $_GET['page']){
                                        ?>
                                            <li>
                                                <a 
                                                    href="product.php?page=<?php echo $i ?>" 
                                                    class="active"
                                                >
                                                    <?php echo $i ?>
                                                </a>
                                            </li>
                                        <?php
                                    }else{
                                        ?>
                                            <li>
                                                <a 
                                                    href="product.php?page=<?php echo $i ?>" 
                                                    class=""
                                                >
                                                    <?php echo $i ?>
                                                </a>
                                            </li>
                                        <?php
                                    }
                                }
                            ?>
                            <li>
                                <a href="product.php?page=<?php echo ($_GET['page'] == $numberOfPage) ? $numberOfPage : ($_GET['page'] + 1); ?>">
                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </li>
                            <li>
                                <a href="product.php?page=<?php echo $numberOfPage;?>">
                                <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
<?php require "layout/footer.php" ?>