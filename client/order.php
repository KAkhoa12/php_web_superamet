<?php
    require_once "layout/header.php" ;
    require_once "../model/User.php" ;
    require_once "../model/Order.php" ;
    require_once "../model/detailOrder.php" ;
    $user = User::getUserById($_SESSION['idUser']);
    $idOrder = detailOrder::getIdOrderUnconfirmed($_SESSION['idUser']);
    $listOrder = detailOrder::getProductFromIdOrder($idOrder['idOder'],$_SESSION['idUser']);
    
?>
<style>
    h3,h1,h2{
        color:#7fad39;
    }
    .header-context{
        text-align:center;
        margin: 20px 0;
        font-size: 40px;
        width: 100%;
    }
    .header-title{
        font-size:18px;
    }
    .table-list{
        width: 100%;
    }
    .table-list thead td{
        font-weight:bold;
        font-size:16px;
    }
    .header-shipping{
        width: 100%;
        display: flex;
        align-items: center;  
        justify-content: space-around;
        margin: 20px 0;
    }
    .buy-now{
        background-color:#7fad39;
        padding: 8px 10px;
        font-size:20px;
        border-radius:5px;
        color:white;
        outline:none;
    }
    .btn-box{
        display: flex;
        align-items: center;  
        justify-content: center;
    }
    .img-pro{
        height: 55px;
    }
</style>
<div class="container">
    <div class="row">
        <h1 class="header-context">Đơn đặt hàng của quý khách</h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="orderSuccess.php" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="header-title">Tên khách hàng:<?php echo $user['nameUser'] ?></h3>
                        <h3 class="header-title">Giới tính: <?php echo $user['gender'] ?></h3>
                    </div>
                    <div class="col-lg-6">
                        <h3 class="header-title">Số điện thoại: <?php echo $user['phoneNumber'] ?></h3>
                        <h3 class="header-title">Địa chỉ: <?php echo $user['address'] ?></h3>
                    </div>
                </div>
                <h2 class="header-context">Danh sách sản phẩm đặt hàng</h2>
                <div class="row">
                    <table class="table-list">
                        <thead>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td>Thành tiền</td>
                            
                        </thead>
                        <tbody>
                            <?php 
                                $thanhtien =0;
                                foreach($listOrder as $row){
                                ?>
                                    <tr>
                                        <td>
                                            <img src="./img/product/<?php echo $row['imgPro'];?>" class="img-pro" alt="">
                                        </td>
                                        <td><?php echo $row['namePro'] ?></td>
                                        <td><?php echo $row['pricePro'] ?></td>
                                        <td><?php echo $row['numPro'] ?></td>
                                        <td><?php echo $row['total'] ?>vnd</td>
                                    </tr>
                                <?php
                                $thanhtien += $row['total'];
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="header-shipping">
                        <h3>
                            shipping: 10000(VND)
                        </h3>
                        <h3>
                            <input type="text" name="tongtien" hidden value="<?php echo $thanhtien+10000 ?>">
                            Thành tiền :<?php echo $thanhtien+10000 ?>vnd
                        </h3>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-box">
                            <button type="submit" name="submit" class="buy-now">Đặt hàng ngay</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    require_once "layout/footer.php" 
?>