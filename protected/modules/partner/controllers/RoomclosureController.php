<?php
class Resultec {} #declare new class untuk return dari fungsi create
class Resulted {} #edit
class RoomclosureController extends Controller
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
	//public function actionCreate()
	public function actionCreate()
	{
		//$this->layout = '//layouts/iframe1';
		$model=new Roomclosure;

		if(isset($_POST['Roomclosure']))
		{
			$model->attributes=$_POST['Roomclosure'];
			//$model->room_id=$_POST['Roomclosure']['room_id'];
			$model->cl_id = Pattern::generate("CLOSURE_CODE");
			//echo $model->start_date;
			//echo $model->end_date;
			/*$tgl1=$_POST['Roomclosure']['start_date'];
			$format = '%d/%m/%Y';
			$date1 = $tgl1;
			$parsed1 = strptime($date1 , $format);
			$tgl2=$_POST['Roomclosure']['end_date'];
			$format = '%d/%m/%Y';
			$date2 = $tgl2;
			$parsed2 = strptime($date2 , $format);

			#parsing format start_date
			if(is_array($parsed1))
			{
					$y = (int)$parsed1['tm_year'] + 1900;

					$m = (int)$parsed1['tm_mon'] + 1;
					$m = sprintf("%02d", $m);

					$d = (int)$parsed1['tm_mday'];
					$d = sprintf("%02d", $d);

					$iso_date1 = "$y-$m-$d";
			}

			#parsing format end_date
			if(is_array($parsed2))
			{
					$y = (int)$parsed2['tm_year'] + 1900;

					$m = (int)$parsed2['tm_mon'] + 1;
					$m = sprintf("%02d", $m);

					$d = (int)$parsed2['tm_mday'];
					$d = sprintf("%02d", $d);

					$iso_date2 = "$y-$m-$d";
			}

			$model->start_date=$iso_date1;
			$model->end_date=$iso_date2; */
			if($model->validate()) {
			  #$transaction mulai transaksi
			  $transaction = Yii::app()->db->beginTransaction();
			  try{
					Pattern::increase('CLOSURE_CODE');
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	//public function actionCreate untuk di calendar()
	public function actionCreatecal($start,$end,$resource)
	{
		$this->layout = '//layouts/iframe1';
		$model=new Roomclosure;
		$model->room_id=$resource;
		$model->start_date=$start;
		$model->end_date=$end;
		$model->cl_id = Pattern::generate("CLOSURE_CODE");
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roomclosure']))
		{
			$model->attributes=$_POST['Roomclosure'];
			$model->room_id=$resource;
			if($model->validate()) {
			  #$transaction mulai transaksi
			  $transaction = Yii::app()->db->beginTransaction();
			  try{
					Pattern::increase('CLOSURE_CODE');
			    $model->save();
			    #jika tidak ada error transaksi proses di commit
			    $transaction->commit();
					#response ke json
					$response = new Resultec();
					$response->result = 'OK';
					$response->message = 'Create successful';

					Yii::app()->end();
			  }
			    catch(exception $e) {
			      $transaction->rollback();
			      throw new CHttpException(500, $e->getMessage());
			  }
			}
		}

		$this->render('_formcal',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($start,$end,$resource)
	{
		$model=$this->loadModel($resource);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roomclosure']))
		{
			$model->attributes=$_POST['Roomclosure'];
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

	public function actionUpdatecal($id)
	{
		$this->layout = '//layouts/iframe1';
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roomclosure']))
		{
			$model->attributes=$_POST['Roomclosure'];
			if($model->validate()) {
				#$transaction mulai transaksi
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$model->save();
					#jika tidak ada error transaksi proses di commit
					$transaction->commit();
					//Yii::app()->user->setFlash('success', "Update Successfully");
					//$this->redirect(array('index'));
					$response = new Resulted();
					$response->result = 'OK';
					$response->message = 'Update successful';

					header('Content-Type: application/json');
					echo json_encode($response);
					Yii::app()->end();
				}
					catch(exception $e) {
						$transaction->rollback();
						throw new CHttpException(500, $e->getMessage());
				}
			}
		}

		$this->render('_formupcal',array(
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
		$model=new Roomclosure('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Roomclosure']))
			$model->attributes=$_GET['Roomclosure'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Roomclosure the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roomclosure::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Roomclosure $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='roomclosure-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
