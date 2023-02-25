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
    <title>Заказать</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/flexslider.css">
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/font-icon.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<?php
function fillTranslationTypes()
{
    $conn = openConnection();
    $sql = "SELECT `type_id`,`type_name` from `translation_types`;";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_row()) {
        echo '<option label="' . $row[1] . '" value="' . $row[0] . '"></option>';
    }
    $conn->close();
}

function fillTranslationLangs()
{
    $conn = openConnection();
    $sql = "SELECT `language_id`,`language_name` from `languages` order by `language_id` asc;";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_row()) {
        echo '<option label="' . $row[1] . '" value="' . $row[0] . '"></option>';
    }
    $conn->close();
}

function fillEmployees() {
    $conn = openConnection();
    $sql = "SELECT * from `employees`;";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_row()) {
        echo '<option label="' . $row[3] .' '. $row[2] .'" value="' . $row[0] . '"></option>';
    }
    $conn->close();
}

?>


<body>
    <script src="js/main.js"></script>
    <!--popup-->
    <?php if (!checkAuthorization()) : ?>
        <script type="text/javascript">
            youShallNotPass();
        </script>
    <?php endif; ?>



    <!--popup-->
    <section class="banner" role="banner">
        <!-- header section -->
        <!--header navigation -->
        <header id="header">
            <div class="header-content clearfix">
                <a class="logo" href="index.php#"><img src="images/logo.png" alt=""></a>
                <nav class="navigation" role="navigation">
                    <ul class="primary-nav">
                        <li><a href="index.php">Главная</a></li>
                        <?php fillMenuBar(); ?>
                    </ul>
                </nav>
                <a href="#" class="nav-toggle">Menu<span></span></a>
            </div>
        </header>
        <!-- banner text -->
        <div class="container">
            <div class="col-md-10 col-md-offset-1">
                <div class="banner-text text-center">
                    <h1>Заказать</h1>
                    <p>Не сказала бы, что имеет смысл, но попробовать можно</p>
                    <nav role="navigation"><a href="#services" class="banner-btn"><img src="images/down-arrow.png" alt=""></a></nav>
                    <p></p>
                </div>
            </div>
        </div>
    </section>

    <?php if (checkAuthorization()) : ?>
        <section id="intro" class="section intro no-padding">
            <div class="order-form">
                <div class="container-fluid">
                    <div class="row no-gutter">
                        <div class="flexslider" style="margin-bottom:50pt;">
                            <ul class="slides">
                                <div class="col-md-6">
                                    <blockquote>
                                        <div class="col-md-12">
                                            <h1>Прочитать FAQ</h1>
                                        </div>
                                        <div class="col-md-12">
                                            <h3>Что такое тип перевода?</br> </h3>
                                            <p>Описания типов даны блоком ниже. При несоответствии заявленного реальности деньги, если они тут каким-то чудом замешаны, не возвращаются и прогуливаются администратором сайта.</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h3>Это весь блок FAQ?</h3>
                                            <p>Да. В реальности этот сайт не реализует никаких переводов, а придумывать кейсы мне лень. </br>Блок FAQ просто вписывался по дизайну, поэтому он здесь.</p>
                                        </div>
                                    </blockquote>
                                </div>
                                <div class="col-md-6">
                                    <blockquote>
                                        <div class="col-md-12">
                                            <h1>Оформить заявку</h1>
                                        </div>
                                        <form method="post" action="makeOrder.php" style="text-align:center;" enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="myrow">
                                                    <h3>Тип перевода</h3>
                                                    <select name="typeSelect" id="typeSelect" style="margin-top: 20px;">
                                                        <?php fillTranslationTypes(); ?>
                                                    </select>
                                                </div>
                                                <div class="myrow" style="justify-content:center;">

                                                </div>
                                                <div class="myrow">
                                                    <h3 style="display: flex;">Язык перевода</h3>
                                                </div>
                                                <div class="myrow" style="justify-content: space-around; margin:15px;">
                                                    <select name="fromLang" id="fromLang" style="text-align:; margin-top:auto;"><?php fillTranslationLangs(); ?></select>
                                                    <text style="margin-top: auto; margin-bottom:auto;">→</text>
                                                    <select name="toLang" id="toLang" style="text-align:center; margin-top:auto;"><?php fillTranslationLangs(); ?></select>
                                                </div>
                                                <div class="myrow">
                                                    <h3>Переводчик</h3>
                                                    <select name="employeeSelect" id="employeeSelect" style="margin-top: 20px;">
                                                        <?php fillEmployees(); ?>
                                                    </select>
                                                </div>
                                                <div class="myrow">
                                                    <h3>Файл</h3>
                                                    <input type="file" name="fileInput" id="fileInput" accept="" style="display:flex; margin-top:20px; justify-items:end;" required/>
                                                </div>
                                                <div class="col-md-12"><input type="submit" class="btn btn-large" style="align-self: center; justify-self:center; margin-top:20px;" name="submitOrderBtn" id="submitOrderBtn"
                                                value="ОТПРАВИТЬ" onclick="if(isOrderFilled()){ true; } else { alert('Отсутствует файл'); return false;}"></div>
                                            </div>
                                        </form>
                                </div>
                                </blockquote>
                        </div>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </section>
    <?php endif; ?>



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
    <script src="js/order.js"></script>
</body>

</html>