<?php
class Roomtes{
}
class GlobalsettingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';



	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=$this->loadModel(1);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Globalsetting']))
		{
			$model->attributes=$_POST['Globalsetting'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


		public function actionLoadstates()
		{
			//echo "string1";

		   $data=State::model()->findAll('country_id=:country_id',array(':country_id'=>(int) $_POST['country_id']));

		   $data=CHtml::listData($data,'state_id','state_name');

		   echo "<option value=''>Select State</option>";
		   foreach($data as $value=>$state_name)
		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($state_name),true);

		}

		public function actionLoadcities()
		{
				//echo "string2";

		   $data=City::model()->findAll('state_id=:state_id',array(':state_id'=>(int) $_POST['state_id']));

		   $data=CHtml::listData($data,'city_id','city_name');

	 	 	//echo $form->dropDownList($data,'city_id', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name'),array('prompt'=>''));

		   echo "<option value=''>Select City</option>";
		   foreach($data as $value=>$city_name)
		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($city_name),true);
			 $this->renderPartial('_testing');
		}

		public function actionLoadroomtype()
		{
			//echo "string1";

		   $data=Roomtype::model()->findAll('property_id=:property_id',array(':property_id'=>(int) $_POST['property_id']));

		   $data=CHtml::listData($data,'room_type_id','room_type_name');

		   echo "<option value=''>Select Room Type</option>";
		   foreach($data as $value=>$room_type_name)
		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($room_type_name),true);

		}

		public function actionLoadroom()
		{
			//echo "string1";

		   $data=Room::model()->findAll('room_type_id=:room_type_id',array(':room_type_id'=>(int) $_POST['room_type_id']));
		   $data=CHtml::listData($data,'room_id','room_name');

		   echo "<option value=''>Select Room</option>";
		   foreach($data as $value=>$room_name)
		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($room_name),true);

		}

		public function actionLoadcreateevent()
		{
			 //Yii::app()->end();
				$start;

				/*$stmt = $db->prepare("select r.room_id as id, r.`room_name` as name,rt.room_type_id as parent_id,rt.room_type_name as parent_name,rt.`room_type_room_size` as capacity from tghroom as r
				inner join `tghroomtype` as rt on r.`room_type_id` = rt.`room_type_id`
				GROUP BY rt.room_type_id
				ORDER BY rt.room_type_id");
				$stmt->bindParam(':capacity', $_POST['capacity']);
				$stmt->execute();
				$rooms = $stmt->fetchAll();*/
				$room1 = DAO::queryAllSql("select r.room_id as id, r.`room_name` as name,rt.room_type_id as parent_id,rt.room_type_name as parent_name,rt.`room_type_room_size` as capacity from tghroom as r
				inner join `tghroomtype` as rt on r.`room_type_id` = rt.`room_type_id`
				GROUP BY rt.room_type_id
				ORDER BY rt.room_type_id");


				$result = array();
				$c=0;
				foreach($room1 as $room) {
				  $r = new Roomtes();
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
				    $children = new stdClass;
				    $children->name = $value['name'];
				    $children->id = $value['id'];
				    $r->children[] = $children;
				  }


				  $result[] = $r;

				}


				//initialize array
				$myArray = array();

				//set up the nested associative arrays using literal array notation
				$firstArray = array("id" => 1,"name" => 'room1', "data" => 45);
				$secondArray = array("id" => 3,"name" => 'room2', "data" => 54);

				//push items onto main array with bracket notation (this will result in numbered indexes)
				$myArray[] = $firstArray;
				$myArray[] = $secondArray;


				//convert to json
				//$json = json_encode($myArray);
				header('Content-Type: application/json');
				echo json_encode($myArray);
				//convert to json
				//$json = json_encode($myArray);
				//header('Content-Type: application/json');
				//echo json_encode($result);
		}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Globalsetting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Globalsetting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Globalsetting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='globalsetting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
