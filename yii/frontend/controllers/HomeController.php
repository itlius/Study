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
    public function actionHome(){
        return $this->render('index');
    }
    public function actionFind(){
        
    }
}

