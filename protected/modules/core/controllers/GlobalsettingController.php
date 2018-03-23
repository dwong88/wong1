<?php

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
