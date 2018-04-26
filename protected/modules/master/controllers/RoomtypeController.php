<?php

class RoomtypeController extends Controller
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
	public function actionCreate($id)
	{
			$mProperty = Property::model()->findByPk($id);
      if($mProperty===null)
          throw new CHttpException(404,'The requested page does not exist.');

      $model=new Roomtype;
      $model->property_id = $mProperty->property_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roomtype']))
		{
			$model->attributes=$_POST['Roomtype'];
			$model->room_type_id = Pattern::generate("ROOM_TYPE_CODE");

			if($model->validate())
			{
			  #$transaction mulai transaksi
			  $transaction = Yii::app()->db->beginTransaction();
			  try
				{
					foreach (Basepriceroom::$publicTypePrice as $key => $PriceType)
					{
						$mSaveRoomPrice = new Basepriceroom(); #declare $mSaveRoomPrice menggunakan table Propertydesc
						$mSaveRoomPrice->attributes=$_POST['Basepriceroom'];
						$mSaveRoomPrice->room_type_id = $model->room_type_id;
						$mSaveRoomPrice->hours = $PriceType;
						$mSaveRoomPrice->price = 0;
						$mSaveRoomPrice->save(false); #save(false)--> save tidak validasi
					}
					Pattern::increase('ROOM_TYPE_CODE');
				  $model->save();

					//Yii::app()->end();
					$transaction->commit();
			    Yii::app()->user->setFlash('success', "Create Successfully");
			    $this->redirect(array('/partner/property/index'));
		  	}
		    catch(exception $e) {
		      $transaction->rollback();
		      throw new CHttpException(500, $e->getMessage());
		  	}
			}
		}

		$this->render('create',array(
			'model'=>$model,
            'mProperty'=>$mProperty
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
    $mProperty = Property::model()->findByPk($model->property_id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roomtype']))
		{
				$model->attributes=$_POST['Roomtype'];
				if($model->save()) {
					Yii::app()->user->setFlash('success', "Update Successfully");
					$this->redirect(array('/partner/property/index'));
				}
		}

		$this->render('update',array(
			'model'=>$model,
            'mProperty'=>$mProperty
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
			//$this->loadModelbaseprice($id)->delete(); #untuk delete Basepriceroom
			//$this->loadModelpriceflexible($id)->delete(); #untuk delete Basepriceroom
			//$this->loadModelroomphoto($id)->delete(); #untuk delete room type photo

			#bagian proses delete photo room type
			/*if($_GET['pid']!=NULL)
			{
				$pid=$_GET['pid'];
				$photoDel = DAO::executeSql("DELETE FROM tghroomphoto WHERE room_type_id = '".$id."' AND photo_id = '".$pid."'");
				$docPath = FileUpload::getFilePath($model->filename, FileUpload::ROOM_PHOTO_PATH);
				if(file_exists($docPath)) unlink($docPath);
			}
			else
			{
				// we only allow deletion via POST request
				$this->loadModel($id)->delete();
				Roomtype::model()->deleteAll('property_id = :pid', array(':pid'=>$id));
			}*/
			$BaseDel = DAO::executeSql("DELETE w
																	FROM `tghbasepriceroom` w
																	WHERE w.room_type_id='$id'"); #untuk delete bulk delete tghroompriceflexible
			$BulkDel = DAO::executeSql("DELETE w
																	FROM `tghroompriceflexible` w
																	WHERE w.room_type_id='$id'"); #untuk delete bulk delete tghroompriceflexible
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
		$model=new Roomtype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Roomtype']))
			$model->attributes=$_GET['Roomtype'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Roomtype the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roomtype::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelbaseprice($id)
	{
		$model=Basepriceroom::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function loadModelpriceflexible($id)
	{
		$model=Roompriceflexible::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelroomphoto($id)
	{
		$model=Roomphoto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Roomtype $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='roomtype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
