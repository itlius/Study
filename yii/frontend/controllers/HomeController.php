<?php
namespace frontend\controllers;
use yii\web\Controller;
use Yii;
use yii\web\Session;
use yii\web\CookieCollection;
use frontend\models\Home;
class HomeController extends Controller
{
	public $enableCsrfValidation = false;
    public $layout=false;
    //首页展示
    public function actionHome(){
        return $this->render('index');
}
    //上传图片进行处理
    public function actionUpload(){
        return 1 ;
    }
    //连接数据库进行展示
    public function actionFind(){
        return $this->redire('find');
    }
    //头像展示
    public function actionInde(){
        return $this->render('inde');
    }
    public function actionQuan(){
        return $this->render('quan');
    }
    public function actionFan(){
        return $this->render('fan');
    }
}

