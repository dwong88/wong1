<?php

class SoviewController extends Controller
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
	
	public function actionView($id)
	{
		$model = So::model()->findByPk($id);;
		$model->so_cd = $id;
		
		$modelDetail = new Sodetail();
		$modelDetail->so_cd = $id;
		
		$modelVwrr = new Vwrr();
		$modelVwrr->so_cd  = $id;
		$modelVwrr->status = '>0';
		
		$this->render('view',array(
			'model'		 => $model,
			'mDetail'	 => $modelDetail,
			'modelVwrr'  => $modelVwrr
		));
		
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		//Yii::app()->mail->transportOptions['username'] = 'budi';
		//echo Yii::app()->mail->transportOptions['username'];
		
		$model=new So('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['So']))
		{
			$model->attributes=$_GET['So'];
			$model->validate(array('est_delivery_dt', 'create_dt', 'update_dt'));
		}	

		$this->render('index',array(
			'model'=>$model,
		));
	}
}
