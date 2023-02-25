<?php include 'upload.php'; ?>
<?php include 'code.php'; ?>
<?php
$datetimeFormat = 'd.m.Y H-i-s';

$employeeId = $_POST['employeeSelect'];
$userId = $_COOKIE['userLogin'];
$typeId = $_POST['typeSelect'];
$fromLang = $_POST['fromLang'];
$toLang = $_POST['toLang'];
$orderDate = date($datetimeFormat);

$target_dir = "users_files/";

$fileName = $_FILES["fileInput"]["name"];
if ($fileName == "") {
  orderError();
} else {
  $target_file = $target_dir . basename("user_" . $userId . " " . $orderDate . " " . $fileName);
  $uploadOK = uploadFile($target_file);

  if ($uploadOK != 0) {
    $conn = openConnection();
    $sql = "INSERT INTO `orders` (`employee_id`, `user_id`, `type_id`,`from_lang_id`, `to_lang_id`, `initial_file_path`, `order_date`) VALUES (" . $employeeId . ", " . $userId . ", " . $typeId . "," . $fromLang . ", " . $toLang . ",'" . $target_file . "' ,STR_TO_DATE('" . $orderDate . "', '%d.%m.%Y %H-%i-%s'));";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
      orderError();
    }
    $conn->close();
    sendMail($orderDate, $fromLang, $toLang, $typeId);
    orderSuccess();
  } else {
    orderError();
  }
}

function orderError()
{
  echo '
    <script type="text/javascript">
      window.location.replace("orderError.php");
    </script>
    ';
}
function orderSuccess()
{
  echo '
      <script type="text/javascript">
        window.location.replace("orderSuccess.php");
      </script>
      ';
}
function sendMail($orderDate, $fromLang, $toLang, $typeId)
{
  $to = getActiveUserMail();
  $fromLangName = getLangName($fromLang);
  $toLangName = getLangName($toLang);
  $typeName = getTypeName($typeId);
  $subject = "Заявка на перевод от " . $orderDate;
  $message = "Ваша заявка от " . $orderDate . " на " . $typeName . " перевод с языка\"" . $fromLangName . "\" на язык \"" . $toLangName . "\" была принята.
    </br>Заявка может быть, в зависимости от корректности введенных данных, как принята, так и отклонена.
    </br>Актуальный статус заявки всегда доступен в профиле пользователя.
    </br></br>Данное сообщение сгенерировано автоматически.";
  $from = "support@t91552yt.beget.tech";
  $headers = "From:" . $from . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html\r\n";

  mail($to, $subject, $message, $headers);
}

?>