<?php

class RoomController extends Controller
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
		$model=new Room;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Room']))
		{
			$model->attributes=$_POST['Room'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
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
	public function actionUpdate($id,$roomid=0)
	{
		$modelroom= new Roomtype;
		$modelroom=$this->loadModelroomtype($id);


		if($roomid==0) {
				$model=new Room;
				$model->room_type_id = $id;
				$pesan="Create Successfully";
				//Yii::app()->end();
		} else {
			//echo "string";
				$pesan="Update Successfully";
				$model = $this->loadModel($roomid);
				//$modelroom=$this->loadModelroomtype($id);
		}

		$mRoom = new Room('search');
		$mRoom->unsetAttributes();  // clear any default values
		$mRoom->room_type_id = $id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$qProperty = DAO::queryRowSql('SELECT property_name,room_type_name
                                    FROM `tghroomtype`
                                    JOIN tghproperty on tghroomtype.property_id=tghproperty.property_id
                                    WHERE room_type_id=:rid'
                                    , array(':rid'=>$id));


		if(isset($_POST['Room']))
		{
			$model->attributes=$_POST['Room'];
			//print_r($model);
			//Yii::app()->end();
			if($model->save()) {
				Yii::app()->user->setFlash('success', $pesan);
				//$this->redirect(array('index'));
				$this->redirect(array('update','id'=>$model->room_type_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'mRoom'=>$mRoom,
			'qProperty'=>$qProperty,
			'modelroom'=>$modelroom,
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
		$model=new Room('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Room']))
			$model->attributes=$_GET['Room'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Room the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Room::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelroomtype($id)
	{
		$model=Roomtype::model()->find('room_type_id=:pid', array(':pid'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Room $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='room-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
