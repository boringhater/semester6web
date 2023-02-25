<?php include 'code.php'; ?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

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
    <?php
    if (!checkAuthorization()) {
        placeLogRegOverlays();
    }
    ?>
    <!--popup-->

    <!-- header section -->
    <section class="banner" role="banner" id="main_banner">
        <!--header navigation -->
        <header id="header">
            <div class="header-content clearfix">
                <a class="logo" href="#"><img src="images/logo.png" alt=""></a>
                <nav class="navigation" role="navigation">
                    <ul class="primary-nav">
                        <?php fillMenuBar(); ?>
                    </ul>
                </nav>
                <a href="#" class="nav-toggle">Menu<span></span></a>
            </div>
        </header>
        <!--header navigation -->
        <!-- banner text -->
        <div class="container">
            <div class="col-md-10 col-md-offset-1">
                <div class="banner-text text-center">
                    <h1>foreign</h1>
                    <p>Лучшая студия переводов во всём ВШиСИСТе*</br></br></br>* При условии отсутствия иных студий</p>
                    <nav role="navigation"> <a href="#services" class="banner-btn"><img src="images/down-arrow.png" alt=""></a></nav>
                    <p></p>
                </div>
                <!-- banner text -->
            </div>
        </div>
    </section>
    <!-- header section -->

    <!-- services section -->
    <section id="services" class="services service-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 services">
                    <span class="icon icon-video"></span>
                    <div class="services-content">
                        <h5>Видеоматериалы</h5>
                        <p>Перевод текста и аудиосопровождения видеоматериалов. Текстовая расшифровка, голосовое сопровождение, субтитры, видео и аудио монтаж.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 services">
                    <span class="icon icon-briefcase"></span>
                    <div class="services-content">
                        <h5>Юридический перевод</h5>
                        <p>Перевод документов строго практикующими юристами с дополнительным лингвистическим образованием, а также сопроводительное нотариальное заверение.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 services">
                    <span class="icon icon-tools"></span>
                    <div class="services-content">
                        <h5>Публицистический перевод</h5>
                        <p>Художественный перевод книг, сценариев, газетных статей и рекламных текстов. Верстка, сохранение форматирования, работа с графикой.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 services">
                    <span class="icon icon-genius"></span>
                    <div class="services-content">
                        <h5>Технический перевод</h5>
                        <p>Корректный перевод технических текстов и документации с применением собственных терминологических баз и словарей.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- services section -->
    <!-- Testimonials section -->
    <section id="testimonials" class="section testimonials no-padding">
        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <div class="col-md-12">
                                <blockquote>
                                    <h1>- Вы продоёте переводов?</br>- Нет, только сайт показываем.</br>- Красивое.</h1>
                                </blockquote>
                            </div>
                        </li>
                        <li>
                            <div class="col-md-12">
                                <blockquote>
                                    <h1>В составе команды только верстальщик сайтов, поэтому надежность переводов под сомнением...</h1>
                                </blockquote>
                            </div>
                        </li>
                        <li>
                            <div class="col-md-12">
                                <blockquote>
                                    <h1>Возможно, перевода вы и не получите вовсе...<br />Но вы только посмотрите на этот сайт!</h1>
                                </blockquote>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials section -->
    <!-- Get a quote section -->
    <?php if (checkAuthorization()) : ?>
        <section id="contact" class="section quote">
            <div class="container">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h3>Раз долистали сюда, может, стоит нажать на эту красивую кнопку</h3>
                    <a href="order.php" class="btn btn-large">Заказать</a>
                </div>
            </div>
        </section>
    <?php else : ?>
        <section id="contact" class="section quote">
            <div class="container">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h3>Здесь могла быть кнопка "заказать", но для этого надо</h3>
                    <a class="btn btn-large" onclick="animateShow('reg_overlay');">Зарегистрироваться</a>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- Get a quote section -->
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