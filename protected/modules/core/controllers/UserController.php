<?php

class UserController extends Controller
{	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new User();
		$employee = new Employee();
		$model->scenario = 'insertadm';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']) && isset($_POST['Employee']))
		{
			$flag=0;
			$model->attributes	  = $_POST['User'];
			$employee->attributes = $_POST['Employee'];
			
			$model->password=Encryption::encrypt($model->newpass);
			$employee->employee_cd = Pattern::generate("EMPLOYEE_CODE");
			$employee->user_id = 0;
			
			if($model->validate())
				$flag++;
			if($employee->validate())
				$flag++;
			
			if($flag == 2)
			{	
				Pattern::increase('EMPLOYEE_CODE');
				$model->save(false);
				$employee->user_id = $model->user_id;
				$employee->save(false);
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}
			else
			{
				$employee->attributes = $_POST['Employee'];
			}
		}
		
		$model->is_active = 1; // Default value for is_active
		$this->render('create',array(
			'model'=>$model,
			'employee'=>$employee,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = new User();
		$model = User::model()->find('user_id='.$id);
		$employee = new Employee();
		$employee = Employee::model()->find('user_id='.$id);
		$model->scenario = 'updateadm';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']) && isset($_POST['Employee']))
		{
			$model->attributes=$_POST['User'];
			$employee->attributes = $_POST['Employee'];
			
			$model->validate();
			$employee->validate();
			if(!$model->hasErrors() && !$employee->hasErrors()) {
				if($model->save(false)) {
					$employee->user_id = $model->user_id;
					if($employee->save(false)) {
						Yii::app()->user->setFlash('success', "Create Successfully");
						$this->redirect(array('index'));
					}
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'employee'=>$employee,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->layout = '//layouts/column1';
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionChangepass($id)
	{
		$model = $this->loadModel($id);
		$model->scenario = 'changepassadm';
		$employee = new Employee();
		$employee = Employee::model()->find('user_id='.$id);
		
		if(isset($_POST['User'])){
			$model->attributes = $_POST['User'];
			$model->password=Encryption::encrypt($model->newpass);
			
			if($model->save())
			{
				Yii::app()->user->setFlash('success', "Password Changed Successfully");
				$this->redirect(array('index'));
			}//end if
		}//end if
		
		
		$this->render('changepass',array(
			'model'=>$model,
			'employee'=>$employee,
		));
	}
}















