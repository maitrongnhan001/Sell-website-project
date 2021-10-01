<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Storeee</title>
</head>

<body>

    <body>
        <!-- Navbar Section Starts Here -->
        <section class="navbar">
            <div class="container">
                <div class="logo">
                    <a href="#" title="Logo">
                        <img src="./images/for-web/logo.jpeg" alt="Restaurant Logo" class="img-responsive">
                    </a>
                </div>

                <nav class="menu text-right">
                    <ul>
                        <li class="active"><a href="">Home</a></li>
                        <li><a href="">Catagorys</a></li>
                        <li><a href="">Food</a></li>
                        <li><a href="#">Admin</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </nav>

                <div class="clearfix"></div>
            </div>
        </section>
        <!-- Navbar Section Ends Here -->

        <section class="product-order">
            <div class="container">

                <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

                <form action="#" class="order" method="POST">
                    <fieldset>
                        <legend>Selected Food</legend>

                        <div class="product-menu-img">
                            <img src= "./images/products/Food-Name-1866.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                        </div>

                        <div class="product-menu-desc">
                            <div class="row">
                                <div class="clearfix">
                                    <h3>
                                        Product
                                    </h3>
                                    <p class="product-price">
                                        100.00
                                    </p>

                                    <input type="hidden" name="food" value="Product">
                                    <input type="hidden" id="pr" name="price" value="100">
                                </div>
                                <div class="clearfix total-container">
                                    <h3>Total</h3>
                                    <p class="product-price" id="rt"> 11</p>
                                </div>
                            </div>

                            <div class="order-label">Quantity</div>
                            <input type="number" id="ipn" name="qty" class="input-responsive" value="1" required>

                        </div>

                    </fieldset>

                    <fieldset>
                        <legend>Delivery Details</legend>
                        <div class="order-label">Phone Number</div>
                        <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive"
                            required>

                        <div class="order-label">Email</div>
                        <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive"
                            required>

                        <div class="order-label">Address</div>
                        <textarea name="address" rows="10" placeholder="E.g. Street, City, Country"
                            class="input-responsive" required></textarea>

                        <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                    </fieldset>

                </form>

            </div>
        </section>

        <!-- social Section Starts Here -->
        <section class="social">
            <div class="container text-center">
                <ul>
                    <li>
                        <a href="#"><img width="50px" src="./images/for-web/Logo-facebook.png" /></a>
                    </li>
                    <li>
                        <a href="#"><img width="50px" src="./images/for-web/Logo-Instagram.png" /></a>
                    </li>
                    <li>
                        <a href="#"><img width="50px" src="./images/for-web/Logo-Tiwtter.png" /></a>
                    </li>
                </ul>
            </div>
        </section>
        <!-- social Section Ends Here -->

        <!-- footer Section Starts Here -->
        <section class="footer">
            <div class="container text-center">
                <p>All rights reserved. Designed By <a href="#" class="pink">Mai Trong Nhan</a></p>
            </div>
        </section>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./app/menu-animation.js"></script>
    </body>

    </html>