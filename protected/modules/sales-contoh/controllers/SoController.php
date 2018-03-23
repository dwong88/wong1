<?php

class SoController extends Controller
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
	
	public function actionAjxClientContact()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$client_cd = $_POST['client_cd'];
			
			$list = Clientcontactdetail::model()->findAll(array(
			    'select'	=>'*',
			    'condition' =>'client_cd = "'.$client_cd.'" AND status = '.Status::STATUS_ACTIVE,
			));
			
			foreach($list as $object)
			{
				echo CHtml::tag('option', array('value'=>$object->contact_id), $object->contact_name." - ".$object->position,true);
			}//end foreach
		}//end if request postrequest
		else 
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}//end else
	}//end function ajxclientcontact
	
	public function actionAjxClientAddress()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$client_cd = $_POST['client_cd'];
			
			$list = Clientaddress::model()->findAll(array(
			    'select'	=>'*',
			    'condition' =>'client_cd = "'.$client_cd.'" AND status = '.Status::STATUS_ACTIVE,
			));
			
			foreach($list as $object)
			{
				echo CHtml::tag('option', array('value'=>$object->address_id), $object->short_desc,true);
			}//end foreach
		}//end if request postrequest
		else 
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}//end else
	}//end function ajxclientcontact
	
	public function actionAjxCmbType()
	{
		$i=0;
		$client_cd = $_POST['client_cd'];
		$list = Project::model()->findAll(array(
		    'select'	=>'*',
		    'condition' =>'client_cd = "'.$client_cd.'" AND is_closed = 0',
		));
		echo CHtml::tag('option');
		
		if(isset($_POST['so_cd']))
		{
			$result = DAO::queryRowSql("SELECT * FROM tdpso WHERE so_cd = '".$_POST['so_cd']."'");
			$is_closed = DAO::queryRowSql("SELECT * FROM tdpproject WHERE project_name='".$result['project_name']."'");
			if($is_closed['is_closed'] != 0)
				echo CHtml::tag('option', array('value'=>$result['project_name']), $result['project_name'],true);
		}
		
		foreach($list as $object)
		{
				echo CHtml::tag('option', array('value'=>$object->project_name), $object->project_name,true);
			$i++;
		}
	}
	
	public function actionAjxSales()
	{
		$client_cd = $_POST['client_cd'];
		
		$client = DAO::queryRowSql("SELECT employee_cd FROM tdpclient WHERE client_cd = '".$client_cd."'");
		
		$list = Employee::model()->findAll();
		
		foreach($list as $object)
			if($object->employee_cd == $client['employee_cd'])
				echo CHtml::tag('option', array('value'=>$object->employee_cd, 'selected'=>'selected'), $object->employee_name,true);
			else
				echo CHtml::tag('option', array('value'=>$object->employee_cd), $object->employee_name,true);
	}
	
	public function actionAjxTop()
	{
		$client_cd = $_POST['client_cd'];
		$list = Client::model()->findAll(array(
		    'select'	=>'*',
		    'condition' =>'client_cd = "'.$client_cd.'"',
		));
		foreach($list as $object)
			echo $object->top;
	}
	
	public function actionView($id)
	{
		$model = So::model()->findByPk($id);;
		$model->so_cd = $id;
		
		$modelDetail = new Sodetail();
		$modelDetail->so_cd = $id;
		
		$this->render('view',array(
			'model'		 => $model,
			'mDetail'=> $modelDetail
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new So;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['So']))
		{
			$model->attributes=$_POST['So'];
			$model->status = Status::SO_STATUS_VOID;
			$model->purchase_status = Status::DEPEDENCY_STATUS_NOTYET;
			$model->delivery_status = Status::DEPEDENCY_STATUS_NOTYET;
			$model->invoice_status = Status::DEPEDENCY_STATUS_NOTYET;
			$model->payment_status = Status::DEPEDENCY_STATUS_NOTYET;
			$model->subtotal_cost = 0;
			$model->subtotal_sell = 0;
			
			if(!empty($_POST['So']['titipan_currency']))
			{
				$qKurs = Vwkurs::model()->find('kurs_from=:krs', array(':krs'=>$model->titipan_currency));
				$kurs = ($qKurs === null? 1 : $qKurs->kurs_tengah);
				$model->titipan_kurs = $kurs;
			}
			
			$taxkurs = DAO::queryRowSql("SELECT * FROM vwtaxkurs WHERE currency_cd = '$model->sell_currency'");
			$model->tax_kurs = $taxkurs['kurs_amount'];
			
			$qKurs = Vwkurs::model()->find('kurs_from=:krs', array(':krs'=>$model->sell_currency));
			$kurs = ($qKurs === null? 1 : $qKurs->kurs_tengah);
			$model->sell_kurs = $kurs;
			
			if($model->is_tax == Status::IS_STATUS_YES) $model->setAttribute('so_cd',Pattern::generate('SO_PPN'));
			else $model->setAttribute('so_cd',Pattern::generate('SO_NON'));
			
			$model->setAttribute('status', 1); // New
			
			//WT: initialize object CUploadedFile. Nanti digunain pada saat validasi pada model. CFileValidator.
			$model->client_po_clientfile = CUploadedFile::getInstance($model, "client_po_clientfile");
			if($model->client_po_clientfile !== null) 
				$model->client_po_serverfile = str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $model->so_cd).'.'.$model->client_po_clientfile->extensionName;
			
// 			$temp=CUploadedFile::getInstance($model,'client_po_file');
// 			if(!empty($temp))
// 			{
// 				$type=$temp->type;
// 				$type=substr("{$type}",strpos($type,'/')+1,strlen($type)-1);
// 				//$model->client_po_file=$model->client_po_no.'.'.$type;
// 				$namafile= str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $model->so_cd);
// 				$model->setAttribute('client_po_file', $namafile.'.'.$type);
// 			}
// 			else {
// 				$model->setAttribute('client_po_file',null);
// 			}
			
			if($model->save())
			{
				if($model->is_tax == Status::IS_STATUS_YES) Pattern::increase('SO_PPN');
				else Pattern::increase('SO_NON');
				
// 				if(!empty($temp))
// 				{
// 					$temp->saveAs(Yii::app()->basePath.'/../upload/client_po/'.$model->client_po_file);
// 					$model->save(false);
// 				}

				//WT: Save file baru.
				if($model->client_po_clientfile instanceof CUploadedFile)
					$model->client_po_clientfile->saveAs(FileUpload::getFilePath($model->client_po_serverfile, FileUpload::CLIENT_PO_PATH));
				
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('update','id'=>$model->so_cd));
			}
			else
			{
				$model->top = $_POST['So']['top'];
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
		$model=So::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		$model->setAttribute('so_status_temp', $model->status);
		$mDetail = new Sodetail('search');
		$mDetail->unsetAttributes();
		$mDetail->setAttribute('so_cd', $model->so_cd);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		if(isset($_POST['So']))
		{
			$oldClientFile=$model->client_po_clientfile;
			$oldServerFile=$model->client_po_serverfile;
			
			$model->attributes=$_POST['So'];
			if(!empty($_POST['So']['titipan_currency']))
			{
				$kurs = DAO::queryRowSql("SELECT * FROM tdpkurs WHERE kurs_from = '".$model->titipan_currency."' order by create_dt desc");
				$model->titipan_kurs = $kurs['kurs_tengah'];
			}
			$qKurs = Vwkurs::model()->find('kurs_from=:krs', array(':krs'=>$model->sell_currency));
			$kurs = ($qKurs === null? 1 : $qKurs->kurs_tengah);
			$model->sell_kurs = $kurs;
			
			$taxkurs = DAO::queryRowSql("SELECT * FROM vwtaxkurs WHERE currency_cd = '$model->sell_currency'");
			$model->tax_kurs = $taxkurs['kurs_amount'];
			
			if($model->status == 1 && $_POST['So']['so_status_temp'] == 2) //new & save and approve
			{
				// Pas di approve.
				// Lakukan pengecheckan authorisasi yang berhak untuk approve.
				if(Yii::app()->user->employee_type == 'BOD')
				{
					
					$model->setAttribute('approve_by', Yii::app()->user->id);
					$model->setAttribute('approve_dt', Yii::app()->datetime->getDateTimeNow());
					$model->setAttribute('status', Status::SO_STATUS_APPROVED);//status 2
					
					$model->client_po_clientfile = CUploadedFile::getInstance($model, "client_po_clientfile");
					if(isset($model->client_po_clientfile)) 
					{
						$model->client_po_serverfile = str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $model->so_cd).'.'.$model->client_po_clientfile->extensionName;
						//$model->so_file_name = str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $model->so_cd).'.'.$model->client_po_clientfile->extensionName;
						//$model->so_file_name = $model->client_po_clientfile;
					}
					else
					{
						//if($oldClientFile != '') $model->client_po_clientfile = $oldClientFile;
					}
					
					if($model->validate())
					{
						if(!empty($model->client_po_clientfile))
						{
							//WT: Hapus file lama
							if($oldServerFile!='' && file_exists(FileUpload::getFilePath($oldServerFile, FileUpload::CLIENT_PO_PATH)))
							{
								unlink(FileUpload::getFilePath($oldServerFile, FileUpload::CLIENT_PO_PATH));//IW menghapus file lama dari folder
							}
							
							//WT: Save file baru.
							if($model->client_po_clientfile instanceof CUploadedFile)
								$model->client_po_clientfile->saveAs(FileUpload::getFilePath($model->client_po_serverfile, FileUpload::CLIENT_PO_PATH));
							
						}//end if !empty
						else 
						{
							if($oldClientFile != '') $model->client_po_clientfile = $oldClientFile;
						}	
						$model->save(false);
						
						$app_ip_public = "";
						
						$email = DAO::querySql("SELECT * FROM tdpemployee WHERE employee_type = 'BOD' OR employee_type = 'Purchasing'");
						$globalsetting = DAO::queryRowSql("SELECT * FROM tdpglobalsetting");
						$app_ip_public = $globalsetting['app_ip_public'];
						
						foreach($email as $emailBOD)
						{
							$addTo   = $emailBOD['email'];
							
							$link_url    = "<a href='http://".$app_ip_public."/office2/index.php?r=sales/so/view&id=".$id."' target='_blank'>$id</a>";
							$msg 	 = "SO No. $link_url approved already <br/>";
							$msg    .= 'Sales       : '.$model->employee->employee_name.'<br/>';
							$msg    .= 'Approved By : '.Yii::app()->user->name.'<br/>';
							
							$message = new YiiMailMessage;
							$message->subject = "[Approved] SO Approved $id";
							$message->setBody($msg, 'text/html');
							$message->addTo($addTo);
							$message->from = Yii::app()->user->email;
						
							Yii::app()->mail->send($message);
						}
						
						Yii::app()->user->setFlash('success', "Update Successfully");
					}
					
				}
			}
			else if($model->status == 2 && $model->status != $_POST['So']['so_status_temp'])
			{
				// Pas mau di reopen / close
				// Lakukan pengecheckan hak otorisasi dl..
				//echo "else if model status ==2 <br/>";
				//echo "";
				if(Yii::app()->user->employee_type == 'BOD')
				{
					if($model->purchase_status != 2)
					{
						$model->setAttribute('approve_by', null);
						$model->setAttribute('approve_dt', null);
						$model->setAttribute('status', Status::SO_STATUS_NEW);
						$model->save(array('status'));
						
						//NEW
						if(!empty($model->client_po_clientfile))
						{
							
							if($oldServerFile!='' && file_exists(FileUpload::getFilePath($oldServerFile, FileUpload::CLIENT_PO_PATH)))
								{
									unlink(FileUpload::getFilePath($oldServerFile, FileUpload::CLIENT_PO_PATH));//IW menghapus file lama dari folder
								}//end oldServerFile
								
								//WT: Save file baru.
								if($model->client_po_clientfile instanceof CUploadedFile)
									$model->client_po_clientfile->saveAs(FileUpload::getFilePath($model->client_po_serverfile, FileUpload::CLIENT_PO_PATH));
								
						}//end if !empty
						else 
						{
							if($oldClientFile != '') $model->client_po_clientfile = $oldClientFile;
						}//end else
						$model->save(false);
					}
					else
						$model->addError("So_cd","Cannot ReOpen SO, this SO already Delivered");
				}//if yii app
			}
			else
			{
				$model->attributes = $_POST['So'];
				if($model->validate())
				{
					$model->client_po_clientfile = CUploadedFile::getInstance($model, "client_po_clientfile");
					if($model->client_po_clientfile !== null)
					{
						$model->client_po_serverfile = str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $model->so_cd).'.'.$model->client_po_clientfile->extensionName;
						//$model->so_file_name = str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $model->so_cd).'.'.$model->client_po_clientfile->extensionName;
						//$model->so_file_name = $model->client_po_clientfile;
						//echo "if model->sofilename ".$model->client_po_clientfile."<br/>";
					}
					else
					{
						//echo "else dari model->sofilename <br/>";
						//if($oldClientFile != '') $model->client_po_clientfile = $oldClientFile;
					}
						
					//var_dump($model->client_po_clientfile);
					//echo "<br/> model->client_po_clientfile = ".$model->client_po_clientfile;
					//echo "<br/> oldClientFile = ".$oldClientFile;
					
					if(!empty($model->client_po_clientfile))
					{
						//WT: Hapus file lama
						//echo "<br/> masuk ke if !empty model->client_po_clientfile ";
						if($oldServerFile!='' && file_exists(FileUpload::getFilePath($oldServerFile, FileUpload::CLIENT_PO_PATH)))
						{
							unlink(FileUpload::getFilePath($oldServerFile, FileUpload::CLIENT_PO_PATH));//IW menghapus file lama dari folder
							//echo "<br/> masuk ke if oldserverfile ";
						}
					
						//WT: Save file baru.
						if($model->client_po_clientfile instanceof CUploadedFile)
						{
							$model->client_po_clientfile->saveAs(FileUpload::getFilePath($model->client_po_serverfile, FileUpload::CLIENT_PO_PATH));
							//echo "<br/> masuk ke if model->client_po_client instanceof ";
						}
					}//end if !empty
					else 
					{
						if($oldClientFile != '') $model->client_po_clientfile = $oldClientFile;
					}
					$model->save(false);
					Yii::app()->user->setFlash('success', "Update Successfully");

				}//end if model validate
			}
			//WT: initialize object CUploadedFile. Nanti digunain pada saat validasi pada model. CFileValidator.
		}//end else if

		$this->render('update',array(
			'model'=>$model,
			'mDetail'=>$mDetail
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
			$model = So::model()->findByPk($id);
			$resp  = $model->isCanDeletedOrModified();
			
			if($resp['status'])
			{
				//Sodetail::model()->deleteAll('so_cd=:scd',array(':scd'=>$id));
					$model->status = Status::SO_STATUS_VOID;
					$model->save(false);
					
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}else{
				throw new CHttpException('',$resp['message']);
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
	
	public function actionCreatedetail($so_cd)
	{
		$model=new Sodetail;
		// WT: Set Default Value
		$model->setAttribute('discount_type', 0);
		
		$mSo = So::model()->findByPk($so_cd);
		$flag=0;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['Sodetail']))
		{
			if($mSo->status == Status::SO_STATUS_VOID || $mSo->status == Status::SO_STATUS_NEW)
			{
				$mSo->status 		  = Status::SO_STATUS_NEW;
				$model->attributes	  = $_POST['Sodetail'];
				$model->so_cd 		  = $so_cd;
				$model->qty_purchased = 0;
				$model->qty_delivered = 0;
				
				$query="SELECT sodetail_id";
				$query .= " FROM tdpsodetail WHERE so_cd='$so_cd' AND item_cd='".$_POST['Sodetail']['item_cd']."'";
					
				$val=DAO::queryRowSql($query);
				
				if($val)//validasi kalau mencegah item ganda di po
				$model->addError('item_cd','That item is already in your list. Please choose another item.');
				
				else 
				{
					$qKurs = Vwkurs::model()->find('kurs_from=:krs', array(':krs'=>$model->cost_currency));
					$kurs = ($qKurs === null? 1 : $qKurs->kurs_tengah);
					$model->cost_kurs = $kurs;
					
					$model->setAttribute('total_cost_price', 0);
					$model->setAttribute('total_sell_price', 0);
					
					if($mSo->is_tax == 1)
					{
						if($_POST['Sodetail']['sell_tax_cd1'] == "" && $_POST['Sodetail']['sell_tax_cd2'] == "")
						{
							$model->addError('sell_tax_cd1','At least add one type of tax');
							$flag = 1;
						}
					}
					
					
					if($flag == 0)
					{
						if($model->validate()){	
							$model->setAttribute('total_cost_price', ($model->qty * $model->cost_price * $model->cost_kurs));
							$model->setAttribute('total_sell_price', ($model->qty * $model->sell_price));
							
							if($model->discount_type == Status::DISC_NO_DISC){
								$model->discount_amt = 0;
								$model->discount_value = 0;
							}else if($model->discount_type == Status::DISC_PERCENT){
								$model->discount_amt = $model->total_sell_price * ($model->discount_value/100);
							}else
								$model->discount_amt =  $model->qty * $model->discount_value;
							
							$temp_total_sell_price = $model->total_sell_price;
							$model->total_sell_price = ($model->total_sell_price-$model->discount_amt);
							
							$this->setTax($model,'create');		
							$model->total_sell_price = $temp_total_sell_price;
								
							$mSo->subtotal_cost += $model->total_cost_price ;//* $model->cost_kurs;
							$mSo->subtotal_sell += $model->total_sell_price;
							$mSo->subtotal_sell_disc += $model->discount_amt;
							
							$model->save(false);
							$mSo->save(false);
							
							Yii::app()->user->setFlash('success',  'Create Successfully  : '.$model->item->item_name);
							$this->redirect(array('createdetail', 'so_cd'=>$so_cd));
						}else{
							echo "5:";
						}//end if model validate
					}//end if flag
				}//end else
			}//end if m$sostatus
			else
			{
				$model->addError('so_cd','Cannot edit detail because SO not open.');
			}
		}
	
		$this->setTextValue($model);
	
		$this->renderPartial('_formdetail',array(
            'model'=>$model,
            'mSo'=>$mSo,
		));
	}
	
	public function actionUpdatedetail($id)
	{
		$flag=0;
		$temp_total_sell_price = 0;
		
		$model= Sodetail::model()->findByPk($id);
		$mSo  = So::model()->findByPk($model->so_cd);
	
		//WT: check authorization and status before editing.
		if(isset($_POST['Sodetail']))
		{
			if($mSo->status == Status::SO_STATUS_NEW) 
			{
				// AH: updating data from database
				//$mSo->subtotal_cost -= $model->total_cost_price * $model->cost_kurs;
				$mSo->subtotal_cost -= $model->total_cost_price;
				$mSo->subtotal_sell -= $model->total_sell_price;
				$mSo->subtotal_sell_disc -= $model->discount_amt;
				
				$model->attributes = $_POST['Sodetail'];
				if($model->validate())
				{
					$qKurs = Vwkurs::model()->find('kurs_from=:krs', array(':krs'=>$model->cost_currency));
					$kurs = ($qKurs === null? 1 : $qKurs->kurs_tengah);
					$model->cost_kurs = $kurs;
					
					$model->setAttribute('total_cost_price', ($model->qty * $model->cost_price * $model->cost_kurs));
					$model->setAttribute('total_sell_price', ($model->qty * $model->sell_price));
					
					if($model->discount_type == Status::DISC_NO_DISC){
						$model->discount_amt = 0;
						$model->discount_value = 0;
					}else if($model->discount_type == Status::DISC_PERCENT){
						$model->discount_amt = $model->total_sell_price * ($model->discount_value/100);
					}else
						$model->discount_amt =  $model->qty * $model->discount_value;
					
					$temp_total_sell_price   = $model->total_sell_price;
					$model->total_sell_price = ($model->total_sell_price - $model->discount_amt);
					
					$this->setTax($model,'update');
					
					$model->total_sell_price = $temp_total_sell_price;
					
					$mSo->subtotal_cost += $model->total_cost_price;
					$mSo->subtotal_sell += $model->total_sell_price;
					$mSo->subtotal_sell_disc += $model->discount_amt;
					
					if($mSo->is_tax == 1)
					{
						if($_POST['Sodetail']['sell_tax_cd1'] == "" && $_POST['Sodetail']['sell_tax_cd2'] == "")
						{
							$model->addError('sell_tax_cd1','At least add one type of tax');
							$flag=1;
						}
					}
					
					if($flag == 0)
					{
						$model->save(false);
						$mSo->save(false);
						Yii::app()->user->setFlash('success', "Update Successfully");
													$this->redirect(array('createdetail','so_cd'=>$model->so_cd));
					}
				}
			}
			else
			{
				$model->addError('so_cd','Cannot edit detail because SO not open.');
			}
		}
		
		$this->setTextValue($model);

		$this->renderPartial('_formdetail',array(
			'model'=>$model,
			'mSo'=>$mSo,
		));
	}
	
	public function actionDeletedetail($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model= Sodetail::model()->findByPk($id);
			$mSo  = So::model()->findByPk($model->so_cd);
			
			$mSo->subtotal_cost -= $model->total_cost_price;// * $model->cost_kurs;
			$mSo->subtotal_sell -= $model->total_sell_price;
			$mSo->subtotal_sell_disc -= $model->discount_amt;
			
			if($mSo->status == Status::SO_STATUS_NEW || $mSo->status == Status::SO_STATUS_VOID)
			{
				//AH: removing sell_tax
				$model->sell_tax_cd1 = NULL;
				$model->sell_tax_cd2 = NULL;
				
				$this->setTax($model,'update');
				$model->delete();
				$mSo->save(false);
			}
			else 
				throw new CHttpException(500,'Cannot edit detail because SO not open.');
	
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * 
	 * Function ini digunakan untuk set text yang bukan merupakan inputan dari Sodetail.
	 * hanya untuk display interface saja.
	 * @param Sodetail $model pass by reference $model.
	 */
	private function setTextValue(&$model)
	{
		// Set other table value
		if(!empty($model->item_cd))
		{
			$item = Item::model()->findByPk($model->item_cd);
			if($item!==null)
			{
				$model->setAttribute('item_name', $item->item_name);
				$model->setAttribute('product_number', $item->product_number);
				$model->setAttribute('item_desc', $item->item_desc);
			}
		}
		// Set other table value
		if(!empty($model->vendor_cd))
		{
			$vendor = Vendor::model()->findByPk($model->vendor_cd);
			if($vendor!==null)
			{
				$model->setAttribute('vendor_name', $vendor->vendor_name);
			}
		}
	}
	
	/**
	 * 
	 * Function ini digunakan untuk set other tax value.
	 * @param Sodetail $model pass by reference $model.
	 */
	private function setTax(&$model,$action)
	{
		
		$id = $model->so_cd;
		
		// AH: Setting sell_tax
		// if update than make contrary from data gained
		
		if($action == "update")
		{
			$modelDetail = Sodetail::model()->find('sodetail_id = :sodetail_id', array(':sodetail_id'=>$model->sodetail_id));
			
			if(!empty($modelDetail->sell_tax_cd1))
			{
				$modelTax1  			=  Sotax::model()->find("so_cd = :so_cd AND tax_cd = :tax_cd ",array(":so_cd"=>$modelDetail->so_cd,":tax_cd"=>$modelDetail->sell_tax_cd1));
				$modelTax1->tax_amount -= $modelDetail->sell_tax_amount1;
				if($modelTax1->tax_amount == 0)
					$modelTax1->delete();
				else
					$modelTax1->update(array('tax_amount'));
			}
			
			if(!empty($modelDetail->sell_tax_cd2))
			{
				$modelTax2  			=  Sotax::model()->find("so_cd = :so_cd AND tax_cd = :tax_cd ",array(":so_cd"=>$modelDetail->so_cd,":tax_cd"=>$modelDetail->sell_tax_cd2));
				$modelTax2->tax_amount -= $modelDetail->sell_tax_amount2;
				if($modelTax2->tax_amount == 0)
					$modelTax2->delete();
				else
					$modelTax2->update(array('tax_amount'));
			}
		}
		
		if(!empty($model->sell_tax_cd1))
		{
			$qTax = Tax::model()->findByPk($model->sell_tax_cd1);
			
			if($qTax !== null)
			{
				$model->setAttribute('sell_tax_percent1', $qTax->tax_percent);
				$model->setAttribute('sell_tax_minus1', $qTax->tax_minus);
				$model->setAttribute('sell_tax_amount1', ($model->total_sell_price * ($qTax->tax_percent/100) * $qTax->tax_minus));
			}
			
			$modelTax1  =  Sotax::model()->find("so_cd = :so_cd AND tax_cd = :tax_cd ",array(":so_cd"=>$id,":tax_cd"=>$model->sell_tax_cd1));
				
			if($modelTax1 !== NULL)
			{
				$modelTax1->tax_amount += $model->sell_tax_amount1;
				$modelTax1->update(array('tax_amount'));
			}
			else
			{
				$modelTax1	= new Sotax();
				$modelTax1->so_cd 			  = $id;
				$modelTax1->tax_cd			  = $model->sell_tax_cd1;
				$modelTax1->tax_amount		  = $model->sell_tax_amount1;
				$modelTax1->save(false);
			}
		}else{
			$model->sell_tax_cd1 = NULL;
			$model->sell_tax_percent1 = NULL;
			$model->sell_tax_minus1 = NULL;
			$model->sell_tax_amount1 = NULL;
		}
		
		if(!empty($model->sell_tax_cd2))
		{
			$qTax = Tax::model()->findByPk($model->sell_tax_cd2);
			
			if($qTax !== null)
			{
				$model->setAttribute('sell_tax_percent2', $qTax->tax_percent);
				$model->setAttribute('sell_tax_minus2', $qTax->tax_minus);
				$model->setAttribute('sell_tax_amount2', ($model->total_sell_price * ($qTax->tax_percent/100) * $qTax->tax_minus));
			}
			
			$modelTax2  =  Sotax::model()->find("so_cd = :so_cd AND tax_cd = :tax_cd ",array(":so_cd"=>$id,":tax_cd"=>$model->sell_tax_cd2));
				
			if($modelTax2 !== NULL)
			{
				$modelTax2->tax_amount += $model->sell_tax_amount2;
				$modelTax2->update(array('tax_amount'));
			}
			else
			{
				$modelTax2	= new Sotax();
				$modelTax2->so_cd 			  = $id;
				$modelTax2->tax_cd			  = $model->sell_tax_cd2;
				$modelTax2->tax_amount		  = $model->sell_tax_amount2;
				$modelTax2->save(false);
			}
		}else{
			$model->sell_tax_cd2 = NULL;
			$model->sell_tax_percent2 = NULL;
			$model->sell_tax_minus2 = NULL;
			$model->sell_tax_amount2 = NULL;
		}
		
		// AH: Setting cost_tax
		if(!empty($model->cost_tax_cd1))
		{
			$qTax = Tax::model()->findByPk($model->cost_tax_cd1);
				
			if($qTax !== null)
			{
				$model->setAttribute('cost_tax_percent1', $qTax->tax_percent);
				$model->setAttribute('cost_tax_minus1', $qTax->tax_minus);
				$model->setAttribute('cost_tax_amount1', ($model->total_cost_price * ($qTax->tax_percent/100) * $qTax->tax_minus));
			}
		}else{
			$model->cost_tax_cd1 = NULL;
			$model->cost_tax_percent1 = NULL;
			$model->cost_tax_minus1 = NULL;
			$model->cost_tax_amount1 = NULL;
		}
		
		if(!empty($model->cost_tax_cd2))
		{
			$qTax = Tax::model()->findByPk($model->cost_tax_cd2);
				
			if($qTax !== null)
			{
				$model->setAttribute('cost_tax_percent2', $qTax->tax_percent);
				$model->setAttribute('cost_tax_minus2', $qTax->tax_minus);
				$model->setAttribute('cost_tax_amount2', ($model->total_cost_price * ($qTax->tax_percent/100) * $qTax->tax_minus));
			}
		}else{
			$model->cost_tax_cd2 = NULL;
			$model->cost_tax_percent2 = NULL;
			$model->cost_tax_minus2 = NULL;
			$model->cost_tax_amount2 = NULL;
		}
	}
	
	private function calcSo($id)
	{
		$model = So::model()->findByPk($id);
		
		$qTotalCost = DAO::queryRowSql('Select Sum(total_cost_price) as total From tdpsodetail Where so_cd = :scd', array(':scd'=>$id));
		if($qTotalCost !== false)
			$model->subtotal_cost = $qTotalCost['total'];
		
		$qTotalSell = DAO::queryRowSql('Select Sum(total_sell_price) as total From tdpsodetail Where so_cd = :scd', array(':scd'=>$id));
		if($qTotalSell !== false)
			$model->subtotal_sell = $qTotalSell['total'];
	}
	
	
	public function actionDeleteFile($id)
	{
		$model=So::model()->findByPk($id);
	
		if($model->client_po_serverfile != '' || $model->client_po_clientfile != '')
		{
			if(file_exists(FileUpload::getFilePath($model->client_po_serverfile, FileUpload::CLIENT_PO_PATH)))
				unlink(FileUpload::getFilePath($model->client_po_serverfile, FileUpload::CLIENT_PO_PATH));
			
			$model->setAttribute('client_po_clientfile', null);
			$model->setAttribute('client_po_serverfile', null);
			$model->update(array('client_po_clientfile','client_po_serverfile'));
			
			Yii::app()->user->setFlash('success', "PO File Deleted Successfully");
			$this->redirect(array('update','id'=>$model->so_cd));
// 			if(file_exists(Yii::app()->basePath.'/../upload/client_po/'.$pic))
// 				unlink(Yii::app()->basePath.'/../upload/client_po/'.$pic);
		}
	
		Yii::app()->user->setFlash('error', "No file deleted");
		$this->redirect(array('update','id'=>$model->so_cd));
		//$this->redirect(array('update','id'=>$id));
	}
	
	public function actionPreview()
	{
		$id = $_REQUEST['id'];
		$salesorder_h = So::model()->find("so_cd = '".$id."'");
		$salesorder_d = Sodetail::model()->with('vendor')->together()->findAll("so_cd = '".$id."'");
		$this->renderPartial('_preview',array('header'=>$salesorder_h,'detail'=>$salesorder_d));
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
