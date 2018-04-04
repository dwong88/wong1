<?php

class PropertyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id)
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Property;
		$modeldesc=new Propertydesc;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'modeldesc'=>$modeldesc
		));
	}

	public function actionCreaterendergeneral()
	{
		$model=new Property;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}
		}

		$this->render('creategeneral',array(
			'model'=>$model,
		));
	}

	public function actionCreaterenderphotos()
	{
		$model=new Property;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}
		}

		$this->render('createphotos',array(
			'model'=>$model,
		));
	}

	public function actionCreaterenderfeatures()
	{
		$model=new Property;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}
		}

		$this->render('createfeatures',array(
			'model'=>$model,
		));
	}

	public function actionCreaterenderterms()
	{
		$modeldesc=new Propertydesc;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		print_r($_POST['Propertydesc']);
		$row = Yii::app()->db->createCommand()
                ->select('propertyid')
                ->from('tghproperty')
                ->order('propertyid DESC')
                ->queryRow();
    //echo $row['propertyid'];
		echo $_POST['Propertydesc']['desc'][1];
		/*if(isset($_POST['Propertydesc']))
		{
			$model->propertyid = $row['propertyid']+1;
			$model->type = 'test';
			$model->attributes=$_POST['Propertydesc'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}
		}*/

		$this->render('createterms',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'modeldesc'=>$modeldesc,
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
		$model=new Property('search');
		$model->unsetAttributes();  // clear any default values
		$modelPol=new Propertydesc;
		if(isset($_GET['Property']))
			$model->attributes=$_GET['Property'];

		$this->render('index',array(
			'model'=>$model,
			'modelPol'=>$modelPol,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Property the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Property::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Property $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='property-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
