<?php
$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
$user = json_decode($s, true);
//$user['network'] - соц. сеть, через которую авторизовался пользователь
//$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
//$user['first_name'] - имя пользователя
//$user['last_name'] - фамилия пользователя


if (isset($_POST['token'])) {
    $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
    $user = json_decode($s, true);
    $_POST['RegistrationForm']['username'] = $user['nickname'];
    $_POST['RegistrationForm']['password'] = $_POST['RegistrationForm']['verifyPassword'] = Helper::random();
    $_POST['RegistrationForm']['email'] = $user['email'];
    $_POST['Profile']['firstname'] = $user['first_name'];
    $_POST['Profile']['lastname'] = $user['last_name'];
    /*
     * array
'manual' => string 'phone' (length=5)
'profile' => string 'http://www.facebook.com/zhanat.iskakov.9' (length=40)
'uid' => string '100003048267907' (length=15)
'last_name' => string 'Iskakov' (length=7)
'verified_email' => string '1' (length=1)
'nickname' => string 'zhanat.iskakov.9' (length=16)
'email' => string 'iskakov_zhanat@mail.ru' (length=22)
'first_name' => string 'Zhanat' (length=6)
'identity' => string 'http://www.facebook.com/zhanat.iskakov.9' (length=40)
'network' => string 'facebook' (length=8)
'phone' => string '+1(111)111-1111' (length=15)
'photo' => string 'http://graph.facebook.com/100003048267907/picture?type=square' (length=61)
     */
    Helper::dbg($user);
}
?>
<script src="//ulogin.ru/js/ulogin.js"></script>
<div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name,email,nickname,phone,photo;providers=vkontakte,facebook,twitter,google,mailru,yandex,odnoklassniki;redirect_uri=http%3A%2F%2Fyii.shop%2F"></div>