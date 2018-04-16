<?php

class BasepriceroomController extends Controller
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
		$model=new Basepriceroom;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Basepriceroom']))
		{
			$model->attributes=$_POST['Basepriceroom'];

			if(isset($_POST['Basepriceroom']))
			{
				//print_r($_POST['Basepriceroom']);
				foreach (Basepriceroom::$publicTypePrice as $key => $PriceType) {
					$mSaveRoomPrice = new Basepriceroom(); #declare $mSaveRoomPrice menggunakan table Propertydesc
					$mSaveRoomPrice->attributes=$_POST['Basepriceroom'];
					$mSaveRoomPrice->room_type_id = $model->room_type_id;
					$mSaveRoomPrice->hours = $PriceType;
					$mSaveRoomPrice->price = "";

					//echo $mSaveRoomPrice->price = $model->$PriceType;
					$mSaveRoomPrice->save(); #save(false)--> save tidak validasi
				}
				//$this->redirect(array('index'));
			}
			/*if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}*/
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
		//$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$mRoomtype = Roomtype::model()->findByPk($id);
		$model= new Basepriceroom; #$modeldesc panggil model Propertydesc
		#Set descripsi Propertydesc
		foreach (Basepriceroom::$publicTypePrice as $key => $value) {
			//echo "string";
			 $model->$value = $this->loadModelprice($id, $value)->price;
		}
		#proses update descripsi
		if(isset($_POST['Basepriceroom']))
		{
			$model->attributes = $_POST['Basepriceroom'];
			foreach (Basepriceroom::$publicTypePrice as $key => $value)
			{
				$mSaveDesc = $this->loadModelprice($id, $value);
				$mSaveDesc->price = $model->$value;
				//echo ("UPDATE tghbasepriceroom SET price='".$_POST['Basepriceroom'][$value]."'  WHERE room_type_id = '".$id."' AND hours = '".$value."';");
				$mUp = DAO::executeSql("UPDATE tghbasepriceroom SET price='".$_POST['Basepriceroom'][$value]."'  WHERE room_type_id = '".$id."' AND hours = '".$value."' ");
				//Yii::app()->end();
				//$mSaveDesc->save(false);
			}
			//print_r($model);
				$this->redirect(array('property/index'));
		}

		$this->render('update',array(
			'model'=>$model,
			'mRoomtype'=>$mRoomtype,
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
		$model=new Basepriceroom('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Basepriceroom']))
			$model->attributes=$_GET['Basepriceroom'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Basepriceroom the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Basepriceroom::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelRoomtype($id)
	{
		$model=Roomtype::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	#load model untuk tabel property price
	public function loadModelprice($id,$type)
	{
		$model=Basepriceroom::model()->find('room_type_id=:pid AND hours = :ty', array(':pid'=>$id, ':ty'=>$type));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Basepriceroom $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='basepriceroom-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
