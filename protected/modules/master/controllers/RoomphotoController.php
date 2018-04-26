<?php

class RoomphotoController extends Controller
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
	public function actionCreate($id)
	{
		$model=new Roomphoto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$modelphoto= new Roomphoto; #declare use model Roomphoto
		$modelphoto->room_type_id=$id;
		$modelphoto->roomphototype_id =$_POST['roomphoto']['roomphototype_id'];

		#proses upload file photo
		if(isset($_POST['Roomphoto']))
		{
				$modelphoto->attributes=$_POST['Roomphoto'];
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
						$modelphoto->setAttribute('filename', 'roomphoto_'.$modelphoto->photo_id.'.'.$modelphoto->doc->extensionName);
						$modelphoto->update(array('filename'));
						$fileNamephoto = FileUpload::getFilePath($modelphoto->filename, FileUpload::ROOM_PHOTO_PATH);
						$modelphoto->doc->saveAs($fileNamephoto);

						$fileNamephotocopy = FileUpload::getFilePath($modelphoto->filename, FileUpload::ROOM_PHOTO_THUMBS_PATH);
						copy($fileNamephoto,$fileNamephotocopy);
						/*ambil filenya*/
						//$name = getcwd() . '/images/products/thumbs/' . $model->image;

						#create thumbnail
						$name = FileUpload::getFilePath($modelphoto->filename, FileUpload::ROOM_PHOTO_THUMBS_PATH);
						/*panggil component image dengan param $image*/
						$image = Yii::app()->image->load($name);
						/*resize gambar/thumb gambar*/
						$image->resize(93, 100);
						/*simpan thumb image kembali gambar ke
						 *images/products/thumbs*/
						$image->save();

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

		$this->render('create',array(
			'model'=>$model,'modelphoto'=>$modelphoto,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Roomphoto']))
		{
			$model->attributes=$_POST['Roomphoto'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
				$this->redirect(array('index'));
			}
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
		$model=new Roomphoto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Roomphoto']))
			$model->attributes=$_GET['Roomphoto'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Roomphoto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Roomphoto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Roomphoto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='roomphoto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
