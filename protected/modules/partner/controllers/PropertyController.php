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
		$modelfeat=new Propertyfeatures; #relation table features
		/* Create untuk form general dan Policies*/
		if(isset($_POST['Property']))
		{
			#set attribute untuk property
			$model->attributes=$_POST['Property'];
			$model->state_id = $_POST['state_id'];
			$model->city_id = $_POST['city_id'];
			#proses save property
			$model->available_cleaning_start =$_POST['Property']['start_hours'].":".$_POST['Property']['start_minutes'];
			$model->available_cleaning_end =$_POST['Property']['end_hours'].":".$_POST['Property']['end_minutes'];
			//Yii::app()->end();
			if($model->save()) {
				#looping tipe policies ex:toc,payment,cancel
				foreach (Propertydesc::$publicTypeDesc as $descType) {
					#looping tipe languange
					foreach (Helper::$listLanguage as $lng=>$lngText) { #fungsi helper panggil list language
						$mDescTac = new Propertydesc(); #declare $mDescTac menggunakan table Propertydesc
						$mDescTac->property_id = $model->property_id;
						$mDescTac->lang = $lng;
						$mDescTac->type = $descType;
						$mDescTac->desc = "";
						$mDescTac->save(false); #save(false)--> save tidak validasi
					}
				}

				#proces property features
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

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $lng = 'en')
	{
		$model=$this->loadModel($id); #panggil fungsi loadmodel property

		#explode
		$str1 = $model->available_cleaning_start;
		//print_r (explode(":",$str1));
		$model->start_hours = $str1[0];
		$model->start_minutes = $str1[2];
		$str2 = $model->available_cleaning_start;
		//print_r (explode(":",$str2));
		$model->end_hours = $str2[0];
		$model->end_minutes = $str2[2];

		#state and city_id
		$mStatec = DAO::queryAllSql("SELECT st.state_name,st.state_id,ct.city_id,ct.city_name,p.property_id FROM `tghproperty` as p,`tghstate` as st,`tghcity` as ct WHERE  p.state_id=st.state_id AND p.city_id=ct.city_id AND p.property_id = '".$id."'");

		$modelphoto= new Propertyphoto; #declare use model propertyphoto
		$modelphoto->property_id=$id;
		$modelphoto->propertyphototype_id =$_POST['Propertyphoto']['propertyphototype_id'];
		#proses upload file photo
		if(isset($_POST['Propertyphoto']))
		{
				$modelphoto->attributes=$_POST['Propertyphoto'];
				#fungsi upload file yii
				$modelphoto->doc = CUploadedFile::getInstance($modelphoto, 'doc');
				if($modelphoto->doc !== null) {
					$modelphoto->setAttribute('filename', $modelphoto->doc->name);
				} else {
					echo 'Tidak ada file yg di upload';
				}
				#fungsi validasi proses
				if($modelphoto->validate()) {
					#$transaction mulai transaksi
					$transaction = Yii::app()->db->beginTransaction();
					try{
						$modelphoto->save(false);
						$modelphoto->setAttribute('filename', 'propertyphoto_'.$modelphoto->photo_id.'.'.$modelphoto->doc->extensionName);
						$modelphoto->update(array('filename'));
						$fileNamephoto = FileUpload::getFilePath($modelphoto->filename, FileUpload::PROPERTY_PHOTO_PATH);
						$modelphoto->doc->saveAs($fileNamephoto);
						#jika tidak ada error transaksi proses di commit
						$transaction->commit();
						Yii::app()->user->setFlash('success', "Photo Uploaded Successfully");
					}
						catch(exception $e) {
							$transaction->rollback();
							throw new CHttpException(500, $e->getMessage());
					}
				}
		}
		/* bagian prop desc toc Policies*/
		$modeldesc= new Propertydesc; #$modeldesc panggil model Propertydesc
		$modeldesc->lang = $lng;
		if($_GET['lang']==NULL)
		{
				$modeldesc->lang = $lng;
		}
		else
		{
				$modeldesc->lang = $_GET['lang'];
				$lng=$_GET['lang'];
		}
		#Set descripsi Propertydesc
		foreach (Propertydesc::$publicTypeDesc as $key => $value) {
			$modeldesc->$value = $this->loadModeldesc($id, $lng, $value)->desc;
		}
		#proses update descripsi
		if(isset($_POST['Propertydesc']))
		{
			$modeldesc->attributes = $_POST['Propertydesc'];
			foreach (Propertydesc::$publicTypeDesc as $key => $value)
			{
				$mSaveDesc = $this->loadModeldesc($id, $lng, $value);
				$mSaveDesc->desc = $modeldesc->$value;
				//Yii::app()->end();
				$mSaveDesc->save();
			}
		}

		/*bagian features*/
		$modelfeat=new Propertyfeatures; #gate features
		$mFeat=new Mspropertyfeatures; #master prop features

		if(isset($_POST['propfeat']))
		{
				$loop=$_POST['propfeat'];
				$mDel = DAO::executeSql("DELETE FROM tghpropertyfeatures WHERE property_id = '".$id."'");
				foreach ($loop as $key => $value) {
					$mSavefeatures = new Propertyfeatures;
					$mSavefeatures->prop_features_id = $value;
					$mSavefeatures->property_id = $id;
					$mSavefeatures->save(false);
				}
		}
		#hasil $mSelf masing multidimensi array
		$mSelf = DAO::queryAllSql("SELECT property_id,prop_features_id FROM tghpropertyfeatures WHERE property_id = '".$id."'");
		$countselect = count($mSelf);
		#fungsi convert ke single array
		for($c=0;$c<$countselect;$c++)
		{
			$checkedFeat[$c] = $mSelf[$c]['prop_features_id'];
		}

		//Yii::app()->end();

		/*bagian update property general */
		if(isset($_POST['Property']))
		{
			$model->attributes=$_POST['Property'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
				$this->redirect(array('index'));
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'mFeat'=>$mFeat,
			'mStatec'=>$mStatec,
			'checkedFeat'=>$checkedFeat,
			'modelphoto'=>$modelphoto,
			'modeldesc'=>$modeldesc,
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
				#bagian proses delete photo
				if($_GET['pid']!=NULL)
				{
					$pid=$_GET['pid'];
					$photoDel = DAO::executeSql("DELETE FROM tghpropertyphoto WHERE property_id = '".$id."' AND photo_id = '".$pid."'");
					$docPath = FileUpload::getFilePath($model->filename, FileUpload::PROPERTY_PHOTO_PATH);
					if(file_exists($docPath)) unlink($docPath);
				}
				else
				{
					// we only allow deletion via POST request
					$this->loadModel($id)->delete();
					Roomtype::model()->deleteAll('property_id = :pid', array(':pid'=>$id));
				}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all modelphoto.
	 */
	public function actionIndex()
	{
		$model=new Property('search');
		$model->unsetAttributes();  // clear any default values

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

	#load model untuk tabel property
	public function loadModel($id)
	{
		$model=Property::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	#load model untuk tabel property features
	public function loadModelFeat($id)
	{
		$model=Propertyfeatures::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	#load model untuk tabel property photo
	public function loadModelPhoto($id)
	{
		$model=Propertyphoto::model()->find('property_id=:pid', array(':pid'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	#load model untuk tabel property policies
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
