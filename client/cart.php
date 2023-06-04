<?php ?>
<?php
    require_once "./layout/header.php" ;
    require_once "../model/Order.php";
    require_once "../model/Product.php";
    require_once "../model/detailOrder.php";
    if(isset($_GET['delitem'])){
        $idPro = $_GET['delitem'];
        $idOrder = detailOrder::getIdOrderUnconfirmed($_SESSION['idUser']);
        detailOrder::deleteProInOrder($idOrder['idOder'],intval($idPro));
    }
    if(isset($_POST['submit']) && !empty($_SESSION['idUser'])){
        // THÔNG TIN SẢN PHẨM SAU KHI THÊM VÀO GIỎ HÀNG
        $idPro = $_POST['idPro'];
        $price = $_POST['newPrice'];
        $quantity = $_POST['quantity'];

        //KIỂM TRA ID ORDER MỚI CÓ ĐƯỢC TẠO HAY CHƯA 
        $num = detailOrder::getIdOrderNewCreate($_SESSION['idUser']);

        //NẾU $NUM === FALSE LÀ CHƯA CÓ ĐƯỢC TẠO ID ORDER MỚI VÀ detailOrder::checkStatusUserOrder($_SESSION['idUser']) === true LÀ KIỂM 
        //TRA CÓ TỒN TẠI SẢN PHẨM NÀO HAY CHƯA TRONG IDORDER NÀY NẾU ĐÁP ỨNG ĐƯỢC 2 ĐIỀU TRÊN THÌ SẼ TẠO ĐƠN HÀNG MỚI IDORDER 
        if($num === false && detailOrder::checkStatusUserOrder($_SESSION['idUser']) === true){
            Order::addOrderForUser($_SESSION['idUser']); 
        }

        //NẾU CÓ SẢN PHẨM TRONG ĐƠN HÀNG VÀ CHƯA ĐƯỢC CẬP NHẬP MUA HÀNG THÌ THÊM VÀO
        if(!detailOrder::checkStatusUserOrder($_SESSION['idUser'])){
            $idOrderNew = detailOrder::getIdOrderUnconfirmed($_SESSION['idUser']);
            if(detailOrder::checkIdProInOrder($idOrderNew['idOder'],$idPro)){
                detailOrder::addDetailOrderForUser($idOrderNew['idOder'],intval($idPro),intval($quantity),doubleval($price));
            }else{
                detailOrder::updateQuantityProInOrder($idOrderNew['idOder'],intval($idPro),intval($quantity));
            }
        }else{
            //NGƯỢC LẠI THÌ THÊM VÀO GIỎ HÀNG CÓ IDORDER TRỐNG
            $idOrderNew = detailOrder::getIdOrderNewCreate($_SESSION['idUser']);
            if(detailOrder::checkIdProInOrder($idOrderNew['idOder'],$idPro)){
                detailOrder::addDetailOrderForUser($idOrderNew['idOder'],intval($idPro),intval($quantity),doubleval($price));
            }else{
                detailOrder::updateQuantityProInOrder($idOrderNew['idOder'],intval($idPro),intval($quantity));
            }
        }
    } 
    if(isset($_SESSION['idUser'])){
        //Thực hiện các xử lý khi biến $_SESSION['idUser'] đã được định nghĩa
        $idOrder = detailOrder::getIdOrderUnconfirmed($_SESSION['idUser']);
        if(!$idOrder){
            $idOrder['idOder']=0;
        }
        $listCart = detailOrder::getProductFromIdOrder($idOrder['idOder'],$_SESSION['idUser']);
    }
    if (isset($_GET['newValue']) && isset($_GET['idPro'])) {
        $productId = $_GET['idPro'];
        $newValue = $_GET['newValue'];
        detailOrder::updateQuantityProInOrder($idOrder['idOder'],intval($productId),intval($newValue));
    }
    
