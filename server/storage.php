<?php require "layout/navbarleft.php"?>
<style>
    .box{
        font-size: 30px;
        color:white;
        background-color: #2e59d9;
        text-decoration:none;
        display: flex;
        align-items: center;  
        justify-content: center;
        height: 100px;
        padding: 0 50px;
        gap: 20px;
        border-radius:10px;
        margin-bottom:15px;
    }
    .table-wrapper {
        height: 600px;
        overflow-y: scroll;
    }
    .table-wrapper::-webkit-scrollbar{
        display: none;
    }
    .box:hover{
        color:white;
        text-decoration:none;
    }
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
    .img-block {
        padding: 10px;
        border-radius:3px;
        border:1px solid #2e59d9;
    }
    .img-block img{
        width: 100%;
        
    }
    .img-block-content{
        display: flex;
        align-items: center;  
        justify-content: center;
        flex-direction:column;
        gap: 10px;
    }
    .img-block-content input, .img-block-content button{
        width: 100%;
        outline:none;
        border:1px solid #2e59d9;
        border-radius:3px;
        font-size: 20px;
        color:#2e59d9;
        font-weight: 500;
        padding: 15px 0;
        padding-left: 10px;
    }
    .img-block-content button{
        background-color: #2e59d9;
        color:white;
    }
    .chon-link:hover{
        background-color: #2e59d9;
        color:white;
        text-decoration:none;
    }
    .chon-link{
        color: #2e59d9;
        background-color:white;
        text-decoration:none;
        transition: all linear 0.3s;
        padding: 4px 10px;
        border-radius:20px;
        border:1px solid #2e59d9;
    }
    tr.active{
        background-color: #d0cdff;
    }
    .reset-page{
        text-decoration:none;
        background-color: #2e59d9;
        color:white;
        transition: all linear 0.3s;
        padding: 5px 10px;
        border-radius:3px;
        display: flex;
        align-items: center;  
        justify-content: center;
        margin-left: 20px;
        gap: 10px;
        margin-bottom: 10px;
        margin-top: 10px;
    }
    .reset-page:hover{
        text-decoration:none;
        background-color: #2e59d9;
        color:white;
    }
</style>
<?php
    require_once "../model/Product.php";
    $listPro = Product::getAllProducts();
    
    if(isset($_POST['submit'])){
        
        if(empty($_POST['amount'])){

        }else{
            $product = Product::getProductWhenHaveID($_POST['idPro']);
            $amountSum =intval( $product['amount'] + $_POST['amount']);
            Product::updateProductAmount($product['idPro'],$amountSum);
        }
    }
    if(isset($_GET['idPro'])){
        $pro = Product::getProductWhenHaveID($_GET['idPro']);
    }
?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require "layout/wrapper.php"?>
        <div class="container-fluid">
            <div class="row">
                <h2 class="wrapper-content-heading">Hàng tồn kho</h2>
                <a href="storage.php" class="reset-page">
                    <i class="fa-solid fa-circle-notch"></i>
                    Reset
                </a>
            </div>
            <div class="row">
                <div class="col-lg-8 table-wrapper">
                    <table class="table-list">
                        <thead>
                            <td>Mã sản phẩm</td>
                            <td>Hình ảnh</td>
                            <td>Tên sản phẩm </td>
                            <td>Số lượng hàng hiện tại</td>
                            <td></td>
                        </thead>
                        <tbody class="table-body">
                            <?php 
                                foreach($listPro as $row){
                                    if(isset($_GET['idPro']) && $_GET['idPro'] == $row['idPro']){
                                    ?>
                                        <tr class="active">
                                            <td style="color:#2e59d9;font-weight:700">
                                                <?php echo $row['idPro'] ?>
                                            </td>
                                            <td>
                                                <img 
                                                    src="../client/img/product/<?php echo $row['imgPro'];?>" class="img-pro" alt=""
                                                >
                                            </td>
                                            <td><?php echo $row['namePro'] ?></td>
                                            <td><?php echo $row['amount'] ?></td>
                                            <td>

                                                <a href="storage.php?idPro=<?php echo $row['idPro'] ?>"
                                                    class="chon-link"
                                                >
                                                    Chọn
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }else{
                                        ?>
                                        <tr>
                                            <td style="color:#2e59d9;font-weight:700">
                                                <?php echo $row['idPro'] ?>
                                            </td>
                                            <td>
                                                <img 
                                                    src="../client/img/product/<?php echo $row['imgPro'];?>" class="img-pro" alt=""
                                                >
                                            </td>
                                            <td><?php echo $row['namePro'] ?></td>
                                            <td><?php echo $row['amount'] ?></td>
                                            <td>

                                                <a href="storage.php?idPro=<?php echo $row['idPro'] ?>"
                                                    class="chon-link"
                                                >
                                                    Chọn
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                ?>

                                    
                                <?php
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <div class="img-block">
                        <img src="../client/img/product/<?php echo (isset($idPro))? $idPro['imgPro'] : 'defaultImg.jpg' ?>" alt="">
                        <form action="storage.php" method="post" class="img-block-content">
                            <input type="text" name="amount" placeholder="Thêm số lượng cho sản phẩm">
                            <input type="text" 
                            name="idPro" hidden 
                            value="<?php 
                            if(isset($_GET['idPro']))
                                echo $_GET['idPro'] ;
                            ?>"
                            placeholder="Thêm số lượng cho sản phẩm">
                            <button type="submit" name="submit"
                                <?php 
                                    if(!isset($_GET['idPro'])){
                                        echo 'disabled';
                                    }
                                ?>
                            >Thêm số lượng</button>
                        </form>
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