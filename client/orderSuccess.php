<?php require_once "layout/header.php" ?>
<?php
    require_once "../model/Order.php" ;
    require_once "../model/detailOrder.php" ;
    $idOrder = detailOrder::getIdOrderUnconfirmed($_SESSION['idUser']);
    if(isset($_POST['submit'])){
        $sumMoney = $_POST['tongtien'];
        Order::updateTotalByOrder($sumMoney,$idOrder['idOder']);
        detailOrder::updateProductConfirmed($_SESSION['idUser'],$idOrder['idOder']);
    }
?>
<style>
    h1{
        font-size: 40px;
        text-align:center;
        font-weight: bold;
        color:#7fad39;
        width: 100%;
        margin: 30px 0;
    }
    .box{
        display: flex;
        align-items: center;  
        justify-content: center;
        width: 100%;
        margin: 20px 0;
    }
    .continue-link{
        display: inline-block;
        background-color:#7fad39;
        padding: 8px 15px;
        border-radius:3px;
        color:white;
    }
</style>
<div class="container">
    <div class="row">
        <h1>
            Bạn đã mua hàng thành công
        </h1>
    </div>
    <div class="row">
        <div class="box">
            <a href="listProduct.php" class="continue-link">Tiếp tục mua hàng</a>
        </div>
    </div>
</div>
<?php require_once "layout/footer.php" ?>