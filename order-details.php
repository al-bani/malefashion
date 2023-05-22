<?php
    include('server/connection.php');

    if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];

        $query_order_details = "SELECT * FROM order_items WHERE order_id = ?";

        $stmt_order_details = $conn->prepare($query_order_details);
        $stmt_order_details->bind_param('i', $order_id);
        $stmt_order_details->execute();
        $order_details = $stmt_order_details->get_result();

        $order_total_price = calculateTotalOrderPrice($order_details);
    } else {
        header('location: account.php');
        exit;
    }

    function calculateTotalOrderPrice($order_details) {
        $total = 0;

        foreach($order_details as $row) {
           $product_price = $row['product_price'];
           $product_quantity = $row['product_quantity'];

           $total = $total + ($product_price * $product_quantity);
        }

        return $total;
    }

    include('layout/header.php');
?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Order Details</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Order Details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Order Details Section Begin -->
    <section id="orders" class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Order Details</h2>
                        <span>***</span>
                    </div>
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order_details as $row) { ?>
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="img/product/<?php echo $row['product_image']; ?>" alt="">
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6><?php echo $row['product_name']; ?></h6>
                                                <h5><?php echo setRupiah(($row['product_price'] * $kurs_dollar)); ?></h5>
                                            </div>
                                        </td>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__text">
                                                <h5><?php echo $row['product_quantity']; ?></h5>
                                            </div>
                                        </td>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__text">
                                                <h5><?php echo $row['order_date']; ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($order_status == 'not paid') { ?>
                            <form method="POST" action="payment.php">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                                <input type="hidden" name="order_total_price" 
                                value="<?php echo $order_total_price; ?>" />
                                <input type="hidden" name="order_status" 
                                value="<?php echo $order_status; ?>" />
                                <input type="submit" name="order_pay_btn" class="btn btn-primary" 
                                style="float: right;" value="Pay Now" />
                                <input type="button" onclick="location.href='http://localhost:8080/account.php';" 
                                class="btn btn-secondary" style="float: right; margin-right: 15px;" value="Back" />
                            </form>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Order Details Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="img/footer-logo.png" alt=""></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="img/payment.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Clothing Store</a></li>
                            <li><a href="#">Trending Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sale</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Delivary</a></li>
                            <li><a href="#">Return & Exchanges</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>2020
                            All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>