?>
<style>
    .cart-item{
        padding: 10px;
        border-bottom:1px solid #7fad39;
        margin-bottom: 10px;
        display: flex;
        align-items:center; 
        justify-content: space-between;
    }
    .cart-item-name{
        display: flex;
        align-items: center;  
        gap: 40px;
    }
    .cart-item-name img{
        height: 80px;
        aspect-ratio: 1 / 1;
        border:1px solid #7fad39;
    }
    .cart-item-name h2{
        color:#7fad39;
    }
    .input-group {
        display: flex;
        align-items: center;
    }
    .btn-minus, .btn-plus {
        background-color: #7fad39;
        color:white;
        border:none;
        font-size: 16px;
        padding: 8px;
        cursor: pointer;
    }
    .input-group input{
        width: 50px;
        height: 100%;
        padding: 4px;
    }
    .btn-minus {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .btn-plus {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .cart-item-price{
        display: flex;
        align-items: center;  
        gap: 20px;
    }
    .cart-item-price .price{
        display: block;
        width: 150px;
    }
    .cart-item-detele a,.cart-item-detele a:hover{
        color:red;
    }
    .primary-btn.buy-checkout{
        display: block;
        width: 100%;
        border:none;
    }
    .btn-link{
        display: flex;
        align-items: center;  
        justify-content: center;
    }
    .btn-link .link{
        text-decoration:none;
        color:white;
        display: inline-block;
        margin: 10px 0;
        font-weight: 500;
        font-size: 19px;
        padding: 10px;
        background-color:#7fad39;
        border-radius:3px;
    }
    .btn-link .link:hover{
        color:white;
        text-decoration:none;
    }
    .no__login-heading{
        margin: 20px 0;
        font-weight: bold;
        color:green;
        text-align:center;
    }
    .shoping__cart__item img{
        height: 80px;
        aspect-ratio: 1 / 1;
        border:1px solid #7fad39;
        border-radius:5px;
    }
    .no_item-cart{
        text-align:center;
        color:#7fad39;
        font-weight: bold;
        font-size: 20px;
    }
    .icon_close{
        color:#999;
        text-decoration:none;
        font-size: 20px;
    }
    .icon_close:hover{
        color:#999;
        text-decoration:none;
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
                        <input type="text" name="search" placeholder="What do yo u need?">
                        <button type="submit" name="submit" class="site-btn">SEARCH</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Giỏ Hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Trang chủ</a>
                            <span>Giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <?php
        if(!isset($_SESSION["idUser"])){
        ?>
            <div class="container">
                <h2 class="no__login-heading">Bạn cần phải đăng nhập thì mới xem được giỏ hàng </h2>
                <div class="btn-link">
                    <a href="../login.php" class="link">Đăng nhập ngay</a>
                </div>
            </div>
        <?php
        }else{
        ?>
            <!-- Shoping Cart Section Begin -->
            <form action="order.php" method="post" class="shoping-cart spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shoping__cart__table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="shoping__product">Sản phẩm</th>
                                            <th>Giá(VND)</th>
                                            <th>Số lượng</th>
                                            <th>Tổng (VND)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(count($listCart)<1){
                                            ?>
                                                <tr>
                                                    <td colspan="5" class="no_item-cart">Bạn chưa có sản phẩm nào trong giỏ hàng</td>
                                                </tr>
                                            <?php
                                            }else{
                                                foreach($listCart as $row){
                                                    $itemPro = Product::getProductWhenHaveID($row['idPro']);
                                                    ?>
                                                    <tr>
                                                        <td class="shoping__cart__item">
                                                            <input type="text" class="amount-item" hidden value="<?php echo $itemPro['amount']?>">
                                                            <a href="productDetail.php?idPro=<?php echo $row['idPro']?>">
                                                                <img src="img/product/<?php echo $itemPro['imgPro']?>" alt="">
                                                            </a>
                                                            <h5><?php echo $itemPro['namePro']?></h5>
                                                        </td>
                                                        <td class="shoping__cart__price price-item">
                                                            <?php echo $row['pricePro']?>
                                                        </td>
                                                        <td class="shoping__cart__quantity">
                                                            <div class="quantity">
                                                                <div class="pro-qty">
                                                                    <input type="number" value="<?php echo $row['numPro']?>" name="quantity" class="quantity-item" data-id-pro="<?php echo $row['idPro']; ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="shoping__cart__total total-item">
                                                            <?php echo $row['total']?>
                                                        </td>
                                                        <td class="shoping__cart__item__close">
                                                            <a href="cart.php?delitem=<?php echo $row['idPro']?>" class="icon_close"></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shoping__cart__btns">
                                <a href="index.php" class="primary-btn cart-btn">Tiếp tục mua hàng</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                        <div class="col-lg-6">
                            <div class="shoping__checkout">
                                <h5>Tổng sản phẩm</h5>
                                <ul>
                                    <li>Tổng giá sản phẩm (VNĐ): <span id="sub-total">0</span></li>
                                    <li>Phí ship(COD)(VND): <span id="sub-cod">10,000</span></li>
                                    <li>Tổng cộng (VND) <span id="total">0</span></li>
                                </ul>
                                <button type="submit" name="submit" class="primary-btn buy-checkout">XÁC NHẬN ĐẶT HÀNG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Shoping Cart Section End -->
        <?php
        }
    
    ?>
    <script>
        const counting = document.querySelectorAll(".quantity-item");
        const priceItems = document.querySelectorAll(".price-item");
        const totalItems = document.querySelectorAll(".total-item");
        const amountItems = document.querySelectorAll(".amount-item");
        const subTotal = document.querySelector("#sub-total");
        const subCod = document.querySelector("#sub-cod");
        const total = document.querySelector("#total");
        let sum =0;
        console.log(counting,priceItems,totalItems,amountItems);
        counting.forEach((e, i) => {
            e.addEventListener('input',function() {
                if(parseInt(e.value) >= parseFloat(amountItems[i].value) ){
                    e.value = amountItems[i].value;
                }else if(e.value <2 ){
                    e.value=1;
                }
                totalItems[i].innerHTML = (parseFloat(priceItems[i].innerHTML) * parseInt(e.value.toString())).toString();
                let sum=0;
                sum+=parseFloat(totalItems[i].innerHTML);
                subTotal.innerHTML = sum.toString();
                total.innerHTML = (sum + parseFloat(subCod.innerHTML) ).toString();
                const productId = e.getAttribute('data-id-pro');
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'cart.php?newValue=' + e.value + '&idPro=' + productId);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send();
            })
            sum+=parseFloat(totalItems[i].innerHTML);
            subTotal.innerHTML = sum.toString();
            total.innerHTML = (sum + parseFloat(subCod.innerHTML) ).toString();
        });

    </script>

<?php require_once "layout/footer.php" ?>