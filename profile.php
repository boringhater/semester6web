<?php include 'code.php'; ?>
<?php include 'upload.php'; ?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Профиль</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/flexslider.css">
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/font-icon.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<script src="js/profile.js"></script>
<?php
if (isset($_GET['downloadTranslation'])) {
    downloadTranslation($_GET['downloadTranslation']);
}
if (isset($_GET['downloadOrder'])) {
    downloadOrder($_GET['downloadOrder']);
}

if (isset($_POST['editOrderId'])) {
    $conn = openConnection();
    $sql = "update `orders` set `status_id` = " . $_POST['newStatusId'] . " where order_id = " . $_POST['editOrderId'] . ";";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    $conn->close();
}


if (isset($_POST['translatedOrderId'])) {
    $target_dir = "translated_files/";
    $target_file = $target_dir.basename("order_".$_POST['translatedOrderId']."_".$_FILES['fileInput']["name"]);
    if(uploadFile($target_file)){
        $conn = openConnection();
        $sql = "update `orders` set `status_id` =  4, `translated_file_path` = '".$target_file."' where order_id = " . $_POST['translatedOrderId'] . ";";
        $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
        $conn->close();
    }
}

if (isset($_POST['removeUsers'])) {
    if (!empty($_POST['users_check_list'])) {
        $usersVals = "";
        // Loop to store and display values of individual checked checkbox.
        foreach ($_POST['users_check_list'] as $selected) {
            $usersVals = $usersVals.$selected.",";
        }
        $usersVals = substr($usersVals, 0, -1);
        $pdo = new PDO("mysql:host=localhost;dbname=t91552yt_project", 't91552yt_project', 'Vertrigo123');
        $stmt = $pdo->prepare('DELETE FROM `users` WHERE `user_id` in ('.$usersVals.');');
        $stmt->execute();
        $pdo = null;
    }
}

function formOrdersList($userId)
{
    $conn = openConnection();
    $sql = "CALL getUserOrdersInfo(" . $userId . ")";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_row()) {
        echo '<script type="text/javascript">';
        echo 'createOrderView("orders_list", "' . $row[1] . '", "' . $row[2] . '","' . $row[3] . '","' . $row[4] . '", "' . $row[5] . '", "' . $row[0] . '")';
        echo '</script>';
    }
    $conn->close();
}
function formJobsList($userId)
{
    $conn = openConnection();
    $sql = "CALL getUserJobsInfo(" . $userId . ")";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_row()) {
        echo '<script type="text/javascript">';
        echo 'createJobView("jobs_list", "' . $row[1] . '", "' . $row[2] . '","' . $row[3] . '","' . $row[4] . '", "' . $row[5] . '", "' . $row[0] . '", "' . $row[6] . '")';
        echo '</script>';
    }
    $conn->close();
}


function downloadTranslation($orderId)
{
    $conn = openConnection();
    $sql = "select `translated_file_path` from `orders` where `order_id` = " . $orderId . ";";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    if (!$result) {
        echo "well, fuck";
    }
    while ($row = $result->fetch_row()) {
        downloadFile($row[0]);
    }
    $conn->close();
}

function downloadOrder($orderId)
{
    $conn = openConnection();
    $sql = "select `initial_file_path` from `orders` where `order_id` = " . $orderId . ";";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    if (!$result) {
        echo "well, fuck";
    }
    while ($row = $result->fetch_row()) {
        downloadFile($row[0]);
    }
    $conn->close();
}

function fillOrderStatuses()
{
    $conn = openConnection();
    $sql = "SELECT `status_id`,`status_message` from `statuses`;";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_row()) {
        echo '<h4><option label="' . $row[1] . '" value="' . $row[0] . '"></option></h4>';
    }
    $conn->close();
}

function fillAllUsers()
{
    $conn = openConnection();
    $sql = "SELECT `user_id`,`email` from `users` where `user_id` != 1;";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
    $longHtmlStr = "";
    echo '<div class="col-md-12" id="users_list" style="text-align:center;"><h3>Пользователи</h3>';
    while ($row = $result->fetch_row()) {
        echo '<div class="row" style="margin:15px; min-width:150px;"> 
        <input type="checkbox" name="users_check_list[]" id="user' . $row[0] . '" value="' . $row[0] . '" style="margin-right: 10px;">
        <label for="user' . $row[0] . '"><h4>' . $row[1] . '</h4></label><br></div>';
    }
    echo '</div>';
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

    <select id="statusOptions" style="display:none;">
        <?php fillOrderStatuses(); ?>
    </select>

    <form id="statusNinja" method="post" style="display:none;">
        <input type="hidden" id="editOrderId" name="editOrderId" required />
        <input type="hidden" id="newStatusId" name="newStatusId" required />
    </form>

    <div class="black-overlay" style="display: none;" id="translationInput_overlay">
        <button class="btn btn-large" id="translationInput_hide_btn" style="font-weight:100;font-size: 30px;" onclick="setDefaultJobStatus(document.getElementById('translatedOrderId').value);
		animateHide('translationInput_overlay');">x</button>
        <div class="overlay-form banner-text">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" id="translatedOrderId" name="translatedOrderId" required />
                <h1>Перевод</h1></br>
                <input type="file" name="fileInput" id="fileInput" accept="" style="display:flex; margin-top:20px; justify-items:end;" required /></br>
                <input type="submit" class="btn btn-large" id="submitTranslationBtn" name="submitTranslationBtn" value="ЗАГРУЗИТЬ ПЕРЕВОД" />
            </form>
        </div>
    </div>
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
                    <h1>Профиль</h1>
                    <p>Здесь могла быть информация про пользователя, но мы не соцсеть, так что тут только заказы</p>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 style="text-align: center;"><?php echo getActiveUserMail(); ?></h3>
                                    </div>
                                </div>
                                <div class="row" style="text-align: center; display:flex; justify-content:center;">
                                    <?php $conn = openConnection();
                                    if (employeeExists($conn)) : ?>
                                        <div class="col-md-6" id="orders_list">
                                            <h3>Мои заказы</h3>
                                            <?php formOrdersList($_COOKIE[$GLOBALS['loginCookieId']]); ?>
                                        </div>
                                        <div class="col-md-6" id="jobs_list">
                                            <h3>Моя работа</h3>
                                            <?php formJobsList($_COOKIE[$GLOBALS['loginCookieId']]) ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-md-6" id="orders_list">
                                            <h3>Мои заказы</h3>
                                            <?php formOrdersList($_COOKIE[$GLOBALS['loginCookieId']]); ?>
                                        </div>
                                    <?php endif;
                                    $conn->close(); ?>
                                </div>
                                <form class="text-center" method="post">
                                    <?php
                                    if ($_COOKIE[$GLOBALS['loginCookieId']] == 1) {
                                        echo '<img src="get_stat.php">';
                                        fillAllUsers();
                                        echo '<input type="submit" class="btn btn-large" value="Удалить" name="removeUsers">';
                                    }
                                    ?>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
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