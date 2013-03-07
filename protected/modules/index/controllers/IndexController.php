<?php

// общие действия front'а
class IndexController extends Controller
{

    public function filters()
    {
        return array('rights');
    }

    // разрешенные действия
    public function allowedActions()
    {
        return 'index, error, social, pdf';
    }

    // главная стр-а сайта
    public function actionIndex()
    {
        /**/
        $items = $items2 = array();
        $products = Product::getAll();
        foreach ($products as $product) {
            if ($product['state'] == 'hit') {
                $items[] = $product;
            } elseif ($product['state'] == 'bestprice') {
                $items2[] = $product;
            }
        }
        $this->render('index', array('items' => $items, 'items2' => $items2, 'ci' => count($items), 'ck' => count($items2)));
    }

    // обраб-к ошибок
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                if ($error['code'] == 404) {
                    $this->render('404', $error);
                } else {
                    $this->render('error', $error);
                }
            }
        }
    }

    /*
     *  регистрация через соц-е сети
     *  http://ulogin.ru
     */
    public function actionSocial()
    {
        if (Yii::app()->user->id) {
            $this->redirect('/');
        } elseif (isset($_POST['token'])) {
            $model = new SocialForm;
            $profile = new Profile;
            $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
            $user = json_decode($s, true);
            $_POST['RegistrationForm']['username'] = $user['nickname'];
            $_POST['RegistrationForm']['password'] = $_POST['RegistrationForm']['verifyPassword'] = Helper::random();
            $_POST['RegistrationForm']['email'] = $user['email'];
            $_POST['Profile']['firstname'] = $user['first_name'];
            $_POST['Profile']['lastname'] = $user['last_name'];
            $model->attributes = $_POST['RegistrationForm'];
            $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
            if ($model->validate() && $profile->validate()) {
                $soucePassword = $model->password;
                $model->activkey = UserModule::encrypting(microtime() . $model->password);
                $model->password = UserModule::encrypting($model->password);
                $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                $model->superuser = 0;
                $model->status = 1;

                if ($model->save()) {
                    $profile->user_id = $model->id;
                    $profile->save();
                    UserModule::sendMail($model->email, UserModule::t("Тема - Вы зарегистрированы с {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t('текст'));

                    $identity = new UserIdentity($model->username, $soucePassword);
                    $identity->authenticate();
                    Yii::app()->user->login($identity, 0);

                    Yii::app()->user->setFlash('registration', UserModule::t('Спасибо за регистрацию'));
                    $this->refresh();
                }
            }
        }
        $this->render('social');
    }

    public function actionPdf()
    {
        define('_MPDF_PATH', 'mpdf/');
        include("mpdf/mpdf.php");
        $mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10);
        $mpdf->default_lineheight_correction = 1.2;
        $css = file_get_contents('http://yii.shop/mpdf/test.css');
        $html = file_get_contents('http://yii.shop/mpdf/test.html');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('mpdf/scores/filename.pdf', 'F');
        exit;
        $itemsCount = '3 наименовани' . Helper::ruEnding(3, 'е', 'я', 'й');
        $this->render('pdf', array(
            'summa' => Helper::mb_ucfirst(Helper::num2str(123456)),
            'itemsCount' => $itemsCount,
            'price' => 123456,
            'score' => 'id_счета',
            'customer' => 'Покупатель',
            'date' => Helper::ruDate(date('Y-m-d')),
        ));
    }

}