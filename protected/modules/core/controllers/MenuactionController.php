<?php

class MenuactionController extends Controller
{
	public $layout='//layouts/column1';
	
	public function actionCreate($id)
	{
		$model = new Menuaction;
		$model->menu_id = $id;
		$this->performAjaxValidation($model);

		if(isset($_POST['Menuaction']))
		{
			$model->attributes 	  = $_POST['Menuaction'];
			if($model->save())
				Yii::app()->user->setFlash('success', "Create Successfully");
		}

		$this->renderPartial('_form',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);

		if(isset($_POST['Menuaction']))
		{
			$model->attributes=$_POST['Menuaction'];
			if($model->save())
				Yii::app()->user->setFlash('success', "Update Successfully");
		}

		$this->renderPartial('_form',array(
				'model'=>$model,
		));
	}

	
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

	public function actionIndex()
	{
		$model=new Menuaction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Menuaction']))
			$model->attributes=$_GET['Menuaction'];
			$this->renderPartial('_form',array(
				'model'=>$model,
			));
	}

	
	public function loadModel($id)
	{
		$model=Menuaction::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menuaction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
