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

		if(isset($_POST['Roompriceflexible']))
		{
			//print_r($_POST);
			$model->attributes=$_POST['Roompriceflexible'];
			foreach (Roompriceflexible::$publicTypePrice as $key => $PriceType) {
				$mFlexPrice = new Roompriceflexible(); #declare $mFlexPrice menggunakan table Propertydesc
				$mFlexPrice->attributes=$_POST['Roompriceflexible'];
				$mFlexPrice->room_type_id = $model->room_type_id=$_POST['roomtype_id'];
				$mFlexPrice->hours = $PriceType;
				$mFlexPrice->price = $_POST['Roompriceflexible'][$PriceType];
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
				$mFlexPrice->date=date_format($date,"Y/m/d H:i:s");
				//echo $mFlexPrice->price = $model->$PriceType;
				$mFlexPrice->save(); #save(false)--> save tidak validasi
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdatebulk($id)
	{
		//$model=$this->loadModel($id);
		$model=new Roompriceflexible;
		if($model===null)
		{
				echo "isi";
		}
		else{
			$model->attributes=$_POST['Roompriceflexible'];
			if(isset($_POST['Roompriceflexible']))
			{
				$model->attributes=$_POST['Roompriceflexible'];
				$tgl1=$_POST['Roompriceflexible']['start_date'];
				$format = '%d/%m/%Y';
				$date1 = $tgl1;
				$parsed1 = strptime($date1 , $format);
				$tgl2=$_POST['Roompriceflexible']['end_date'];
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

				$iso_date1; //outputs 2012-05-25
				$iso_date2; //outputs 2012-05-25

				#fungsi random_id
				$rand=(rand(1,10));

				#fungsi count select checkbox days
				$countdays=count($_POST['Roompriceflexible']['date_id']);
				$mdate="";
				for($dat=0;$dat<$countdays;$dat++)
				{
					$mdate.=$_POST['Roompriceflexible']['date_id'][$dat].",";
				}
				$tampung= rtrim($mdate,',');
				$room_type_ids=$_GET['id'];

				$BulkDel = DAO::executeSql("DELETE w
																		FROM `tghroompriceflexible` w
																		INNER JOIN tghrunningdate` e
																		  ON e.runningdate=w.date
																		WHERE w.room_type_id=$room_type_ids AND e.runningdate between '".$iso_date1."' and '".$iso_date2."' and e.date_id IN ($tampung)");
				$transaction = Yii::app()->db->beginTransaction();
			  try{
						#INSERT TEMPPRICEROOM
						foreach (Temproomprice::$publicTypePrice as $key => $PriceType)
						{
								$mFlexPrice = new Temproomprice(); #declare $mFlexPrice menggunakan table Propertydesc
								$mFlexPrice->attributes=$_POST['Roompriceflexible'];
								$mFlexPrice->random_id = $rand;
								$mFlexPrice->hours = $PriceType;
								$mFlexPrice->price = $_POST['Roompriceflexible'][$PriceType];

								//echo $mFlexPrice->price = $model->$PriceType;
								$mFlexPrice->save(); #save(false)--> save tidak validasi
						}
						#insert update bulks
						$updatebulks = DAO::executeSql("INSERT INTO `tghroompriceflexible` (room_type_id, date,hours, price)
						select $room_type_ids,tgl.runningdate,price.hours,price.price  FROM
						(select hours,price,random_id from `tghtemproomprice` where random_id='$rand') as price,
						(select runningdate from tghrunningdate where runningdate between '".$iso_date1."' and '".$iso_date2."' AND date_id IN ($tampung)) as tgl");

						$truntempprice=DAO::executeSql("DELETE FROM `tghtemproomprice` WHERE random_id='".$rand."';");
						$transaction->commit();
						Yii::app()->user->setFlash('success', "Create Successfully");
						$this->redirect(array('index'));
						//$this->redirect(array('../partner/property/index'));
					}
						catch(exception $e) {
				      $transaction->rollback();
				      throw new CHttpException(500, $e->getMessage());
				  }
				}
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$this->render('updatebulk',array(
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
		//$model=Roompriceflexible::model()->findByPk($id);
		$model=Roompriceflexible::model()->find('room_type_id=:pid', array(':pid'=>$id));
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
