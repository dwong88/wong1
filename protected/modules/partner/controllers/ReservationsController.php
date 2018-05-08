<?php
#ini class tambahan untuk class ReservationsController
class Roomres  {} #untuk load room
class Children {} #class children or sub room
class Eventes  {} #untuk loadEvents
class Resulted {} #edit
class Resultsm {} #moveevent
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
	 #index untuk flexible
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
	 #index untuk regular dan 1 night
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

	#fungsi load room
	public function actionLoadroom($id=0)
	{
			$id=$_GET['pid'];
			if($id==0){
				$room1 = DAO::queryAllSql("select r.room_id as id, r.`room_name` as name,rt.room_type_id as parent_id,rt.room_type_name as parent_name,rt.`room_type_room_size` as capacity from tghroom as r
				inner join `tghroomtype` as rt on r.`room_type_id` = rt.`room_type_id`
				inner join `tghproperty` as pt on rt.`property_id` = pt.`property_id`
				GROUP BY rt.room_type_id
				ORDER BY rt.room_type_id");
			}
			else{
				$room1 = DAO::queryAllSql("select r.room_id as id, r.`room_name` as name,rt.room_type_id as parent_id,rt.room_type_name as parent_name,rt.`room_type_room_size` as capacity from tghroom as r
				inner join `tghroomtype` as rt on r.`room_type_id` = rt.`room_type_id`
				inner join `tghproperty` as pt on rt.`property_id` = pt.`property_id`
				WHERE rt.`property_id` = '".$id."'
				GROUP BY rt.room_type_id
				ORDER BY rt.room_type_id");
			}

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
				$roomsp =DAO::queryAllSql("SELECT room_name as name, room_id as id FROM tghroom WHERE room_type_id = '".$room['parent_id']."' ORDER BY is_unallocated");

				#looping child
				foreach($roomsp as $value) {
					$children = new Children;

					$roomsun =DAO::queryAllSql("SELECT start_date , end_date FROM tghroomclosure WHERE room_id = '".$value['id']."';");
					$children->name = $value['name'];
					foreach($roomsun as $value1) {
						$unavailable = new stdClass;
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
	#fungsi load events
	public function actionLoadevents($start,$end)
	{

		 	$events = array();
			/*$result = DAO::queryAllSql("select rev.reservations_id as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid,rm.room_id as room_id,rm.room_name from tghreservations as rev
			inner join `tghroom` as rm on rm.room_id = rev.room_id
			WHERE NOT (rev.end_date <= '".$start."') OR (rev.start_date >=' ".$end."')");*/

			#query events
			$result = DAO::queryAllSql("select rev.reservations_id as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid,rm.room_id as room_id,rm.room_name from tghreservations as rev
			inner join `tghroom` as rm on rm.room_id = rev.room_id
			WHERE NOT (rev.end_date <= '".$start."') OR (rev.start_date >='".$end."')
			union
			select c.id,c.name,c.start,c.end,'','',c.room_id,room_name from(
			select cl.cl_id as id,cl.room_id,cl.start_date as start,cl.end_date as end, cl.status_cl as name,rm.room_name as room_name from tghroomclosure as cl
						inner join `tghroom` as rm on rm.room_id = cl.room_id
						WHERE NOT (end_date <= '".$start."') OR (start_date >='".$end."')
			) as c");
			foreach($result as $row) {
			    $e = new Eventes();
			    $e->id = $row['id'];
			    $e->text = $row['name'];
			    $e->start = $row['start'];
			    $e->end = $row['end'];
			    $e->resource = $row['room_id'];
					$e->unavailable=1;

					$e->tag = new stdClass();
					$e->tag->unavailable=1;
			    // additional properties
			    $e->status = $row['status'];
			    $e->paid = $row['paid'];
			    $events[] = $e;

			}

			header('Content-Type: application/json');
			echo json_encode($events);
	}

	#fungsi load events
	public function actionLoadclosure($start,$end)
	{

		 	$events = array();
			/*$result = DAO::queryAllSql("select cl_id as id, room_id, status as name , start_date as start, end_date as end from tghroomclosure
			WHERE NOT (end_date <= '".$start."') OR (start_date >=' ".$end."')");*/

			#query roomclosure
			$result = DAO::queryAllSql("select rev.reservations_id as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid,rm.room_id as room_id,rm.room_name from tghreservations as rev
			inner join `tghroom` as rm on rm.room_id = rev.room_id
			WHERE NOT (rev.end_date <= '".$start."') OR (rev.start_date >='".$end."')
			union
			select c.id,c.name,c.start,c.end,'','',c.room_id,room_name from(
			select cl.cl_id as id,cl.room_id,cl.start_date as start,cl.end_date as end, cl.status_cl as name,rm.room_name as room_name from tghroomclosure as cl
						inner join `tghroom` as rm on rm.room_id = cl.room_id
						WHERE NOT (end_date <= '".$start."') OR (start_date >='".$end."')
			) as c");

			foreach($result as $row) {
			    $e = new Eventes();
			    $e->id = $row['id'];
					$e->text = $row['name'];
			    $e->start = $row['start'];
			    $e->end = $row['end'];
			    $e->resource = $row['room_id'];
					//$e->unavailable=1;

					//$e->tag = new stdClass();
					//$e->tag->unavailable=1;
			    // additional properties
			    $events[] = $e;

			}

			header('Content-Type: application/json');
			echo json_encode($events);
	}
	#fungsi load landing pages iframe
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

	#fungsi untuk create event/reservation
	public function actionLoadcreateevent($start,$end,$resource,$idtype)
	{
			$this->layout = '//layouts/iframe1';
		 	//Yii::app()->end();
			$model=new Reservations;
			$model->room_id=$resource;
			$model->start_date=$start;
			$model->end_date=$end;

			if(isset($_POST['Reservations']))
			{
				$model->attributes=$_POST['Reservations'];
				$model->status="New";
				$model->paid="";
				$idtype=$_POST['Reservations']['idtype'];

				if($idtype!=0){
					$model->start_date=str_replace(' ', '',$_POST['Reservations']['start_date']);
					$model->end_date=str_replace(' ', '',$_POST['Reservations']['end_date']);
				}
				else {
					$start_time=substr($_POST['Reservations']['start_date'],10,8).":00";
					$end_time=substr($_POST['Reservations']['end_date'],10,8).":00";
					$model->start_date=substr($_POST['Reservations']['start_date'],0,10);
					$model->end_date= substr($_POST['Reservations']['end_date'],0,10);
				}


				if($model->validate()) {

				  #$transaction mulai transaksi
				  $transaction = Yii::app()->db->beginTransaction();
				  try{

						if($idtype==0){
							$model->start_date = $model->start_date." ".$start_time;
							$model->end_date =$model->end_date." ".$end_time;
						}
						if($model->end_date<$model->start_date){
							$response = new Resultec();
							$response->result = 'OK';
							$response->message = 'Create Failed';

							header('Content-Type: application/json');
							echo json_encode($response);
							Yii::app()->end();
						}
						else{
							$model->save();
							#jika tidak ada error transaksi proses di commit
							$transaction->commit();
							//Yii::app()->user->setFlash('success', "Create Successfully");

							$response = new Resultec();
							$response->result = 'OK';
							$response->message = 'Create successful';

							header('Content-Type: application/json');
							echo json_encode($response);
							Yii::app()->end();
						}
					}
					catch(exception $e) {
				      $transaction->rollback();
				      throw new CHttpException(500, $e->getMessage());
				  }
				}
			}
			$this->render('_form',array(
				'model'=>$model,
				'idtype'=>$idtype,
			));
	}

	#fungsi untuk edit event/reservation
	public function actionLoadeditevent($id,$idtype)
	{
			$this->layout = '//layouts/iframe1';
			$model=$this->loadModel($id);
			$model->reservations_id=$id;
			if($idtype!=0){

				$tes1=$model->start_date;
				$newDate1 = date("d/m/Y", strtotime($tes1));
				$tes2=$model->end_date;
				$newDate2 = date("d/m/Y", strtotime($tes2));
				$model->start_date=$newDate1;
				$model->end_date=$newDate2;
			}
			else {
				$tes1=$model->start_date;
				$newDate1 = date("d/m/Y H:i:s", strtotime($tes1));
				$tes2=$model->end_date;
				$newDate2 = date("d/m/Y H:i:s", strtotime($tes2));
				$model->start_date=$newDate1;
				$model->end_date=$newDate2;
			}

			if(isset($_POST['Reservations']))
			{
				$model->attributes=$_POST['Reservations'];
				//print_r($_POST);
				if($_POST['roomtype_id']!=null){
						//$model->room_type_id = $_POST['room_type_id'];
						$model->room_id = $_POST['room_id'];
				}
				else {
					{
						$model->room_id = $_POST['roomtype_id'];
					}
				}


				$idtype=$_POST['Reservations']['idtype'];

				if($idtype!=0){
					$model->start_date=str_replace(' ', '',$_POST['Reservations']['start_date']);
					$model->end_date=str_replace(' ', '',$_POST['Reservations']['end_date']);
				}
				else {
					$start_time=substr($_POST['Reservations']['start_date'],10,8);
					$end_time=substr($_POST['Reservations']['end_date'],10,8);
					//echo $start_time;
					$diff = strtotime($end_time)-strtotime($start_time);
					$hh = floor($diff/60/60);
					//echo $diff;
					if($hh>12)
					{
						echo "overtime";
					}
					if($hh<0)
					{
						//echo "error";
						$response = new Resultec();
						$response->result = 'OK';
						$response->message = 'Create Failed';

						header('Content-Type: application/json');
						echo json_encode($response);
						Yii::app()->end();
					}
					$model->start_date=substr($_POST['Reservations']['start_date'],0,10);
					$model->end_date= substr($_POST['Reservations']['end_date'],0,10);
					Yii::app()->end();
				}
				if($model->validate())
				{
				  #$transaction mulai transaksi
				  $transaction = Yii::app()->db->beginTransaction();
				  try{
							//print_r($_POST);
							$model->save();
							#jika tidak ada error transaksi proses di commit
							$transaction->commit();
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
			$this->render('_form',array(
				'model'=>$model,
				'idtype'=>$idtype,
			));
	}

	#fungsi untuk move events
	public function actionLoadmovedevent($id,$start,$end,$resource)
	{
			$hasil = DAO::queryAllSql("select rev.reservations_id as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid from tghreservations as rev
			WHERE NOT ((rev.end_date <= '".$start."') OR (rev.start_date >='".$end."')) AND rev.reservations_id<>$id AND rev.room_id=$resource");
			#count
			$overlaps=count($hasil);

			if ($overlaps) {
			    $response = new Resultsm();
			    $response->result = 'Error';
			    $response->message = 'This reservation overlaps with an existing reservation.';

			    header('Content-Type: application/json');
			    echo json_encode($response);
			    exit;
			}

			$hasil1 = DAO::executeSql("UPDATE tghreservations SET start_date='".$start."',end_date='".$end."',room_id=$resource where reservations_id=$id");
			$response = new Resultsm();
			$response->result = 'OK';
			$response->message = 'Update successful';

			header('Content-Type: application/json');
			echo json_encode($response);
	}

	#module resize events
	public function actionLoadresizedevent($start,$end,$id)
	{
		$hasil = DAO::executeSql("UPDATE tghreservations SET start_date='".$start."',end_date='".$end."' where reservations_id=$id");

		$response = new Resulter();
		$response->result = 'OK';
		$response->message = 'Update successful';

		header('Content-Type: application/json');
		echo json_encode($response);
	}

	#module resize closure
	public function actionLoadresizedclosure($start,$end,$id)
	{
		$hasil = DAO::executeSql("UPDATE tghroomclosure SET start_date='".$start."',end_date='".$end."' where cl_id='".$id."';");

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
