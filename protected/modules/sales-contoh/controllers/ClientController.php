<?php

class ClientController extends Controller
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
		$model 		  = $this->loadModel($id);
		 
		$modelContact = new Clientcontactdetail;
		$modelContact->unsetAttributes();
		$modelContact->client_cd = $model->client_cd;
		
		$modelAddress = new Clientaddress;
		$modelAddress->unsetAttributes();
		$modelAddress->client_cd = $model->client_cd;
		
		$this->render('view',array(
			'model'=>$model,
			'modelContact'=>$modelContact,
			'modelAddress'=>$modelAddress
		));
	}
	public function actionCreateDetail($client_cd,$type)
	{
		if($type == 'address')
		{
			$modelAddress = new Clientaddress();
			$modelAddress->client_cd = $client_cd;
			
			if(isset($_POST['Clientaddress']))
			{
				$modelAddress->attributes = $_POST['Clientaddress'];
				$modelAddress->save();
					
			}//end if

			$this->renderPartial('_clientaddresspopup',array(
				'model'=>$modelAddress,
			));
		}
		else
		{
			$modelContact = new Clientcontactdetail;
			$modelContact->client_cd = $client_cd;
		
			if(isset($_POST['Clientcontactdetail']))
			{
				$modelContact->attributes = $_POST['Clientcontactdetail'];
				$modelContact->save();
				
			}//end if
		
			$this->renderPartial('_clientcontactpopup',array(
					'model'=>$modelContact,
			));
		}
	}//end public function
	
	
	public function actionUpdateDetail($id,$type)
	{
		if($type == 'address')
		{
			$modelAddress = Clientaddress::model()->findByPk($id);
		
			if(isset($_POST['Clientaddress']))
			{
				$modelAddress->attributes = $_POST['Clientaddress'];
				$modelAddress->save();
			}//end if
		
			$this->renderPartial('_clientaddresspopup',array(
					'model'=>$modelAddress,
			));
		}else{
			$modelContact = Clientcontactdetail::model()->findByPk($id);
			
			if(isset($_POST['Clientcontactdetail']))
			{
				$modelContact->attributes = $_POST['Clientcontactdetail'];
				$modelContact->save();
			}//end if
			
			$this->renderPartial('_clientcontactpopup',array(
					'model'=>$modelContact,
			));
		}
	}//end public function
	
	public function actionDeleteDetail($id,$type)
	{
		if($type == 'address'){
			$modelAddress = Clientaddress::model()->findByPk($id);
			$modelAddress->status = Status::STATUS_INACTIVE;
			$modelAddress->save(FALSE);
		}else{
			$modelContact = Clientcontactdetail::model()->findByPk($id);
			$modelContact->status = Status::STATUS_INACTIVE;
			$modelContact->save(FALSE);
		}
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Client();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			$model->client_cd = Pattern::generate("CLIENT_CD");
			if($model->save())
			{
				Pattern::increase("CLIENT_CD");
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('update','id'=>$model->client_cd));
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
		$model		  = $this->loadModel($id);
		
		$modelContact = new Clientcontactdetail;
		$modelContact->unsetAttributes();
		$modelContact->client_cd = $model->client_cd;
		
		$modelAddress = new Clientaddress;
		$modelAddress->unsetAttributes();
		$modelAddress->client_cd = $model->client_cd;
		
		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
				$this->redirect(array('view','id'=>$model->client_cd));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'modelContact'=>$modelContact,
			'modelAddress'=>$modelAddress
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
			$modelClient = $this->loadModel($id);			
			$modelClient->delete();

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
		$model=new Client('search');
		$model->unsetAttributes(); 
		
		
		if(isset($_GET['Client']))
			$model->attributes=$_GET['Client'];

		$this->render('index',array(
			'model'=>$model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
