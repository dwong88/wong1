<?php

class RoomtypebedController extends Controller
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
		$model=new Roomtypebed;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$mBed = new Roomtypebed('search');
		$mBed->unsetAttributes();  // clear any default values
		$mBed->room_type_id = $id;

		//Yii::app()->end();
		if(isset($_POST['Roomtypebed']))
		{
			$model->attributes=$_POST['Roomtypebed'];
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
			'model'=>$model,'mBed'=>$mBed,
		));
	}


//    public function actionUpdate($id)
//	{
//		$model=new Roomtypebed;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['Roomtypebed']))
//		{
//			$model->attributes=$_POST['Roomtypebed'];
//			if($model->save()) {
//				Yii::app()->user->setFlash('success', "Create Successfully");
//				$this->redirect(array('index'));
//			}
//		}
//
//		$this->render('create',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	public function actionUpdate($id, $bedid=0)
	{
	    $mRoomType = Roomtype::model()->findByPk($id);
        if($mRoomType===null)
            throw new CHttpException(404,'The requested page does not exist.');

        if($bedid==0) {
            $model = new Roomtypebed();
            $model->room_type_id = $id;
        } else {
            $model = $this->loadModel($bedid);
        }

				#query property
				$qProperty = DAO::queryRowSql('SELECT property_name,room_type_name
		                                    FROM `tghroomtype`
		                                    JOIN tghproperty on tghroomtype.property_id=tghproperty.property_id
		                                    WHERE room_type_id=:rid'
		                                    , array(':rid'=>$id));

				#index buat room type bed
        $mBed = new Roomtypebed('search');
        $mBed->unsetAttributes();  // clear any default values
        $mBed->room_type_id = $id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        //print_r($_POST);


        if (isset($_POST['Roomtypebed'])) {
            $model->attributes = $_POST['Roomtypebed'];
						if($model->validate()) {
						  #$transaction mulai transaksi
						  $transaction = Yii::app()->db->beginTransaction();
						  try{
						    $model->save();
						    #jika tidak ada error transaksi proses di commit
						    $transaction->commit();
						    Yii::app()->user->setFlash('success', "Create Successfully");
						      $this->redirect(array('update','id'=>$model->room_type_id));
						  }
						    catch(exception $e) {
						      $transaction->rollback();
						      throw new CHttpException(500, $e->getMessage());
						  }
						}

        }

		$this->render('update',array(
			'mBed'=>$mBed,
			'qProperty'=>$qProperty,
      'mRoomType'=>$mRoomType,
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
		$model=new Roomtypebed('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Roomtypebed']))
			$model->attributes=$_GET['Roomtypebed'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Roomtypebed the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roomtypebed::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Roomtypebed $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='roomtypebed-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
