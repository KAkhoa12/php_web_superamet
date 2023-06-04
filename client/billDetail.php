<?php require_once "layout/header.php" ?>
<?php
    require_once "../model/Order.php";
    $list = Order::getOrderByIdUser($_SESSION['idUser']);
?>
<style>
    .quantity{
        color:green;
        font-weight:bold;
        padding-right:10px;
        font-size: 20px;
    }
    .name{
        color:black;
        font-weight: 600;
        font-size: 20px;
    }
    .block-order{
        margin-top: 20px;
        padding: 10px 0;
    }
    .link{
        display: inline-block;
        padding: 4px 10px;
        border-radius:5px;
        border:1px solid green;
        margin-left: 20px;
        color:green;
        transition: all linear 0.3s;
    }
    .link:hover{
        background-color: green;
        color:white;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Lịch sử mua hàng của bạn</h2>
        </div>
        <div class="col-lg-12">
            <?php
                if(count($list)==0){
                ?>
                    <p style="display:flex; justity-content:center" >
                        <div>Bạn chưa có lịch sử mua hàng nào </div>
                        <a href="listProduct.php">Mua hàng ngay</a>
                    </p>
                <?php
                }else{
                    $count=1;
                    foreach($list as $row){
                    ?>
                        <p class="block-order">
                            <span class="quantity" ><?php echo $count ?></span>
                            <span class="name" >Đơn hàng số ##<?php echo $row['idOder'] ?></span>
                            <a href="detailBillByOrder.php?idOrder=<?php echo $row['idOder'] ?>" class="link">Xem chi tiết</a>
                        </p>
                    <?php
                    $count++;
                    }
                }
            ?>
        </div>
    </div>
</div>

<?php require_once "layout/footer.php" ?>