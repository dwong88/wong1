<?php

class CityController extends Controller
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
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new City;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['City']))
		{
			//echo $_POST['state_id'];
			$model->attributes=$_POST['City'];
			$model->state_id = $_POST['state_id'];
			if($model->validate()) {
			  #$transaction mulai transaksi
			  $transaction = Yii::app()->db->beginTransaction();
			  try{
			    $model->save();
			    #jika tidak ada error transaksi proses di commit
			    $transaction->commit();
			    Yii::app()->user->setFlash('success', "Create Successfully");
			    $this->redirect(array('index'));
			  }
			    catch(exception $e) {
			      $transaction->rollback();
			      throw new CHttpException(500, $e->getMessage());
			  }
			}
		}

		$this->render('create',array(
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

		$mCity = DAO::queryAllSql("SELECT state_id,city_id FROM tghcity WHERE city_id = '".$id."'");
		$mState = DAO::queryAllSql("SELECT state_id,state_name FROM tghstate WHERE state_id = '".$mCity[0]['state_id']."'");
		//print_r($mState);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['City']))
		{
			$model->attributes=$_POST['City'];
			$model->state_id = $_POST['state_id'];
			if($model->validate()) {
			  #$transaction mulai transaksi
			  $transaction = Yii::app()->db->beginTransaction();
			  try{
			    $model->save();
			    #jika tidak ada error transaksi proses di commit
			    $transaction->commit();
			    Yii::app()->user->setFlash('success', "Update Successfully");
			    $this->redirect(array('index'));
			  }
			    catch(exception $e) {
			      $transaction->rollback();
			      throw new CHttpException(500, $e->getMessage());
			  }
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'mState'=>$mState,
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
		$model=new City('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['City']))
			$model->attributes=$_GET['City'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return City the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=City::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param City $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='city-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
