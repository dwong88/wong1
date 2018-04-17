<?php

class RoomtypefeaturesController extends Controller
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
	public function actionCreate($id=0)
	{
		$model=new Roomtypefeatures;
        $model->room_type_id = $id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

    $mSelf = DAO::queryAllSql("SELECT room_features_id FROM `tghroomtypefeatures`WHERE room_type_id = '".$id."'");
		//$mSavef->prop_features_id = $temp_f;
		#print_r($mSelf);
		$countselect=count($mSelf);
		for($c=0;$c<$countselect;$c++)
		{
			$checkedFeat[$c] = $mSelf[$c]['room_features_id'];
		}
        $model->room_features_id = $checkedFeat;

		$qProperty = DAO::queryRowSql('SELECT property_name,room_type_name
                                    FROM `tghroomtype`
                                    JOIN tghproperty on tghroomtype.property_id=tghproperty.property_id
                                    WHERE room_type_id=:rid'
                                    , array(':rid'=>$id));

		//echo $qProperty['room_type_name']

		if(isset($_POST['Roomtypefeatures']))
		{
            $model->attributes = $_POST['Roomtypefeatures'];
            //$model->room_features_id = array('room_features_id');
            $loop=$model->room_features_id;
            $id= $model->room_type_id;

            $mDel = DAO::executeSql("DELETE FROM tghroomtypefeatures WHERE room_type_id = '".$id."'");
            foreach ($loop as $key => $value) {
                $msaverf= new Roomtypefeatures;
                $msaverf->room_features_id = $value;
                $msaverf->room_type_id = $id;
                //Yii::app()->end();
                $msaverf->save(false);

            }
            Yii::app()->user->setFlash('success', "Create Successfully");
            $this->redirect(array('/partner/property/index'));
        }




		$this->render('create',array(
			'model'=>$model,
            'qProperty'=>$qProperty,
		));
	}

    /*public function actionCreate()
    {
        $model=new Roomtypefeatures;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Roomtypefeatures']))
        {
            $model->attributes=$_POST['Roomtypefeatures'];
            if($model->save()) {
                Yii::app()->user->setFlash('success', "Create Successfully");
                $this->redirect(array('index'));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$roomfeatures = explode(', ', $model->room_features_id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roomtypefeatures']))
		{
			$roomfeatures = implode(",", $_POST['room_features_id']);
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
		$model=new Roomtypefeatures('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Roomtypefeatures']))
			$model->attributes=$_GET['Roomtypefeatures'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Roomtypefeatures the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roomtypefeatures::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Roomtypefeatures $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='roomtypefeatures-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
