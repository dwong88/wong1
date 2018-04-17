<?php

class RunningdateController extends Controller
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
		$model=new Runningdate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Runningdate']))
		{
			$model->attributes=$_POST['Runningdate'];
			$tgl1=$_POST['Runningdate']['start_date'];
			$format = '%d/%m/%Y';
			$date1 = $tgl1;
			$parsed1 = strptime($date1 , $format);
			$tgl2=$_POST['Runningdate']['end_date'];
			$format = '%d/%m/%Y';
			$date2 = $tgl2;
			$parsed2 = strptime($date2 , $format);

			if(is_array($parsed1))
			{
					$y = (int)$parsed1['tm_year'] + 1900;

					$m = (int)$parsed1['tm_mon'] + 1;
					$m = sprintf("%02d", $m);

					$d = (int)$parsed1['tm_mday'];
					$d = sprintf("%02d", $d);

					$iso_date1 = "$y-$m-$d";
			}


			if(is_array($parsed2))
			{
					$y = (int)$parsed2['tm_year'] + 1900;

					$m = (int)$parsed2['tm_mon'] + 1;
					$m = sprintf("%02d", $m);

					$d = (int)$parsed2['tm_mday'];
					$d = sprintf("%02d", $d);

					$iso_date2 = "$y-$m-$d";
			}

			$iso_date1; //outputs 2012-05-25
			$iso_date2; //outputs 2012-05-25
			//$date=date_create($iso_date1);
			//echo date_format($date,"Y/m/d H:i:s");

			$begin = new DateTime($iso_date1);
			$end = new DateTime($iso_date2);
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			$transaction = Yii::app()->db->beginTransaction();
			try{
					foreach ($period as $dt) {
							//echo $dt->format("l Y-m-d\n")."<br>";
							$mSaveDate = new Runningdate(); #declare $mSaveDate menggunakan table Propertydesc
							$mSaveDate->date_id = $dt->format("N");
							$mSaveDate->runningdate = $dt->format("Y-m-d");
							$mSaveDate->save(); #save(false)--> save tidak validasi
							//$this->redirect(array('index'));
					}
					$transaction->commit();
			    Yii::app()->user->setFlash('success', "Create Successfully");
			    $this->redirect(array('index'));
			  }
			    catch(exception $e) {
			      $transaction->rollback();
			      throw new CHttpException(500, $e->getMessage());
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Runningdate']))
		{
			$model->attributes=$_POST['Runningdate'];
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
		$model=new Runningdate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Runningdate']))
			$model->attributes=$_GET['Runningdate'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Runningdate the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Runningdate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Runningdate $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='runningdate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
