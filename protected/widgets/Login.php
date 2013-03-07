<?php

class Login extends CWidget
{

    public function run()
    {     
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                if ($model->validate()) {
                    $this->lastViset();
                    Yii::app()->getRequest()->redirect('/');
                }
            }
            $this->render('Login', array('model' => $model));
        } else {
            $this->render('Login');
        }
    }

    private function lastViset()
    {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

}
