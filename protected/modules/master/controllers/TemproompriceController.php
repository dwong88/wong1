<?php

class TemproompriceController extends Controller
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
		$model=new Temproomprice;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Temproomprice']))
		{
			$rand=(rand(1,10));
			$model->attributes=$_POST['Temproomprice'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
					foreach (Temproomprice::$publicTypePrice as $key => $PriceType) {
						$mTemPrice = new Temproomprice(); #declare $mTemPrice menggunakan table Propertydesc
						$mTemPrice->attributes=$_POST['Temproomprice'];
						$mTemPrice->random_id = $rand;
						$mTemPrice->hours = $PriceType;
						$mTemPrice->price = $_POST['Temproomprice'][$PriceType];

						$mTemPrice->save(); #save(false)--> save tidak validasi
					}
					$transaction->commit();
			    Yii::app()->user->setFlash('success', "Create Successfully");
			    $this->redirect(array('index'));
			  }
			    catch(exception $e) {
			      $transaction->rollback();
			      throw new CHttpException(500, $e->getMessage());
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

		if(isset($_POST['Temproomprice']))
		{
			$model->attributes=$_POST['Temproomprice'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
				$this->redirect(array('index'));
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
		$model=new Temproomprice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Temproomprice']))
			$model->attributes=$_GET['Temproomprice'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Temproomprice the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Temproomprice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Temproomprice $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='temproomprice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
