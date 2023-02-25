<?php

$loginCookieId = 'userLogin';

   

function openConnection()
{
    /*$servername = "localhost";
    $username = "root";
    $db_password = "vertrigo";
    $dbname = "semester_project";*/
    $servername = "localhost";
    $username = "t91552yt_project";
    $db_password = "Vertrigo123";
    $dbname = "t91552yt_project";
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return false;
    } else {
        return $conn;
    }
}

function phpAlert($string)
{
    echo '<script type ="text/JavaScript">';
    echo 'alert("' . $string . '")';
    echo '</script>';
}


if (isset($_POST["submitLoginBtn"])) {
    logIn($_POST['email_input'], $_POST['password_input']);
}

if (isset($_POST["submitRegBtn"])) {
    register($_POST['email_input'], $_POST['password_input'], $_POST['password_check_input']);
}

if (isset($_GET['logout'])) {
    logOut();
}

function checkAuthorization()
{
    return isset($_COOKIE[$GLOBALS['loginCookieId']]);
}



function logIn($email, $password)
{
    $conn = openConnection();

    $sql = "SELECT * FROM `users` where `email` = '$email' and `password` = '$password'";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);

    if ($result->num_rows > 0) {
        $id = $result->fetch_row()[0];
        setcookie($GLOBALS['loginCookieId'], $id);
        header("Refresh:0;");
    } else {
        phpAlert("Неправильная почта и/или пароль.");
    }
    $conn->close();
}
function logOut()
{
    setcookie($GLOBALS['loginCookieId'], "", 1);
    unset($_COOKIE[$GLOBALS['loginCookieId']]);
    header("Refresh:0; url=index.php");
}


function register($email, $pass, $passCheck)
{
    $conn = openConnection();
    if (checkUniqueMail($conn, $email)) {
        if ($pass != "" && $pass == $passCheck) {
            $sql = "INSERT INTO `users` (`email`,`password`) VALUES ('$email','$pass')";
            $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
            if ($result != false) {
                logIn($email, $pass);
            }
        } else {
            phpAlert("Пароли не совпадают");
        }
    } else {
        phpAlert("Аккаунт с этим почтовым адресом уже зарегистрирован.");
    }
    $conn->close();
}

function checkUniqueMail($conn, $email)
{
    $sql = "SELECT * FROM `users` where `email` = '$email'";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);

    return !($result->num_rows > 0);
}

function employeeExists($conn)
{
    $id = $_COOKIE[$GLOBALS['loginCookieId']];
    $sql = "SELECT `employee_id` FROM `employees` where `user_id` = $id";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);

    return ($result->num_rows > 0);
}


function fillMenuBar()
{
    if (checkAuthorization()) {
        echo '<li><a href="order.php">Заказать</a></li>';
        echo '<li><a href="profile.php" id="profileRef">ПРОФИЛЬ</a></li>';
        echo '<li><a name="exitBtn" id="exitBtn"' . "href='index.php?logout=true'>ВЫХОД</a></li>";
    } else {
        $logOverId = "'login_overlay'";
        $regOverId = "'reg_overlay'";
        echo '<li><a name="enterBtn" id="enterBtn" onclick="animateShow(' . $logOverId . ');"">ВХОД</a></li>';
        echo '<li><a name="regBtn" id="regBtn" onclick="animateShow(' . $regOverId . ');"">РЕГИСТРАЦИЯ</a></li>';
    }
}

function placeLogRegOverlays()
{
    echo <<<GFG
    <div class="black-overlay" style="display: none;" id="login_overlay">
        <button class="btn btn-large" id="login_hide_btn" onclick="animateHide('login_overlay');" style="font-weight:100;font-size: 30px;">x</button>
        <div class="overlay-form banner-text">
            <form method="post" action="">
                <h1>E-MAIL</h1></br>
                <input type="email" id="email_input" name="email_input" />
                <h1>ПАРОЛЬ</h1></br>
                <input type="password" id="password_input" name="password_input"/></br></br></br>
                <input type="submit" class="btn btn-large" id="submitLoginBtn" name="submitLoginBtn" value="ВОЙТИ" />
            </form>
        </div>
    </div>

    <div class="black-overlay" style="display: none;" id="reg_overlay">
        <button class="btn btn-large" id="reg_hide_btn" onclick="animateHide('reg_overlay');" style="font-weight:100;font-size: 30px;">x</button>
        <div class="overlay-form banner-text">
            <form method="post" action="">
                <h1>E-MAIL</h1></br>
                <input type="email" id="email_input" name="email_input" />
                <h1>ПАРОЛЬ</h1></br>
                <input type="password" id="password_input" name="password_input"/></br>
                <h1>ПАРОЛЬ (ОПЯТЬ)</h1></br>
                <input type="password" id="password_check_input" name="password_check_input" /></br></br></br>
                <input type="submit" class="btn btn-large" id="submitRegBtn" name="submitRegBtn" value="ЗАРЕГИСТРИРОВАТЬСЯ" />
            </form>
        </div>
    </div>
GFG;
}

function getLangName($langId)
{
    $conn = openConnection();
    $sql = "SELECT `language_name` FROM `languages` where `language_id` = $langId;";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);

    $langName = null;
    while ($row = $result->fetch_row()) {
        $langName = $row[0];
    }
    $conn->close();
    return $langName;
}

function getTypeName($typeId)
{
    $conn = openConnection();
    $sql = "SELECT `type_name` FROM `translation_types` where `type_id` = $typeId;";
    $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);

    $typeName = null;
    while ($row = $result->fetch_row()) {
        $typeName = $row[0];
    }
    $conn->close();
    return $typeName;
}

function getActiveUserMail()
{
    if (checkAuthorization()) {
        $conn = openConnection();
        $user_id = $_COOKIE[$GLOBALS['loginCookieId']];
        //$sql = "SELECT `email` FROM `users` where `user_id` = " . $user_id . ";";
        $sql = "SELECT getUserMail(".$user_id.");";
        $result = mysqli_query($conn, $sql, MYSQLI_STORE_RESULT);
        $mail = null;
        while ($row = $result->fetch_row()) {
            $mail = $row[0];
        }
        $conn->close();
        return $mail;
    }
}

function downloadFile($filepath)
{

    echo '<script type ="text/JavaScript">';
    echo 'wnd = window.open("'.$filepath.'","Download");';
    echo '</script>';
    /*
    clearstatcache();
    //Check the file exists or not
    if (file_exists($filepath)) {
        //Define header information
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Pragma: public');
        header('HTTP/1.0 200 OK', true, 200);
        //Clear system output buffer
        flush();
        //Read the size of the file
        readfile($filepath);
        //Terminate from the script
        die();
        return true;
    } else {
        return false;
    }*/
}