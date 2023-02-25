<?php include 'code.php'; ?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foreign</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/flexslider.css">
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/font-icon.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<body>
    <!--popup-->
    <script src="js/main.js"></script>
    <!--popup-->
    <?php if (!checkAuthorization()) : ?>
        <script type="text/javascript">
            youShallNotPass();
        </script>
    <?php endif; ?>
    <!--popup-->

    <!-- header section -->
    <section class="banner" role="banner" id="main_banner">
        <!-- banner text -->
        <div class="container">
            <div class="col-md-10 col-md-offset-1">
                <div class="banner-text text-center">
                    <h1>Спасибо за заказ!</h1>
                    <p>Ваша заявка будет рассмотрена нашими сотрудниками в ближайшее время.</br></br>Статус заказа всегда можно посмотреть в профиле.</p>
                    <p></p>
                    <h1 id="mainCountdown">5</h1>
                    <script type="text/javascript">
                        mainPagecountdown("mainCountdown", 5);
                    </script>
                </div>
                <!-- banner text -->
            </div>
        </div>
    </section>
    <!-- Footer section -->
    <footer class="footer">
        <div class="footer-top section">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-12">
                        <p>E-mail: apmolokanova@gmail.com</p>
                        <p>Copyright © 2022 boringhater. Все права защищены. Ну точнее ещё нет, но это ничего не значит.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer top -->
    </footer>
    <!-- Footer section -->
    <!-- JS FILES -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.flexslider-min.js"></script>
    <script src="js/jquery.fancybox.pack.js"></script>
    <script src="js/retina.min.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/main.js"></script>
</body>

</html>