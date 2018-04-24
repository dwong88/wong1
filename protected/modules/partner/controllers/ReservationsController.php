<?php
class Roomres{
}
class Children{
}
class Eventes {}
class Resulted {} #edit
class Resultsm {}
class Resulter {} #resize
class Resultec {} #create
class ReservationsController extends Controller
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
	public function actionCreate($start,$end,$resource)
	{
		$model=new Reservations;
		$model->room_id=$resource;
		$model->start_date=$start;
		$model->end_date=$end;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Reservations']))
		{
			$model->attributes=$_POST['Reservations'];
			$model->status="new";
			$model->paid="";
			if($model->save()) {
				//Yii::app()->user->setFlash('success', "Create Successfully");

				$response = new Resultec();
				$response->result = 'OK';
				$response->message = 'Create successful';

				header('Content-Type: application/json');
				echo json_encode($response);
				Yii::app()->end();
			}
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Reservations']))
		{
			$model->attributes=$_POST['Reservations'];
			if($model->save()) {
				$response = new Resulted();
				$response->result = 'OK';
				$response->message = 'Update successful';

				header('Content-Type: application/json');
				echo json_encode($response);
			}
		}
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
		$model=new Reservations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reservations']))
			$model->attributes=$_GET['Reservations'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex1()
	{
		$model=new Reservations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reservations']))
			$model->attributes=$_GET['Reservations'];

		$this->render('index1',array(
			'model'=>$model,
		));
	}
	/**
	 * Lists all models.
	 */
	public function actionIndexall()
	{
		$model=new Reservations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reservations']))
			$model->attributes=$_GET['Reservations'];

		$this->render('indexall',array(
			'model'=>$model,
		));
	}

	public function actionLoadroom($capacity)
	{
			$room1 = DAO::queryAllSql("select r.room_id as id, r.`room_name` as name,rt.room_type_id as parent_id,rt.room_type_name as parent_name,rt.`room_type_room_size` as capacity from tghroom as r
			inner join `tghroomtype` as rt on r.`room_type_id` = rt.`room_type_id`
			WHERE rt.room_type_room_size = ".$capacity." OR ".$capacity." = '0'
			GROUP BY rt.room_type_id
			ORDER BY rt.room_type_id");


			$result = array();
			$c=0;
			foreach($room1 as $room) {
				$r = new Roomres();
				$r->id = $room['parent_id'];
				$r->name = $room['parent_name'];
				$r->capacity = $room['capacity'];
				//$r->status = $room['status'];
				$c=$c+1;
				if($c==1){
					$r->expanded = true;
				}
				else{
					$r->expanded = false;
				}
				$r->children = array();
				$roomsp =DAO::queryAllSql("SELECT room_name as name, room_id as id FROM tghroom WHERE room_type_id = ".$room['parent_id']." ORDER BY name");
				foreach($roomsp as $value) {
					$children = new Children;
					$unavailable = new stdClass;
					$roomsun =DAO::queryAllSql("SELECT start_date , end_date FROM tghroomclosure WHERE room_id = ".$value['id'].";");
					$children->name = $value['name'];
					foreach($roomsun as $value1) {
						$unavailable->start = $value1['start_date'];
			      $unavailable->end = $value1['end_date'];
						$children->unavailable[]=$unavailable;
					}
					$children->id = $value['id'];
					$r->children[] = $children;
				}
				$result[] = $r;

			}

			//convert to json
			header('Content-Type: application/json');
			echo json_encode($result);
	}

	public function actionLoadevents($start,$end)
	{
		 //Yii::app()->end();
		 	$events = array();
			$result = DAO::queryAllSql("select rev.reservations_id as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid,rm.room_id as room_id,rm.room_name from tghreservations as rev
			inner join `tghroom` as rm on rm.room_id = rev.room_id
			WHERE NOT (rev.end_date <= '".$start."') OR (rev.start_date >=' ".$end."')");

			foreach($result as $row) {
			    $e = new Eventes();
			    $e->id = $row['id'];
			    $e->text = $row['name'];
			    $e->start = $row['start'];
			    $e->end = $row['end'];
			    $e->resource = $row['room_id'];

			    // additional properties
			    $e->status = $row['status'];
			    $e->paid = $row['paid'];
			    $events[] = $e;

			    /*
			        int paid = Convert.ToInt32(e.DataItem["ReservationPaid"]);
			        string paidColor = "#aaaaaa";

			        e.Areas.Add(new Area().Bottom(10).Right(4).Html("<div style='color:" + paidColor + "; font-size: 8pt;'>Paid: " + paid + "%</div>").Visibility(AreaVisibility.Visible));
			        e.Areas.Add(new Area().Left(4).Bottom(8).Right(4).Height(2).Html("<div style='background-color:" + paidColor + "; height: 100%; width:" + paid + "%'></div>").Visibility(AreaVisibility.Visible));
			     * */
			}

			header('Content-Type: application/json');
			echo json_encode($events);
	}

	public function actionLoadpages($start,$end,$resource,$idtype)
	{
			$this->layout = '//layouts/iframe1';
		 //Yii::app()->end();
			$model=new Reservations;
			$model->room_id=$resource;
			$model->start_date=$start;
			$model->end_date=$end;
			$model->type=$idtype;

			$this->render('_formland',array(
				'model'=>$model,
			));
	}

	public function actionLoadcreateevent($start,$end,$resource,$idtype)
	{
			$this->layout = '//layouts/iframe1';
		 //Yii::app()->end();
			$model=new Reservations;
			$model->room_id=$resource;
			$model->start_date=$start;
			$model->end_date=$end;
			//convert to json
			//header('Content-Type: application/json');
			//echo json_encode($result);

			if(isset($_POST['Reservations']))
			{
				$model->attributes=$_POST['Reservations'];
				$model->status="new";
				$model->paid="";
				if($model->save()) {
					//Yii::app()->user->setFlash('success', "Create Successfully");

					$response = new Resultec();
					$response->result = 'OK';
					$response->message = 'Create successful';

					header('Content-Type: application/json');
					echo json_encode($response);
					Yii::app()->end();
				}
			}
			$this->render('_form',array(
				'model'=>$model,
				'idtype'=>$idtype,
			));
	}

	public function actionLoadeditevent($id,$idtype)
	{
			$this->layout = '//layouts/iframe1';
		 //Yii::app()->end();
			$model=$this->loadModel($id);
			$model->reservations_id=$id;

			//convert to json
			//header('Content-Type: application/json');
			//echo json_encode($result);
			$this->render('_form',array(
				'model'=>$model,
				'idtype'=>$idtype,
			));
	}

	public function actionLoadmovedevent($id,$start,$end,$resource)
	{
			//$this->layout = '//layouts/iframe1';
		 	//Yii::app()->end();


			/*$hasil = DAO::queryAllSql("select rev.reservations_id as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid,rm.room_id as room_id,rm.room_name from tghreservations as rev
			inner join `tghroom` as rm on rm.room_id = rev.room_id
			WHERE NOT (rev.end_date <= '".$start."') OR (rev.start_date >='".$end."') AND rev.reservations_id<>$id AND rm.room_id=$resource");
			$overlaps=count($hasil);*/
			$hasil = DAO::queryAllSql("select rev.reservations_id as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid from tghreservations as rev
			WHERE NOT ((rev.end_date <= '".$start."') OR (rev.start_date >='".$end."')) AND rev.reservations_id<>$id AND rev.room_id=$resource");
			$overlaps=count($hasil);
			if ($overlaps) {
			    $response = new Resultsm();
			    $response->result = 'Error';
			    $response->message = 'This reservation overlaps with an existing reservation.';

			    header('Content-Type: application/json');
			    echo json_encode($response);
			    exit;
			}


			/*$stmt = $db->prepare("UPDATE reservations SET start = :start, end = :end, room_id = :resource WHERE id = :id");
			$stmt->bindParam(':id', $_POST['id']);
			$stmt->bindParam(':start', $_POST['newStart']);
			$stmt->bindParam(':end', $_POST['newEnd']);
			$stmt->bindParam(':resource', $_POST['newResource']);
			$stmt->execute();*/

			$hasil1 = DAO::executeSql("UPDATE tghreservations SET start_date='".$start."',end_date='".$end."',room_id=$resource where reservations_id=$id");
			$response = new Resultsm();
			$response->result = 'OK';
			$response->message = 'Update successful';

			header('Content-Type: application/json');
			echo json_encode($response);
	}

	#module resize
	public function actionLoadresizedevent($start,$end,$id)
	{

	/*$stmt = $db->prepare("UPDATE reservations SET start = :start, end = :end WHERE id = :id");
	$stmt->bindParam(':id', $_POST['id']);
	$stmt->bindParam(':start', $_POST['newStart']);
	$stmt->bindParam(':end', $_POST['newEnd']);
	$stmt->execute();*/

	$hasil = DAO::executeSql("UPDATE tghreservations SET start_date='".$start."',end_date='".$end."' where reservations_id=$id");

	$response = new Resulter();
	$response->result = 'OK';
	$response->message = 'Update successful';

	header('Content-Type: application/json');
	echo json_encode($response);
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Reservations the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Reservations::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Reservations $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reservations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
