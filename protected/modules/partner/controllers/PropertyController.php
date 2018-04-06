<?php

class PropertyController extends Controller
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
			'model'=>$this->loadModel($id)
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Property; #formgeneral
		$modeldesc=new Propertydesc; #formPolicies
		$modelfeat=new Propertyfeatures; #gate features
		/* from form Policies*/
		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				foreach (Propertydesc::$publicTypeDesc as $descType) {
					foreach (Helper::$listLanguage as $lng=>$lngText) { #fungsi helper panggil list language
						$mDescTac = new Propertydesc();
						$mDescTac->property_id = $model->property_id;
						$mDescTac->lang = $lng;
						$mDescTac->type = $descType;
						$mDescTac->desc = "";
						$mDescTac->save(false); #save(false)--> save tidak validasi
					}
				}
				$modelfeat->property_id = $model->property_id;
				$modelfeat->prop_features_id = "";
				$modelfeat->save(false); #save(false)--> save tidak validasi
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCreaterenderphotos()
	{
		$model=new Propertyphoto;
			if (isset($_POST['simpan']))
			{
					$property_id=$_GET['id'];
					$sekarang=date("Y-m-d h:i:s");
					foreach ($_POST['nama_gambar'] as $i => $nama_gambar)
					{
						//fungsi foreach untuk mencari nilai dari input html name='nama_produk[]' kemudian nilai i sebagai key Nya
						$SQL="INSERT INTO tghpropertyphoto values(null,'$property_id','$nama_gambar','".$_POST['gambar'][$i]."','$sekarang','1','$sekarang','1')";
						//echo $SQL;
						$command= Yii::app()->db->createCommand($SQL);
						$n=$command->execute();
					}
					//$this->redirect(array('view','id'=>$produk_id));
					$this->redirect(array('index'));
			}
		//$this->redirect(array('/kategori_produk'));
	//}tutup
		$this->render('createphotos',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $lng = 'en')
	{
		$model=$this->loadModel($id);
		//$mToc=$this->loadModeldesc($id, 'en', 'toc');

		/* bagian prop desc toc Policies*/
		$modeldesc= new Propertydesc;
		$modeldesc->lang = $lng;
		if($_GET['lang']==NULL){
				$modeldesc->lang = $lng;
		}
		else {
				$modeldesc->lang = $_GET['lang'];
				$lng=$_GET['lang'];
		}
		foreach (Propertydesc::$publicTypeDesc as $key => $value) {
			$modeldesc->$value = $this->loadModeldesc($id, $lng, $value)->desc;
		}

		//print_r($_POST['Propertydesc']);
		if(isset($_POST['Propertydesc']))
		{
			$modeldesc->attributes = $_POST['Propertydesc'];
			foreach (Propertydesc::$publicTypeDesc as $key => $value) {
				$mSave = $this->loadModeldesc($id, $lng, $value);
				$mSave->desc = $modeldesc->$value;
				//print_r($mSave);
				//Yii::app()->end();
				$mSave->save();
			}

		}

		/*bagian features*/
		$modelfeat=new Propertyfeatures; #gate features
		$mFeat=new Mspropertyfeatures; #master prop features
		//print_r($_POST['propfeat']);
		//echo count($_POST['propfeat']);
		if(isset($_POST['propfeat']))
		{
				$loop=$_POST['propfeat'];
				$mDel = DAO::executeSql("DELETE FROM tghpropertyfeatures WHERE property_id = '".$id."'");
				foreach ($loop as $key => $value) {
					$mSavef = new Propertyfeatures;
					$mSavef->prop_features_id = $value;
					$mSavef->property_id = $id;
					$mSavef->save(false);
				}
		}
		$mSelf = DAO::queryAllSql("SELECT * FROM tghpropertyfeatures WHERE property_id = '".$id."'");
		//$mSavef->prop_features_id = $temp_f;
		#print_r($mSelf);
		$countselect=count($mSelf);
		for($c=0;$c<$countselect;$c++)
		{
			$checkedFeat[$c] = $mSelf[$c]['prop_features_id'];
		}
		//print_r($checkedFeat);
		//$modelfeat->property_id = $id;
		//$mSavef->save(false);
		//$mToc=$this->loadModeldesc($id, $lang, $toc);
		//$mPayment=$this->loadModeldesc($id, $lang, $payment);
		//$mCancel=$this->loadModeldesc($id, $lang, $cancel);
		//Yii::app()->end();
		/* bagian update foto*/
		$models = DAO::queryAllSql("SELECT * FROM tghpropertyphoto WHERE property_id = '".$id."'");
		/*bagian update property general */
		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
				//$this->redirect(array('index'));
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'mFeat'=>$mFeat,
			'checkedFeat'=>$checkedFeat,
			'models'=>$models,
			'modeldesc'=>$modeldesc,
		));
	}


	public function actionUpdatephotos($id)
	{
		$models = DAO::queryAllSql("SELECT * FROM tghpropertyphoto WHERE property_id = '".$id."'");

		$this->render('updatephotos',array(
			'models'=>$models,
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
		$model=new Property('search');
		$model->unsetAttributes();  // clear any default values
		$modelPol=new Propertydesc;
		if(isset($_GET['Property']))
			$model->attributes=$_GET['Property'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Property the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Property::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function loadModelFeat($id)
	{
		$model=Propertyfeatures::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldesc($id,$lang,$type)
	{
		$model=Propertydesc::model()->find('property_id=:pid AND lang = :lng AND type = :ty', array(':pid'=>$id, ':lng'=>$lang, ':ty'=>$type));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Property $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='property-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
