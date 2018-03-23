<?php

class TitipanController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	public function accessRules()
	{
		return parent::getArrayAccessRules();
	}
	
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=So::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new So();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['So']))
		{
			$model = So::model()->find("so_cd='".$_POST['So']['so_cd']."'");
			$model->attributes = $_POST['So'];
			$model->save();
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
		$model = So::model()->find("so_cd='".$id."'");
		if(isset($_POST['So']))
		{
			$model->attributes = $_POST['So'];
			$model->save();
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		//Yii::app()->mail->transportOptions['username'] = 'budi';
		//echo Yii::app()->mail->transportOptions['username'];
		
		$model=new So('search');
		$model->unsetAttributes();  // clear any default values
		$model->total_titipan  = '>0';
		
		if(isset($_GET['So']))
		{
			$model->attributes=$_GET['So'];
			$model->validate(array('est_delivery_dt', 'create_dt', 'update_dt'));
		}	

		$this->render('index',array(
			'model'=>$model,
		));
	}

	

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='so-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionPreview()
	{
		$id = $_REQUEST['id'];
		$salesorder_h = So::model()->find("so_cd = '".$id."'");
		$salesorder_d = Sodetail::model()->with('vendor')->together()->findAll("so_cd = '".$id."'");
		$invoice = Soinvoice::model()->find("so_cd = '".$id."'");
$salesorder_h->is_print_titipan = 1;
		$salesorder_h->save(false);
		$this->renderPartial('_preview',array('header'=>$salesorder_h,'detail'=>$salesorder_d,'invoice'=>$invoice));
	}
	
	// Send email to BOD there notify a [new/updated] SO  need to be approved
	public function actionSendnotif($so_cd)
	{
		$message = new YiiMailMessage();
		
		$app_ip_public = "";
		
		$email 		   = DAO::querySql("SELECT * FROM tdpemployee WHERE employee_type = 'BOD'");
		$globalsetting = DAO::queryRowSql("SELECT * FROM tdpglobalsetting");
		$app_ip_public = $globalsetting['app_ip_public'];
		
		foreach($email as $emailBOD)
		{
			$addTo = $emailBOD['email'];
			
			$msg   = "You have 1 SO Notification From ".Yii::app()->user->name.", please kindly check : ";
			$msg  .= "<a href='http://".$app_ip_public."/office2/index.php?r=sales/so/update&id=".$so_cd."' target='_blank'>$so_cd</a>";
			
			$message = new YiiMailMessage;
			$message->subject = "[New/Updated] SO Notification $so_cd";
			$message->setBody($msg, 'text/html');
			$message->addTo($addTo);
			$message->from = Yii::app()->user->email;
			
			Yii::app()->mail->send($message);
		}
		
		Yii::app()->user->setFlash('success', "Notification Successfully Sent");
		$this->redirect(array('index'));
	}
}