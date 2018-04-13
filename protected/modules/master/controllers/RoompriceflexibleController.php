<?php

class RoompriceflexibleController extends Controller
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
		$model=new Roompriceflexible;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		/*if(isset($_POST['Roompriceflexible']))
		{
			$model->attributes=$_POST['Roompriceflexible'];


				//print_r($_POST['Basepriceroom']);
				$mDescTac = new Roompriceflexible(); #declare $mDescTac menggunakan table Propertydesc
				$mDescTac->attributes=$_POST['Roompriceflexible'];
				foreach (Roompriceflexible::$publicTypePrice as $key => $PriceType) {
					$mDescTac = new Roompriceflexible(); #declare $mDescTac menggunakan table Propertydesc
					$mDescTac->attributes=$_POST['Roompriceflexible'];
					$mDescTac->room_type_id = $model->room_type_id;
					$mDescTac->hours = $PriceType;
					$mDescTac->price = '';
					//echo $mDescTac->price;
					//echo $mDescTac->price = $model->$PriceType;
					$mDescTac->save(false); #save(false)--> save tidak validasi
				}
				//$this->redirect(array('index'));
			}
			*/

		if(isset($_POST['Roompriceflexible']))
		{
			print_r($_POST);
			$model->attributes=$_POST['Roompriceflexible'];
			foreach (Roompriceflexible::$publicTypePrice as $key => $PriceType) {
				$mDescTac = new Roompriceflexible(); #declare $mDescTac menggunakan table Propertydesc
				$mDescTac->attributes=$_POST['Roompriceflexible'];
				$mDescTac->room_type_id = $model->room_type_id=$_POST['roomtype_id'];
				$mDescTac->hours = $PriceType;
				$mDescTac->price = $_POST['Roompriceflexible'][$PriceType];
				$tgl=$_POST['Roompriceflexible']['date'];
				$format = '%d/%m/%Y';
				$date = $tgl;
				$parsed = strptime($date , $format);

				if(is_array($parsed))
				{
				    $y = (int)$parsed['tm_year'] + 1900;

				    $m = (int)$parsed['tm_mon'] + 1;
				    $m = sprintf("%02d", $m);

				    $d = (int)$parsed['tm_mday'];
				    $d = sprintf("%02d", $d);

				    $iso_date = "$y-$m-$d";
				}

				$iso_date; //outputs 2012-05-25
				$date=date_create($iso_date);
				$mDescTac->date=date_format($date,"Y/m/d H:i:s");
				//echo $mDescTac->price = $model->$PriceType;
				$mDescTac->save(); #save(false)--> save tidak validasi
			}
			//$model->room_type_id=$_POST['Roompriceflexible']['roomtype_id'];
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roompriceflexible']))
		{
			$model->attributes=$_POST['Roompriceflexible'];
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
		$model=new Roompriceflexible('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Roompriceflexible']))
			$model->attributes=$_GET['Roompriceflexible'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Roompriceflexible the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roompriceflexible::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Roompriceflexible $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='roompriceflexible-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
