<?php

class SiteController extends Controller
{
	public $layout='//layouts/column2';
	
	public function actionHome()
	{
		$this->layout = '//layouts/column1';
		$this->render('home');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('/site/login'));
	}
	
	public function actionChangepassword()
	{
		$model=User::model()->findByPk(Yii::app()->user->id);
		$model->scenario = 'changepassword';
	
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if(Encryption::encrypt($model->oldpass) != $model->password) {
				$model->addError('oldpass','Wrong Password!');
			} else {
				$model->setAttribute('password', Encryption::encrypt($model->newpass));
				if($model->save()) {
					$model->updateSuccessfull = 1;
				}
			}
		}
	
		$model->unsetAttributes(array('oldpass'));
		$model->unsetAttributes(array('newpass'));
		$model->unsetAttributes(array('reenterpass'));
		$this->render('changepass',array(
			'model'=>$model,
		));
	}
	
	/**
	* This is the action to handle external exceptions in popup window
	 */
	public function actionErrorpopup()
	{
		$this->layout = '//layouts/popup1';
		$this->_popuptitle = 'Error';
		$this->actionError();
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array_merge(array(
				array('deny',
						'actions'=>array('login'),
						'users'=>array('@'),
				),
				array('allow',
						'actions'=>array('changepassword','home','error'),
						'users'=>array('@'),
				),
				array('allow',
						'actions' => array('login','logout'),
						'users' => array('*'),
				),
		),parent::accessRules());
	}
}

?>