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
    .box:hover{
        color:white;
        text-decoration:none;
    }
</style>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require "layout/wrapper.php"?>
        <div class="container-fluid">
            <div class="row">
                <h2 class="wrapper-content-heading">Trang chủ</h2>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <a href="product.php" class="box">
                        <i class="fa-brands fa-apple"></i>
                        <span>Quản lý sản phẩm</span>
                    </a>
                </div>
                <?php
                    if($_SESSION['idRole'] == 1){
                        ?>
                            <div class="col-lg-4">
                                <a href="employee.php" class="box">
                                    <i class="fa-solid fa-circle-user"></i>
                                    <span>Quản lý nhân viên</span>
                                </a>
                            </div>
                        <?php
                    }
                ?>
                <div class="col-lg-4">
                    <a href="customer.php" class="box">
                        <i class="fa-solid fa-circle-user"></i>
                        <span>Quản lý khách hàng</span>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="storage.php" class="box">
                        <i class="fa-sharp fa-solid fa-warehouse"></i>
                        <span>Quản lý hàng tồn kho</span>
                    </a>
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