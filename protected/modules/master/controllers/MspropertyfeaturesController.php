<?php

class MspropertyfeaturesController extends Controller
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
		$model=new Mspropertyfeatures;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mspropertyfeatures']))
		{
			$model->attributes=$_POST['Mspropertyfeatures'];
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mspropertyfeatures']))
		{
			$model->attributes=$_POST['Mspropertyfeatures'];
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
		$model=new Mspropertyfeatures('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mspropertyfeatures']))
			$model->attributes=$_GET['Mspropertyfeatures'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Mspropertyfeatures the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Mspropertyfeatures::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Mspropertyfeatures $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mspropertyfeatures-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
