<?php

class SoinvoiceController extends Controller
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
	
	public function actionAjxInvoiceContactAndAddress()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$so_cd = $_POST['Soinvoice']['so_cd'];
			$cmbAddress = CHtml::tag('option', array('value'=>''), '-Choose Address-',true);
			$cmbContact = CHtml::tag('option', array('value'=>''), '-Choose Contact-',true);
			$resp= '';
			
			$so = So::model()->find("so_cd = '".$so_cd."'");
			
			$list = Clientcontactdetail::model()->findAll(array(
			    'select'	=>'*',
			    'condition' =>'client_cd = "'.$so->client_cd.'" AND status = '.Status::STATUS_ACTIVE,
			));
			
			foreach($list as $object)
			{
				$cmbContact .= CHtml::tag('option', array('value'=>$object->contact_id), $object->contact_name." - ".$object->position,true);
			}//end foreach
			
			$list = Clientaddress::model()->findAll(array(
			    'select'	=>'*',
			    'condition' =>'client_cd = "'.$so->client_cd.'" AND status = '.Status::STATUS_ACTIVE,
			));
			
			foreach($list as $object)
			{
				$cmbAddress .= CHtml::tag('option', array('value'=>$object->address_id), $object->short_desc,true);
			}//end foreach
			
			$resp =  array('cmbAddress'=>$cmbAddress,'cmbContact'=>$cmbContact,'soContact'=>$so->invoice_contact_id,'soAddress'=>$so->invoice_address_id);
		
			echo json_encode($resp);
		}//end if request postrequest
		else 
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}//end else
	}
	
	public function actionDeleteFile($id,$file)
	{
		$model=Soinvoice::model()->findByPk($id);
		switch ($file) {
			case "1":
				if($model->invoice_file_name!='')
				{
					if(file_exists(FileUpload::getFilePath($model->invoice_file_name, FileUpload::CLIENT_SOINVOICE_PATH)))
					unlink(FileUpload::getFilePath($model->invoice_file_name, FileUpload::CLIENT_SOINVOICE_PATH));
						
					$model->setAttribute('invoice_file_name', null);
					$model->update(array('invoice_file_name'));
						
					Yii::app()->user->setFlash('success', "SOINVOICE File Deleted Successfully");
					$this->redirect(array('update','id'=>$model->soinvoice_cd));
				}//end if
				break;
			case "2":
				if($model->fp_file_name!='')
				{
					if(file_exists(FileUpload::getFilePath($model->fp_file_name, FileUpload::CLIENT_SOINVOICE_PATH)))
					unlink(FileUpload::getFilePath($model->fp_file_name, FileUpload::CLIENT_SOINVOICE_PATH));
						
					$model->setAttribute('fp_file_name', null);
					$model->update(array('fp_file_name'));
						
					Yii::app()->user->setFlash('success', "FP File Deleted Successfully");
					$this->redirect(array('update','id'=>$model->soinvoice_cd));
				}//end if
				break;
		}//end switch
	}
	
	/*public function actionBrowseSo()
	{
		$so_cd = $_REQUEST['so_cd']; 
		$this->layout='//layouts/popup1';
		//$model = Soinvoice::model()->find('t.so_cd =:so_cd',array(':so_cd'=>$so_cd));
		$model = new Soinvoice();
		$model->unsetAttributes();
		$model->so_cd = $so_cd;
		
		//if(isset($so_cd))
		//$model->attributes = $_GET['Soinvoice'];
		//$model->so_cd = $so_cd;

		$this->render('_formsodetail',array(
				'model'=>$model,
		));
	}*/
	
	private function formatting($data)
	{
		return number_format($data,2,".",",");
	}
	
	
	
	public function actionShwDetail()
	{
		$so_cd   = $_POST['so_cd'];
		
		$modelSoDetail = new Sodetail();
		$modelSoDetail->unsetAttributes();
		$modelSoDetail->so_cd = $so_cd;
		
		if($modelSoDetail === NULL)
			throw new CHttpException(404,'The requested page does not exist.');
		
		$this->renderPartial('_soinvoicedetailgrid',array(
			'model'=>$modelSoDetail,
		),false,true);
	}
	
	public function actionShwDoDetail()
	{
		$do_cd = $_REQUEST['do_cd'];
		$this->layout = '//layouts/popup1';
		
		$model = new Devodetail('search');
		$model->unsetAttributes();
		$model->do_cd = $do_cd;
		
		$this->render('_formitem',array(
				'model'=>$model,
		));
	}
	
	public function actionDeleteDetail($id)
	{
		if(Yii::app()->request->isAjaxRequest):
			$model 		  = Soinvoicedo::model()->findByPk($id);
			$soinvoice_cd = $model->soinvoice_cd;
			$modelSoInvoice = Soinvoice::model()->find("soinvoice_cd = '".$soinvoice_cd."'");
			
			$model->delete();
			$status 	  = $this->manageInvoiceItemDetail($soinvoice_cd);
			
			$used_dp = $modelSoInvoice->used_dp;
			if(empty($used_dp)) $used_dp=0;
			
			$grand_total_sum = DAO::queryAllSql("SELECT IFNULL(SUM(total_price),0)+IFNULL(SUM(tax_amount1),0)+IFNULL(SUM(tax_amount2),0)AS grand_total_sum FROM tdpsoinvoicedetail where soinvoice_cd = '".$model->soinvoice_cd."'");
			
			$discount = DAO::queryRowSql("SELECT SUM(discount_amt)AS 'discount_amt' from tdpsoinvoicedetail where soinvoice_cd = '".$model->soinvoice_cd."'");
			$grand_total_sum[0]['grand_total_sum'] -= $discount['discount_amt'];
			$tax = DAO::queryRowSql("SELECT SUM(tax_amount) AS tax_amount FROM tdpsoinvoicetax WHERE soinvoice_cd= '".$model->soinvoice_cd."'");
			
			$modelSoInvoice->grandtotal_price = $grand_total_sum[0]['grand_total_sum'];
			$modelSoInvoice->payment_amount = $grand_total_sum[0]['grand_total_sum'] - $used_dp;
			if($modelSoInvoice->payment_amount<0)$modelSoInvoice->payment_amount = 0;
			
			$subtotal_price = DAO::queryRowSql("SELECT SUM(total_price)AS subtotal_price FROM tdpsoinvoicedetail WHERE soinvoice_cd = '".$model->soinvoice_cd."'");
			if ($subtotal_price['subtotal_price']==null||$subtotal_price['subtotal_price']=="")$subtotal_price['subtotal_price']=0;
			$modelSoInvoice->subtotal_price 	= $subtotal_price['subtotal_price'];
			$modelSoInvoice->subtotal_disc	= $discount['discount_amt'];
			$modelSoInvoice->subtotal_tax	= $tax['tax_amount'];
			
			$modelSoInvoice->save(FALSE);
			
			//AH: updating depedency status
			$modelDO  = Devo::model()->findByPk($model->do_cd);
			$modelSO  = So::model()->findByPk($modelDO->letter_cd);
				
			$modelDO->updateDepedencyStatus('invoice_status');
			$modelSO->updateDepedencyStatus('invoice_status');
			
			$data = json_encode(array('grand_total_sum'=>$this->formatting($grand_total_sum[0]['grand_total_sum']),
										'subtotal_price' => $this->formatting($subtotal_price['subtotal_price']),
										'subtotal_disc'=>$this->formatting($discount['discount_amt']),
										'subtotal_tax'=>$this->formatting($tax['tax_amount']),
										'grand_total_sum_float'=>$grand_total_sum[0]['grand_total_sum'],
										'subtotal_price_float' =>$subtotal_price['subtotal_price'],
										'subtotal_disc_float'=>$discount['discount_amt'],
										'subtotal_tax_float'=>$tax['tax_amount']									
										));
			echo $data;
		else:
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		endif ;
	} 
	 
	public function actionAddDoDetail()
	{
		if(Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest):
			$model 			   = new Soinvoicedo();
			$model->attributes = $_POST['Soinvoicedo'];
			$modelSoInvoice	   = Soinvoice::model()->find("soinvoice_cd = '".$model->soinvoice_cd."'");
			
			if($model->validate()):
				//$modelChecker = Soinvoicedo::model()->find('soinvoice_cd=:soinvoice_cd AND do_cd =:do_cd',
				//						array(':soinvoice_cd'=>$model->soinvoice_cd, ':do_cd'=>$model->do_cd));
				$query	= "SELECT * ";
				$query	.= "FROM tdpsoinvoice si join tdpsoinvoicedo sd on si.soinvoice_cd = sd.soinvoice_cd AND status != 0 ";
				$query	.= "WHERE sd.do_cd = '$model->do_cd' ";
				$modelChecker = DAO::queryAllSql($query);
				
				$modelChecker2 = Devo::model()->findByPk($model->do_cd);
				
				if($modelChecker != NULL):
					$data = array('status'=>'failed','err_msg'=>'Code Already Registered','grand_total_sum'=>'');
					echo json_encode($data);
				elseif($modelChecker2->is_print == 0):
					$data = array('status'=>'failed','err_msg'=>'Delivery order not yet printed','grand_total_sum'=>'');
					echo json_encode($data);
				else:
					$model->save(FALSE);
					$status = $this->manageInvoiceItemDetail($model->soinvoice_cd);
					
					$used_dp = $modelSoInvoice->used_dp;
					if(empty($used_dp)) $used_dp=0;
					
					$grand_total_sum = DAO::queryAllSql("SELECT IFNULL(SUM(total_price),0)+IFNULL(SUM(tax_amount1),0)+IFNULL(SUM(tax_amount2),0)AS grand_total_sum FROM tdpsoinvoicedetail where soinvoice_cd = '".$model->soinvoice_cd."'");
					$subtotal_price = DAO::queryRowSql("SELECT SUM(total_price)AS subtotal_price FROM tdpsoinvoicedetail WHERE soinvoice_cd = '".$model->soinvoice_cd."'");
					$discount = DAO::queryRowSql("SELECT SUM(discount_amt)AS 'discount_amt' from tdpsoinvoicedetail where soinvoice_cd = '".$model->soinvoice_cd."'");
					$tax = DAO::queryRowSql("SELECT SUM(tax_amount) AS tax_amount FROM tdpsoinvoicetax WHERE soinvoice_cd= '".$model->soinvoice_cd."'");
					$grand_total_sum[0]['grand_total_sum'] -= $discount['discount_amt'];
					
					if($status)
					{
						$modelSoInvoice->grandtotal_price = $grand_total_sum[0]['grand_total_sum'];
						$modelSoInvoice->payment_amount = $grand_total_sum[0]['grand_total_sum'] - $used_dp;
						
						if ($subtotal_price['subtotal_price']==null||$subtotal_price['subtotal_price']=="")$subtotal_price['subtotal_price']=0;
						$modelSoInvoice->subtotal_price 	= $subtotal_price['subtotal_price'];
						
						if ($discount['discount_amt']==null||$discount['discount_amt']=="")$discount['discount_amt']=0;
						$modelSoInvoice->subtotal_disc		= $discount['discount_amt'];
						
						if ($tax['tax_amount']==null||$tax['tax_amount']=="")$tax['tax_amount']=0;
						$modelSoInvoice->subtotal_tax		= $tax['tax_amount'];
						
						$modelSoInvoice->save(FALSE);
						
						//AH: updating depedency status
						$modelDO  = Devo::model()->findByPk($model->do_cd);
						$modelSO  = So::model()->findByPk($modelDO->letter_cd);
						
						$modelDO->updateDepedencyStatus('invoice_status');
						$modelSO->updateDepedencyStatus('invoice_status');
						
						$originalDate = $modelDO->delivery_dt;
						$newDate = date("d/m/Y", strtotime($originalDate));
						
						$data = array('status'=>'success','grand_total_sum'=>$this->formatting($grand_total_sum[0]['grand_total_sum']),
										'subtotal_price' => $this->formatting($subtotal_price['subtotal_price']),
										'subtotal_disc'=>$this->formatting($discount['discount_amt']),
										'subtotal_tax'=>$this->formatting($tax['tax_amount']),
										'grand_total_sum_float'=>$grand_total_sum[0]['grand_total_sum'],
										'subtotal_price_float' =>$subtotal_price['subtotal_price'],
										'subtotal_disc_float'=>$discount['discount_amt'],
										'subtotal_tax_float'=>$tax['tax_amount'],
										'delivery_dt'=>$newDate,	
						);
						
						echo json_encode($data);
					}
				endif;
			else:
				echo $model->getError('do_cd');
			endif;
		else:
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		endif;
	}


	private function manageInvoiceItemDetail($soinvoice_cd)
	{
		$query   = 'DELETE FROM tdpsoinvoicedetail ';
		$query  .= "WHERE soinvoice_cd = '$soinvoice_cd'";
		
		$status = DAO::executeSql($query);
		
		$query   = 'DELETE FROM tdpsoinvoicetax ';
		$query  .= "WHERE soinvoice_cd = '$soinvoice_cd'";
		
		$status = DAO::executeSql($query);	
		
		$query   = 'INSERT INTO tdpsoinvoicedetail ';
		$query  .= "SELECT NULL,'$soinvoice_cd', item_cd, SUM(qty) AS qty, price, SUM(total_price) as total_price, notes, sell_tax_cd1, ";
		$query  .= 'sell_tax_percent1, sell_tax_minus1, SUM(sell_tax_amount1) as sell_tax_amount1, sell_tax_cd2, sell_tax_percent2, sell_tax_minus2, SUM(sell_tax_amount2) as sell_tax_amount2, ';
		$query	.= "discount_type, discount_value, SUM(discount_amt) AS discount_amt ";
		$query  .= 'FROM vwdevosodet ';
		$query  .= "WHERE do_cd  IN (SELECT do_cd FROM tdpsoinvoicedo WHERE soinvoice_cd  = '$soinvoice_cd') ";
		$query  .= "GROUP BY '$soinvoice_cd',item_cd,price,notes,sell_tax_cd1, ";
		$query  .= 'sell_tax_percent1,sell_tax_minus1,sell_tax_cd2,sell_tax_percent2,sell_tax_minus2,discount_type,discount_value ';
		
		$status = DAO::executeSql($query);
		
		$query	= "INSERT INTO tdpsoinvoicetax ";
		$query  .= "SELECT NULL,'$soinvoice_cd' ,tax_cd , SUM( tax_amount ) AS tax_amount ";
		$query  .= "FROM(";
		$query  .= "SELECT SUM( tax_amount1 ) AS tax_amount, tax_cd1 AS tax_cd ";
		$query  .= "FROM tdpsoinvoicedetail ";
		$query  .= "WHERE soinvoice_cd =  '$soinvoice_cd' ";
		$query  .= "AND tax_cd1 IS NOT NULL AND tax_cd1 <> '' "; 
		$query  .= "GROUP BY tax_cd1 ";
		$query  .= "UNION ";
		$query  .= "SELECT SUM( tax_amount2 ) AS tax_amount, tax_cd2 AS tax_cd ";
		$query  .= "FROM tdpsoinvoicedetail ";
		$query  .= "WHERE soinvoice_cd = '$soinvoice_cd' ";
		$query  .= "AND tax_cd2 IS NOT NULL AND tax_cd2 <> '' ";
		$query  .= "GROUP BY tax_cd2  ";
		$query  .= ") AS x ";
		$query  .= "GROUP BY tax_cd ";
		$query  .= "ORDER BY tax_cd DESC";
		
		$status = DAO::executeSql($query);
		
		$query	= "UPDATE tdpsoinvoice SET ";
		$query	.= "subtotal_tax = (SELECT SUM(tax_amount) AS subtotal_tax ";
		$query	.= "FROM tdpsoinvoicetax ";
		$query	.= "WHERE soinvoice_cd = '$soinvoice_cd'), ";
		//$query	.= "WHERE soinvoice_cd = '$soinvoice_cd' ";
		
		//$status = DAO::executeSql($query);
		
		//$query	= "UPDATE tdpsoinvoice SET ";
		$query	.= "subtotal_price = (SELECT SUM(total_price) AS subtotal_price ";
		$query	.= "FROM tdpsoinvoicedetail ";
		$query	.= "WHERE soinvoice_cd = '$soinvoice_cd'), ";
		//$query	.= "WHERE soinvoice_cd = '$soinvoice_cd' ";
		
		$query	.= "subtotal_disc = (SELECT SUM(discount_amt) AS discount_amt ";
		$query	.= "FROM tdpsoinvoicedetail ";
		$query	.= "WHERE soinvoice_cd = '$soinvoice_cd') ";
		$query	.= "WHERE soinvoice_cd = '$soinvoice_cd' ";
		
		$status	= DAO::executeSql($query);
		
		return true;
	}
	 
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$status = true;
		
		$modelSOInvoiceDO = new Soinvoicedo();
		$modelSOInvoiceDO->unsetAttributes();
		$modelSOInvoiceDO->soinvoice_cd = $id;
		
		$modelSOInvoiceDetail = new Soinvoicedetail();
		$modelSOInvoiceDetail->unsetAttributes();
		$modelSOInvoiceDetail->soinvoice_cd = $id;
			
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'modelSoInvoice'		=> $model,
			'modelSoInvoiceDO'		=> $modelSOInvoiceDO,
			'modelSoInvoiceDetail'	=> $modelSOInvoiceDetail
		));
	}
	
	public function actionAjxClientName()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$so_cd 		= $_POST['Soinvoice']['so_cd'];
			
			if(!empty($so_cd) )
			{
				$so = So::model()->findByPk($so_cd); //select * from So where (primary key) = $so_cd
				$sodetail = Sodetail::model()->findByPk($so_cd);
				$client = Client::model()->findByPk($so->client_cd);
				$subtotal_tax = DAO::queryAllSql("SELECT SUM(tax_amount) as 'Total' FROM tdpsotax where so_cd = '".$so_cd."'");
				$tax_kurs = DAO::queryRowSql("SELECT * FROM vwtaxkurs WHERE currency_cd = '$so->sell_currency'");
				$currency_kurs = DAO::queryRowSql("SELECT * FROM vwkurs WHERE kurs_from = '$so->sell_currency'");
				
				$grand_total = $so->subtotal_sell - $so->subtotal_sell_disc + $subtotal_tax[0]['Total'];
				
				$remaining_dp = $so->remaining_dp;
				
				if($subtotal_tax[0]['Total']==null)
				{
					$subtotal_tax[0]['Total'] = 0;
				}
				
				if($remaining_dp==null)
				{
					$remaining_dp = 0;
				}
				
				//echo $client->client_cd.' - '.$client->client_name;
				$remaining_dp = number_format($remaining_dp,2,".",",");
				$tax_kurs['kurs_amount'] = number_format($tax_kurs['kurs_amount'],2,".",",");
				$currency_kurs['kurs_tengah'] = number_format($currency_kurs['kurs_tengah'],2,".",",");
				
				$data = array('kode_client'=>$client->client_cd, 'nama_client'=>$client->client_name, 
								'subtotal_sell'=>$this->formatting($so->subtotal_sell), 'subtotal_tax'=>$this->formatting($subtotal_tax[0]['Total']),
								'subtotal_sell_disc'=>$this->formatting($so->subtotal_sell_disc), 'remaining_dp'=>$this->formatting($so->remaining_dp),
								'so_cd'=>$so->so_cd,'top'=>$so->top, 'is_tax'=>$so->is_tax,
								'tax_kurs'=>$tax_kurs['kurs_amount'],'currency_kurs'=>$currency_kurs['kurs_tengah'],
								'subtotal_sell_float'=>$so->subtotal_sell, 'subtotal_tax_float'=>$subtotal_tax[0]['Total'],
								'subtotal_sell_disc_float'=>$so->subtotal_sell_disc, 'grand_total'=> $this->formatting($grand_total),
								'grand_total_float'=>$grand_total, 'currency_cd'=>$so->sell_currency
								);
				echo json_encode($data);
				//echo $data['kode_client'].' - '.$data['nama_client'];
			}
			else
			{
				$data = array('kode_client'=>'', 'nama_client'=>'', 
								'subtotal_sell'=>'', 'subtotal_tax'=>'',
								'subtotal_sell_disc'=>'', 'remaining_dp'=>'',
								'so_cd'=>'', 'top'=>'', 'is_tax'=>'',
								'tax_kurs'=>'','currency_kurs'=>''
								);
				echo json_encode($data);
			}
		}	
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 
	 private function insertSoInvoiceDetail(&$model)
	 {
	 	$query   = 'INSERT INTO tdpsoinvoicedetail ';
		$query  .= "SELECT NULL,'".$model->soinvoice_cd."',item_cd,qty,sell_price,total_sell_price,notes,sell_tax_cd1,";
		$query  .= 'sell_tax_percent1,sell_tax_minus1,sell_tax_amount1,sell_tax_cd2,sell_tax_percent2,sell_tax_minus2,sell_tax_amount2,discount_type,discount_value,discount_amt ';
		$query  .= 'FROM tdpsodetail ';
		$query  .= "WHERE so_cd = '".$model->so_cd."'";
		
		DAO::executeSql($query);
	 }
	 
	public function actionCreate()
	{
		$model=new Soinvoice;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Soinvoice']))
		{
			$model->attributes=$_POST['Soinvoice'];
			$model->currency_cd = $_POST['Soinvoice']['currency_cd'];
			$model->subtotal_disc = $_POST['Soinvoice']['subtotal_disc'];
			//$model->kmk_no = $_POST['Soinvoice']['kmk_no'];
			//$model->kmk_date = $_POST['Soinvoice']['kmk_date'];
			$condition = array('so_cd','signed_by','soinvoice_dt','top','tax_kurs','currency_kurs');
			
			if(!empty($_POST['Soinvoice']['so_cd']))
				{
					$so_cd = $_POST['Soinvoice']['so_cd'];
					$isdp = $_POST['Soinvoice']['is_down_payment'];
					$modelSo = So::model()->findByPk($so_cd);
					$model->is_tax = $modelSo->is_tax;
					//$model->prefix_fp = " ";
					if($model->is_tax==1)
					{
						$condition = array('so_cd','signed_by','soinvoice_dt','top','prefix_fp','tax_kurs','currency_kurs');
						if(!empty($isdp))
						{
							if($isdp==1)
							{
								$condition = array('so_cd','signed_by','soinvoice_dt','top','prefix_fp','tax_kurs','currency_kurs','payment_percent');
							}//end if isdp
						}//end if !empty
					}//end if model->is_tax
				}//end if empty
			
			if($model->validate($condition))
			{
				$so = So::model()->findByPk($model->so_cd);
				$client = Client::model()->find("client_cd = '".$model->client_cd."'");
				$vwtaxkurs = Vwtaxkurs::model()->find("currency_cd = '".$so->sell_currency."'");
				$model->kmk_no = $vwtaxkurs->kmk_no;
				$model->kmk_date = $vwtaxkurs->kmk_date;
				
				$due = new DateTime($model->soinvoice_dt);
				$due->modify("+".$model->top." day");					//menambahkan soinvoice_dt dengan top
				$dueSqlDate = date('Y-m-d',strtotime($due->format("Y-m-d"))); //ikutin format sql supaya bisa di insert
							
				$subtotal = DAO::queryAllSql("SELECT SUM(tax_amount) as 'Total' FROM tdpsotax where so_cd = '".$model->so_cd."'");

				$remaining_dp = $so->remaining_dp;
				$discount = DAO::queryRowSql("SELECT SUM(discount_amt)as 'discount_amt' FROM tdpsodetail where so_cd = '".$model->so_cd."'");
				
				if($discount['discount_amt']==null||$discount['discount_amt']=="")
				{
					$discount['discount_amt'] = 0;
				}

				if($subtotal[0]['Total']==null)
				{
					$subtotal[0]['Total'] = 0;
				}
				
				if($remaining_dp==null)
				{
					$remaining_dp = 0;
				}
				
				if($model->is_down_payment==1):
					$subtotal_sell = (float)$so->subtotal_sell;
					$subtotal_tax = (float)$subtotal[0]['Total'];
					$grand_total = $subtotal_sell - $discount['discount_amt'] + $subtotal_tax;
				else:
					$grand_total = 0;
				endif;
				
				$valid = false;
				
				if($so->is_tax==1)
				{
					$pat_tax = Pattern::generate('SOINVOICE_PPN');
					Pattern::increase('SOINVOICE_PPN');
	   				$model->soinvoice_cd = $pat_tax;
				}
				else
				{
					$pat_non = Pattern::generate('SOINVOICE_NON');
					Pattern::increase('SOINVOICE_NON');
					$model->soinvoice_cd = $pat_non;
				}
	
				if($model->is_down_payment==1)
				{
					$remaining_dp += $model->payment_amount;
					DAO::executeSql("UPDATE tdpso SET remaining_dp = '".$remaining_dp."' where so_cd = '".$so->so_cd."'");
					$valid = true;
				}
				elseif ($model->is_down_payment==0) 
				{
					if($model->used_dp > $remaining_dp)
					{					
						//$model->addError('used_dp','Used dp must not be bigger than remaining dp');
					}
					else
					{
						$model->used_dp = $remaining_dp;
						$model->payment_amount = $model->grandtotal_price - $remaining_dp;
						//$remaining_dp = $remaining_dp - $model->used_dp;
						//$model->payment_amount = $model->grandtotal_price - $model->used_dp;
						//DAO::executeSql("UPDATE tdpso SET remaining_dp = '".$remaining_dp."' where so_cd = '".$so->so_cd."'");
						$valid = true;
					}
				}
				
				$model->client_cd			= $client->client_cd;
				$model->grandtotal_price	= $grand_total;
				$model->due_date			= $dueSqlDate;
				$model->currency_cd			= $so->sell_currency;
				//$model->currency_kurs		= $so->sell_kurs;
				//$model->tax_kurs			= $so->tax_kurs;
				$model->discount_type		= 0;
				$model->discount_value		= 0;
				$model->company_id			= $so->company_id;
				//$model->used_dp				= $remaining_dp;
				
				if($model->is_down_payment==1):
					$model->subtotal_price	= $so->subtotal_sell;
					$model->subtotal_tax	= $subtotal[0]['Total'];
					$model->subtotal_disc	= $discount['discount_amt'];
				elseif($model->is_down_payment==0):
					$model->subtotal_price	= 0;
					$model->subtotal_tax	= 0;
					$model->subtotal_disc	= 0;
				endif; 
				
				$model->is_tax				= $so->is_tax;

				//Starting point status is void because detail not yet inserted
				$model->status 	   	  	= Status::CORE_STATUS_OPEN;
				$model->payment_status 	= Status::DEPEDENCY_STATUS_NOTYET;
				//$model->prefix_fp		= $model->prefix_fp."-".PrefixFp::$prefixFaktur[$model->prefix_fp];
				//if(!empty($model->prefix_fp))
				//{
					//$model->prefix_fp		= $model->prefix_fp."-".PrefixFp::$prefixFaktur[$model->prefix_fp];
				//}
				
				if($valid)
				{
					if($model->save(FALSE)) 
					{
						if($model->is_down_payment==1)
						{
							$this->insertSoInvoiceDetail($model);
							
							$query	= "INSERT INTO tdpsoinvoicetax ";
							$query  .= "SELECT NULL,'$model->soinvoice_cd' ,tax_cd , SUM( tax_amount ) AS tax_amount ";
							$query  .= "FROM(";
							$query  .= "SELECT ( ($model->payment_percent/100) * SUM( tax_amount1 )) AS tax_amount, tax_cd1 AS tax_cd ";
							$query  .= "FROM tdpsoinvoicedetail ";
							$query  .= "WHERE soinvoice_cd =  '$model->soinvoice_cd' ";
							$query  .= "AND tax_cd1 IS NOT NULL AND tax_cd1 <> '' "; 
							$query  .= "GROUP BY tax_cd1 ";
							$query  .= "UNION ";
							$query  .= "SELECT ( ($model->payment_percent/100) * SUM( tax_amount2 )) AS tax_amount, tax_cd2 AS tax_cd ";
							$query  .= "FROM tdpsoinvoicedetail ";
							$query  .= "WHERE soinvoice_cd = '$model->soinvoice_cd' ";
							$query  .= "AND tax_cd2 IS NOT NULL AND tax_cd2 <> '' ";
							$query  .= "GROUP BY tax_cd2  ";
							$query  .= ") AS x ";
							$query  .= "GROUP BY tax_cd ";
							$query  .= "ORDER BY tax_cd DESC";
							
							$status = DAO::executeSql($query);
						}
						
						Yii::app()->user->setFlash('success', "Create Successfully");
						$this->redirect(array('update','id'=>$model->soinvoice_cd));
					}
				}//end if valid
			}//end if model->validate
			else 
			{
				
			}
		}//end if isset

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
		$model = $this->loadModel($id);
		$resp  = $model->isCanDeletedOrModified();
		
		if(!$resp['status'])
			throw new CHttpException('',$resp['message']);
		
		$modelSOInvoiceDO = new Soinvoicedo();
		$modelSOInvoiceDO->unsetAttributes();
		$modelSOInvoiceDO->soinvoice_cd = $id;
		
		$modelSOInvoiceDetail = new Soinvoicedetail();
		$modelSOInvoiceDetail->unsetAttributes();
		$modelSOInvoiceDetail->soinvoice_cd = $id;

		if(isset($_POST['Soinvoice']))
		{
			$old_invoice_file_name = $model->invoice_file_name;
			$old_fp_file_name = $model->fp_file_name;
			$model->attributes=$_POST['Soinvoice'];
			$condition = array('so_cd','signed_by','soinvoice_dt','top','tax_kurs','currency_kurs');
			
			if(!empty($_POST['Soinvoice']['so_cd']))
				{
					$so_cd = $_POST['Soinvoice']['so_cd'];
					$modelSo = So::model()->findByPk($so_cd);
					$model->is_tax = $modelSo->is_tax;
					//$model->prefix_fp = " ";
					if($model->is_tax==1)
					$condition = array('so_cd','signed_by','soinvoice_dt','top','tax_kurs','currency_kurs','prefix_fp');
				}//end if empty
			
			if($model->validate($condition))
			{
				//$string = $this->ChangeDateFormat($model->soinvoice_dt); //change dd/mm/yyyy into mm/dd/yyyy
				
				//echo "model invoice file name = $model->invoice_file_name</br>";
				
				$temp_invoice = CUploadedFile::getInstance($model, "invoice_file_name");
				$temp_fp = CUploadedFile::getInstance($model, "fp_file_name");
				
				//echo $old_fp_file_name."</br>".$old_invoice_file_name;
				
				//echo "</br> temp FP ".$temp_fp." temp invoice ".$temp_invoice;
				if(!empty($temp_invoice))
				{
					$file_name = $temp_invoice->getName();
					if(!empty($old_invoice_file_name))
					{
						if($old_invoice_file_name!='' && file_exists(FileUpload::getFilePath($old_invoice_file_name, FileUpload::CLIENT_SOINVOICE_PATH)))
						{
							unlink(FileUpload::getFilePath($old_invoice_file_name, FileUpload::CLIENT_SOINVOICE_PATH));//IW menghapus file lama dari folder
							//echo "($old_invoice_file_name!='' && file_exists";
						}
						
						$temp_invoice->saveAs(FileUpload::getFilePath($file_name, FileUpload::CLIENT_SOINVOICE_PATH));
					}//end if !empty 
					else if($temp_invoice!='')
					{
						$temp_invoice->saveAs(FileUpload::getFilePath($file_name, FileUpload::CLIENT_SOINVOICE_PATH));
						//echo "else $temp_invoice!='' ($temp_invoice)";
					}
					$model->invoice_file_name = $file_name;
				}//end if !empty $temp
				else
				{
					//echo "else empty $old_invoice_file_name";
					$model->invoice_file_name = $old_invoice_file_name;
				}
				//echo "</br>old Invoice : $old_invoice_file_name </br> new Invoice : $temp_invoice";
				
				if(!empty($temp_fp))
				{
					$file_name = $temp_fp->getName();
					if(!empty($old_fp_file_name))
					{
						if($old_fp_file_name!='' && file_exists(FileUpload::getFilePath($old_fp_file_name, FileUpload::CLIENT_SOINVOICE_PATH)))
						{
							unlink(FileUpload::getFilePath($old_fp_file_name, FileUpload::CLIENT_SOINVOICE_PATH));//IW menghapus file lama dari folder
						}
						
						$temp_fp->saveAs(FileUpload::getFilePath($file_name, FileUpload::CLIENT_SOINVOICE_PATH));
					}//end if !empty 
					else if($temp_fp!='')
					{
						$temp_fp->saveAs(FileUpload::getFilePath($file_name, FileUpload::CLIENT_SOINVOICE_PATH));
					}
					$model->fp_file_name = $file_name;
				}//end if !empty $temp
				else
				{
					$model->fp_file_name = $old_fp_file_name;
				}
				
				
				$so = So::model()->findByPk($model->so_cd);
				$client = Client::model()->find("client_cd = '".$model->client_cd."'");
						
				$due = new DateTime($model->soinvoice_dt);
				$due->modify("+".$model->top." day");					//menambahkan soinvoice_dt dengan top
				$dueSqlDate = date('Y-m-d',strtotime($due->format("Y-m-d"))); //ikutin format sql supaya bisa di insert
							
				$subtotal = DAO::queryAllSql("SELECT SUM(tax_amount) as 'Total' FROM tdpsotax where so_cd = '".$model->so_cd."'");
				
				$remaining_dp = $so->remaining_dp;
				$discount = DAO::queryRowSql("SELECT SUM(discount_amt)as 'discount_amt' FROM tdpsodetail where so_cd = '".$model->so_cd."'");
				
				if($discount['discount_amt']==null||$discount['discount_amt']=="")
				{
					$discount['discount_amt'] = 0;
				}
				
				if($subtotal[0]['Total']==null)
				{
					$subtotal[0]['Total'] = 0;
				}
				
				if($remaining_dp==null)
				{
					$remaining_dp = 0;
				}
				
				/*if($model->is_down_payment==1):
					$subtotal_sell = (float)$so->subtotal_sell;
					$subtotal_tax = (float)$subtotal[0]['Total'];
					$grand_total = $subtotal_sell - $discount['discount_amt'] + $subtotal_tax;
				else:
					$grand_total = 0;
				endif;*/
				
				$valid = false;
				
				if($model->is_down_payment==1)
				{
					//DAO::executeSql("UPDATE tdpso SET remaining_dp = '".$model->payment_amount."' where so_cd = '".$so->so_cd."'");
					$valid = true;
				}
				elseif ($model->is_down_payment==0) 
				{
					$used_dp = DAO::queryRowSql("SELECT IFNULL(used_dp,0) AS used_dp FROM tdpsoinvoice WHERE soinvoice_cd = '$model->soinvoice_cd'");
					$max_dp = $used_dp['used_dp'] + $remaining_dp;
					
					if($model->used_dp > $max_dp)
					{					
						$model->addError('used_dp','Used dp must not be bigger than remaining dp');
					}
					else
					{
						$model->used_dp = $remaining_dp;
						$model->payment_amount = $model->grandtotal_price - $so->remaining_dp;
						//$model->payment_amount = $model->grandtotal_price - $model->used_dp;
						//DAO::executeSql("UPDATE tdpso SET remaining_dp = '".$remaining_dp."' where so_cd = '".$so->so_cd."'");
						$valid = true;
					}
				}
				
				$model->client_cd			= $client->client_cd;
				//$model->grandtotal_price	= $grand_total;
				$model->due_date			= $dueSqlDate;
				$model->currency_cd			= $so->sell_currency;
				//$model->currency_kurs		= $so->sell_kurs;
				//$model->tax_kurs			= $so->tax_kurs;
				$model->discount_type		= 0;
				$model->discount_value		= 0;
				$model->company_id			= $so->company_id;
				//$model->used_dp				= $remaining_dp;
				
				if($model->is_down_payment==1):
					$model->subtotal_price	= $so->subtotal_sell;
				elseif($model->is_down_payment==0):
					//Penambahan validasi jika saat update tidak ada item apapun yang dimasukkan
					$subtotal_price = DAO::queryRowSql("SELECT SUM(total_price)AS subtotal_price FROM tdpsoinvoicedetail WHERE soinvoice_cd = '".$model->soinvoice_cd."'");
					if ($subtotal_price['subtotal_price']==null||$subtotal_price['subtotal_price']=="")$subtotal_price['subtotal_price']=0;
					$model->subtotal_price 	= $subtotal_price['subtotal_price'];
				endif;
				
				//$model->subtotal_tax		= $subtotal[0]['Total'];
				$model->is_tax				= $so->is_tax;
				
				if($model->payment_amount<0)$model->payment_amount = 0;
				
				//Starting point status is void because detail not yet inserted
				//$model->status 	   	  	= Status::CORE_STATUS_OPEN;
				//$model->payment_status 	= Status::DEPEDENCY_STATUS_NOTYET;
				
				if($valid)
				{
					$save_array = array('signed_by','soinvoice_dt','top','tax_kurs','currency_kurs','notes');
					if($model->save($save_array)) 
					{
						if($model->is_down_payment==1)
						{
							$this->insertSoInvoiceDetail($model);
						}
						Yii::app()->user->setFlash('success', "Update Successfully");
						//$this->redirect(array('view','id'=>$model->soinvoice_cd));
					}
				}//end if valid
			}//end if model->validate

		}//end if isset

		$this->render('update',array(
			'modelSoInvoice'		=> $model,
			'modelSoInvoiceDO'		=> $modelSOInvoiceDO,
			'modelSoInvoiceDetail'	=> $modelSOInvoiceDetail
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	
	private function freeCompanyFp($soinvoice_cd)
	{
		//free serifp
		$query	= "UPDATE tdpcompanyfp SET soinvoice_cd = NULL, assigned_dt = NULL ";
		$query .= "WHERE soinvoice_cd = '$soinvoice_cd'";
		
		echo "Query ".$query."<br/>";
		
		DAO::executeSql($query);
	}
	
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			$resp  = $model->isCanDeletedOrModified();
				
			if(!$resp['status'])
				throw new CHttpException('',$resp['message']);
			
			$so_cd = $model->so_cd;
			
			$model->status = Status::SO_STATUS_VOID;
			$model->save(array('status'));
			
			$this->freeCompanyFp($id);
			
			if($model->is_down_payment==1)
			{
				$query	= "SELECT remaining_dp FROM tdpso WHERE so_cd = '$so_cd'";
				$remaining_dp = DAO::queryRowSql($query);
				$remain = $remaining_dp['remaining_dp'];
				$remain -= $model->payment_amount;
				
				$query = "UPDATE tdpso SET remaining_dp = ".$remain." WHERE so_cd = '$so_cd'";
				DAO::executeSql($query);
			}//end if isdp = 1 
			
			
			$listSoInvDo  = Soinvoicedo::model()->findAll('soinvoice_cd = :soinvoice_cd',
							array(':soinvoice_cd'=>$id));
			foreach($listSoInvDo as $modelSoInvDo)
			{
				$modelDo = Devo::model()->findByPk($modelSoInvDo->do_cd);
				$modelDo->updateDepedencyStatus('invoice_status');
			}
			
			// AH: Change status header
			$modelSo = So::model()->findByPk($so_cd);
			$modelSo->updateDepedencyStatus('invoice_status');
				
			
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
		$model=new Soinvoice('search');
		$model->unsetAttributes();  // clear any default values
		
		$modelClient = new Client('search');
		$modelClient->unsetAttributes();
		
		if(isset($_GET['Soinvoice']))
		{
			$model->attributes=$_GET['Soinvoice'];
			$model->validate(array('soinvoice_dt', 'create_dt', 'update_dt'));
		}
		$client = Client::model()->find("client_cd = '".$model->client_cd."'");
		
		$this->render('index',array(
			'model'=>$model,
			'modelClient'=>$modelClient
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Soinvoice::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='soinvoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	private function manageCompanyFp($soinvoice_cd, $company_id)
	{
		$date = date('Y-m-d');
		//echo "date ".$date."<br/>";
		
		$query	= "SELECT * FROM tdpcompanyfp cfp, tdpcompanyfpgroup cfpg ";
		$query	.= "WHERE cfp.companyfpgroup_id = cfpg.companyfpgroup_id ";
		$query	.= "AND soinvoice_cd IS NULL ";
		$query	.= "AND status = 1 ";
		$query	.= "AND cfpg.company_id = $company_id ";
		$query	.= "ORDER BY  tdpcompanyfp_ID ASC ";
		$query	.= "LIMIT 1";
		
		//echo "query = ".$query."<br/>";
		$result	= DAO::queryRowSql($query);
		
		$tdpcompanyfp_id = $result['tdpcompanyfp_id'];
		//echo "tdpcompanyfp_id ".$tdpcompanyfp_id."<br/> soinvoice_cd = ".$soinvoice_cd."<br/>";
		
		$query	= "UPDATE tdpcompanyfp ";
		$query	.= "SET soinvoice_cd = '$soinvoice_cd', assigned_dt = '$date' ";
		$query	.= "WHERE tdpcompanyfp_id = $tdpcompanyfp_id";
		
		//echo "query ".$query."<br/>";
		
		DAO::executeSql($query);
	}

	private function getCompanyFpInvoice($soinvoice_cd)
	{
		$query = "SELECT * FROM tdpcompanyfp WHERE soinvoice_cd = '$soinvoice_cd'";
		
		$result = DAO::queryRowSql($query);
		
		//echo "get company fp ".$result['soinvoice_cd']."<br/> ";	
		return $result['soinvoice_cd'];
	}
	
	private function getCompanySeriFp($soinvoice_cd, $company_id)
	{
		$query = "SELECT * FROM tdpcompanyfp WHERE soinvoice_cd = '$soinvoice_cd' AND company_id = '$company_id'";
		
		$result = DAO::queryRowSql($query);
		
		//echo "get company fp ".$result['soinvoice_cd']."<br/> ";	
		return $result['serifp'];
	}
	
	private function checkSoinvoicecd($modelInvoice, $soinvoice_cd, $company_id)
	{
		$result = $this->getCompanyFpInvoice($soinvoice_cd,$company_id);
		
		//echo "result ".$result."<br/> soinvoice_cd ".$soinvoice_cd."<br/>";

		if($result==""||$result==null)
		{
			//soinvoice_cd has not registered in company fp
			//echo "di dalam if, result ".$result."<br/>";
			$this->manageCompanyFp($soinvoice_cd,$company_id);
		}
		
		$result = $this->getCompanySeriFp($soinvoice_cd, $company_id);
		$serifp = $modelInvoice->prefix_fp.".".$result;
		return $serifp;
	}
	
	public function actionPreviewHTML()
	{
		$id = $_REQUEST['id'];
		$soInvoice = Soinvoice::model()->find("soinvoice_cd = '".$id."'");
		$soInvoiceTax = Soinvoicetax::model()->findAll("soinvoice_cd = '".$id."'");
		$soInvoiceDetail = DAO::queryRowSql("SELECT SUM(discount_amt) AS discount_amt FROM tdpsoinvoicedetail WHERE soinvoice_cd = '".$id."'");
		$so = So::model()->find("so_cd = '".$soInvoice->so_cd."'");
		$devo = Soinvoicedo::model()->findAll("soinvoice_cd = '".$soInvoice->soinvoice_cd."'");
		$itemdata = DAO::queryAllSql("SELECT *,tdpitem.item_cd,SUM(total_price)AS 'Total' FROM tdpsoinvoicedetail,tdpitem Where soinvoice_cd = '".$id."'"."AND tdpsoinvoicedetail.item_cd = tdpitem.item_cd GROUP BY tdpitem.item_cd");
		$client = Client::model()->find("client_cd = '".$soInvoice->client_cd."'");
		$employee = Employee::model()->find("employee_cd = '".$soInvoice->signed_by."'");
	
		$bank = Companybank::model()->find('company_id=:company_id AND currency=:currency_cd AND is_tax=:is_tax',
				array(':company_id'=>$soInvoice->company_id,':currency_cd'=>$soInvoice->currency_cd,':is_tax'=>$soInvoice->is_tax));
	
		$company = Company::model()->find("company_id = '".$soInvoice->company_id."'");
		$symbol = Currency::model()->find("currency_cd='".$soInvoice->currency_cd."'");
		$this->renderPartial('_preview',array('soinvoice'=>$soInvoice,'so'=>$so,'devo'=>$devo,'itemdata'=>$itemdata,'client'=>$client, 'soinvoicetax'=>$soInvoiceTax, 'employee'=>$employee, 'bank'=>$bank, 'company'=>$company, 'symbol'=>$symbol, 'soinvoicedetail'=>$soInvoiceDetail,'client'=>$client));
	}
	
	public function actionPrintFakturPajakHTML()
	{
		//$so_id = $_REQUEST['so_id'];
		$id = $_REQUEST['id'];
		$modelInvoice = Soinvoice::model()->findByPk($id);
		$modelH =So::model()->findByPk($modelInvoice->so_cd);
		$modelCompany= Company::model()->findByPk($modelH->company_id);
		$modelClient= Client::model()->findByPk($modelH->client_cd);
		$modelD = Soinvoicedetail::model()->findAll("soinvoice_cd=:soinvoice_cd",array(':soinvoice_cd' => $id));
		
		//ER
		
		/*$query	= "SELECT * FROM tdpcompanyfp cfp, tdpcompanyfpgroup cfpg ";
		$query	.= "WHERE cfp.companyfpgroup_id = cfpg.companyfpgroup_id ";
		$query	.= "AND soinvoice_cd IS NULL ";
		$query	.= "AND status = 1 ";
		$query	.= "AND cfpg.company_id = ".$modelH->company_id." ";
		$query	.= "ORDER BY  tdpcompanyfp_ID ASC ";
		$query	.= "LIMIT 1";
		
		$result	= DAO::queryRowSql($query);*/
		
		$result = $this->getCompanyFpInvoice($modelInvoice->soinvoice_cd);
		
		if(!empty($result))
		{
			$serifp = $this->checkSoinvoicecd($modelInvoice, $modelInvoice->soinvoice_cd, $modelH->company_id);
		}
		else
		{
			$query	= "SELECT * FROM tdpcompanyfp cfp, tdpcompanyfpgroup cfpg ";
			$query	.= "WHERE cfp.companyfpgroup_id = cfpg.companyfpgroup_id ";
			$query	.= "AND soinvoice_cd IS NULL ";
			$query	.= "AND status = 1 ";
			$query	.= "AND cfpg.company_id = ".$modelH->company_id." ";
			$query	.= "ORDER BY  tdpcompanyfp_ID ASC ";
			$query	.= "LIMIT 1";
			
			$result	= DAO::queryRowSql($query);
			if(!empty($result))
			{
				$serifp = $this->checkSoinvoicecd($modelInvoice, $modelInvoice->soinvoice_cd, $modelH->company_id);
			}
			else 
			{
				$serifp = "Nomor seri faktur pajak tidak tersedia.";
				throw new CHttpException($serifp);
			}
		}
		
		if($modelInvoice->currency_cd=='IDR')
		{
			$this->renderPartial('printFakturPajak',array(
			'model'=>$modelInvoice ,
			'modelInvoice'=>$modelInvoice ,
			'modelH'=>$modelH,
			'modelD'=>$modelD,
			'modelCompany'=>$modelCompany,
			'modelClient'=>$modelClient,
			//ER
			'serifp'=>$serifp
		));//end render
		}//end if
		else
		{
			$this->renderPartial('_printFakturNonIDR',array(
			'model'=>$modelInvoice ,
			'modelInvoice'=>$modelInvoice ,
			'modelH'=>$modelH,
			'modelD'=>$modelD,
			'modelCompany'=>$modelCompany,
			'modelClient'=>$modelClient,
			//ER
			'serifp'=>$serifp
		));//end render
		}//end else
	}
	public function actionPreview($id)
	{
		$soInvoice 			= Soinvoice::model()->findByPk($id);
		$so 				= So::model()->findByPk($soInvoice->so_cd);
	
	
		$modelCurrency 		= Currency::model()->find("currency_cd='".$soInvoice->currency_cd."'");
		$query				= "SELECT ' ' AS rwnum ,CONCAT_WS('#',i.item_name, i.item_desc), i.product_number, CONCAT_WS(' ',soi.qty,i.itemmeasurement_name), '$modelCurrency->symbol' AS sym1, soi.price, '$modelCurrency->symbol' AS sym2, total_price ";
		$query 			   .= "FROM tdpitem i JOIN tdpsoinvoicedetail soi ";
		$query 			   .= "ON soi.soinvoice_cd = '$id' AND i.item_cd = soi.item_cd ";
		$itemdata 			= DAO::queryAllSql($query);
	
		$client 			= Client::model()->find("client_cd = '".$soInvoice->client_cd."'");
		$employee			= Employee::model()->find("employee_cd = '".$soInvoice->signed_by."'");
	
		$company 			= Company::model()->find("company_id = '".$soInvoice->company_id."'");
	
		$modelList		    = Soinvoicedetail::model()->findAll('soinvoice_cd=:soinvoice_cd',array(':soinvoice_cd'=>$soInvoice->soinvoice_cd));
	
		$objExcelReporting = new ExcelReporting();
		$objExcelReporting->init();
	
		$template_path 		= Yii::app()->basePath.'/excel-template/';
		$template_file_type = 'Excel2007';
		$template_file_path = '';
	
		if($soInvoice->is_tax == Status::IS_STATUS_YES){
			if($soInvoice->is_down_payment == Status::IS_STATUS_YES)
			{
				$template_file_path = $template_path.'soinvoice_tax_dp.xlsx';
			}
			else
			{
				$template_file_path = $template_path.'soinvoice_tax_ndp.xlsx';
			}
				$objExcelReporting->loadTemplate($template_file_type,$template_file_path);
				$objExcelReporting->renderCell('B2',$company->company_name);
				$objExcelReporting->renderCellWNL('B3',"{$company->address}");
				$objExcelReporting->renderCell('B5','Telp : '.$company->phone.' Fax :'.$company->fax);	
		}else{
			if($soInvoice->is_down_payment == Status::IS_STATUS_YES)
				$template_file_path = $template_path.'soinvoice_ntax_dp.xlsx';
			else
				$template_file_path = $template_path.'soinvoice_ntax_ndp.xlsx';
			$objExcelReporting->loadTemplate($template_file_type,$template_file_path);
		}
	
			
		//$objExcelReporting->loadTemplate($template_file_type,$template_file_path);
	
		// AH: <BEGIN HEADER>
	
		$objExcelReporting->renderCell('E8',$client->client_name);
		$objExcelReporting->renderCellWNL('E9',"{$so->invoiceAddress->address}");
		$objExcelReporting->renderCell('E12','Telp : '.$so->invoiceAddress->phone.' Fax: '.$so->invoiceAddress->fax);
		$objExcelReporting->renderCell('E13',$so->invoiceContact->contact_name);
	
		$objExcelReporting->renderCell('M8',$soInvoice->soinvoice_cd);
		$objExcelReporting->renderCell('M9',Yii::app()->format->formatDate($soInvoice->soinvoice_dt));
		$objExcelReporting->renderCell('B17',$so->so_cd);
		
		if($soInvoice->is_down_payment == Status::IS_STATUS_NO){
			$modelDevo 	= Soinvoicedo::model()->find("soinvoice_cd = '".$soInvoice->soinvoice_cd."'");
			$objExcelReporting->renderCell('G17',$modelDevo->do_cd);
		}
		$objExcelReporting->renderCell('L17',$so->client_po_no);
		$objExcelReporting->renderCell('N19','Total '.$soInvoice->currency_cd);
		
		// AH: <END HEADER>
	
		$tempRowPosAdjus = 0;
		if($soInvoice->is_down_payment == Status::IS_STATUS_YES){
			$tempRowPosAdjus = 1;
			$objExcelReporting->renderCell('B20','DP '.$soInvoice->payment_percent.' % atas ');
		}
	
		$arrColumnPos = array('B','C-H','I','J','K','L-M','N','O');
		$objExcelReporting->renderTableDAO('B',(20+$tempRowPosAdjus),$itemdata,$arrColumnPos);
	
		//AH: <BEGIN FOOTER>
	
		$rowPos = $objExcelReporting->getLastDetailRow();
	
	
	
	
		// AH: bank
		$modelBank = Companybank::model()->find('company_id=:company_id AND currency=:currency_cd AND is_tax=:is_tax',
				array(':company_id'=>$soInvoice->company_id,':currency_cd'=>$soInvoice->currency_cd,':is_tax'=>$soInvoice->is_tax));
	
		$tempRowPos = $rowPos+2;
		$objExcelReporting->renderCell('B'.$tempRowPos,$modelBank->bank_name);
		$tempRowPos++;
		$objExcelReporting->renderCell('B'.$tempRowPos,'A/C :'.$modelBank->account_no);
		$tempRowPos++;
		$objExcelReporting->renderCell('B'.$tempRowPos,'A/N :'.$modelBank->beneficiary_name);
	
	
		$tempRowPosAdjus = 0;
		if($soInvoice->is_tax == Status::IS_STATUS_NO)
			$tempRowPosAdjus = -2;
	
		// AH: due date
		$tempRowPos = $rowPos+10;
		$objExcelReporting->renderCell('E'.($tempRowPos+$tempRowPosAdjus),Yii::app()->format->formatDate($soInvoice->due_date));
	
		// AH: employee signed
		$tempRowPos = $rowPos+17;
		$objExcelReporting->renderCell('M'.($tempRowPos+$tempRowPosAdjus),$employee->employee_name);
	
	
		// AH: fix formatting for calculation please refer to [secret] mantis
		$query			 = "SELECT SUM(total_price) AS total_price, SUM(discount_amt) AS discount_amt ";
		$query			.=	"FROM tdpsoinvoicedetail WHERE soinvoice_cd = '".$id."'";
		$itemCalcData 	 = DAO::queryRowSql($query);
	
		$discountAmount  = $itemCalcData['discount_amt'];
		$totalPrice 	 = $itemCalcData['total_price'];
	
		$ppn   = 0;
		$pph23 = 0;
	
		if($soInvoice->is_tax == Status::IS_STATUS_YES)
		{
			$modelSoInvoiceTaxPPN 	= Soinvoicetax::model()->find("soinvoice_cd = '".$id."' AND tax_cd = 'PPN'");
			if($modelSoInvoiceTaxPPN != NULL)
				$ppn =  $modelSoInvoiceTaxPPN->tax_amount;
				
				
			$modelSoInvoiceTaxPPH23 	= Soinvoicetax::model()->find("soinvoice_cd = '".$id."' AND tax_cd = 'PPH23'");
			if($modelSoInvoiceTaxPPH23 != NULL)
				$pph23 =  $modelSoInvoiceTaxPPH23->tax_amount;
				
			$objExcelReporting->renderCell('C1',$ppn);
			$objExcelReporting->renderCell('D1',$pph23);
		}
	
		if($soInvoice->is_down_payment == Status::IS_STATUS_YES){
			$percent		= $soInvoice->payment_percent  / 100;
			$totalPrice     = $percent * $totalPrice;
			$discountAmount = $percent * $discountAmount;
				
			$tempRowPos 	= $rowPos+1;
		}
	
			
		$totalMustPay = $totalPrice - $discountAmount + $ppn + $pph23;
	
		if($soInvoice->is_down_payment == Status::IS_STATUS_NO)
			$totalMustPay  -= $soInvoice->used_dp;
		if($soInvoice->is_down_payment == Status::IS_STATUS_YES)
			$totalMustPay  = $soInvoice->payment_amount;
	
		$objExcelReporting->renderCell('A1',$totalPrice);
		$objExcelReporting->renderCell('B1',$discountAmount);
		$objExcelReporting->renderCell('E1',$soInvoice->used_dp);
		$objExcelReporting->renderCell('F1',$totalMustPay);
		$objExcelReporting->renderCell('P1',$modelCurrency->symbol);
	
		$total = Yii::app()->format->formatMoneyTerbilang($totalMustPay,$modelCurrency->currency_name);
		$tempRowPos = $rowPos+7;
		$objExcelReporting->renderCell('B'.($tempRowPos+$tempRowPosAdjus),'Amount In Word : '.$total);
	
		// AH: <END FOOTER>
	
	
		// AH: downloading file
	
		$filename =  str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $soInvoice->soinvoice_cd);
		ob_end_clean();
		ob_start();
	
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		// $objWriter = PHPExcel_IOFactory::createWriter($objExcelReporting->oPHPExcel,$template_file_type);
		$objWriter->save('php://output');
	}
	

	public function actionPrintFakturPajak($id)
	{
	set_time_limit(900000);
		$id = $_REQUEST['id'];
		$itemdata;
		$itemdatadp;
		$modelInvoice = Soinvoice::model()->findByPk($id);
		$modelH =So::model()->findByPk($modelInvoice->so_cd);
		$modelCompany= Company::model()->findByPk($modelH->company_id);
		$modelClient= Client::model()->findByPk($modelInvoice->client_cd);
		//$modelD = Soinvoicedetail::model()->findAll("soinvoice_cd=:soinvoice_cd",array(':soinvoice_cd' => $id));
		$sign=Employee::model()->findByPk($modelInvoice->signed_by);
		$format = new Formatter;
		
		$query = "SELECT SUM(discount_amt) AS discount_amt FROM tdpsoinvoicedetail WHERE soinvoice_cd = '".$modelInvoice->soinvoice_cd."'";
		$res = DAO::queryRowSql($query);
		$discount = $res['discount_amt'];
		
		$query = "SELECT SUM(payment_percent) as payment_percent FROM tdpsoinvoice where so_cd = '$modelInvoice->so_cd' AND is_down_payment = 1 AND status = ".Status::CORE_STATUS_OPEN;
		$result = DAO::queryRowSql($query);			
		$total_percent = $result['payment_percent'];
		$used_dp = ($total_percent/100)*($modelH->subtotal_sell - $modelH->subtotal_sell_disc);
				
		$result = $this->getCompanyFpInvoice($modelInvoice->soinvoice_cd);
		
		if(!empty($result))
		{
			$serifp = $this->checkSoinvoicecd($modelInvoice, $modelInvoice->soinvoice_cd, $modelH->company_id);
		}
		else
		{
			$query	= "SELECT * FROM tdpcompanyfp cfp, tdpcompanyfpgroup cfpg ";
			$query	.= "WHERE cfp.companyfpgroup_id = cfpg.companyfpgroup_id ";
			$query	.= "AND soinvoice_cd IS NULL ";
			$query	.= "AND status = 1 ";
			$query	.= "AND cfpg.company_id = ".$modelH->company_id." ";
			$query	.= "ORDER BY  tdpcompanyfp_ID ASC ";
			$query	.= "LIMIT 1";
			
			$result	= DAO::queryRowSql($query);
			if(!empty($result))
			{
				$serifp = $this->checkSoinvoicecd($modelInvoice, $modelInvoice->soinvoice_cd, $modelH->company_id);
			}
			else 
			{
				$serifp = "Nomor seri faktur pajak tidak tersedia.";
				throw new CHttpException($serifp);
			}
		}
		
		$objExcelReporting = new ExcelReporting();
		$objExcelReporting->init();
		
		if($modelInvoice->is_down_payment==1)
		{
			//query nilai total_price dikalikan persen pembayaran
			$query		= "SELECT ' ' AS rwnum ,CONCAT(i.item_name,'\n(',soi.qty, i.itemmeasurement_name,')'), ".($modelInvoice->payment_percent/100)."*soi.total_price ";
			$query 		.= "FROM tdpitem i JOIN tdpsoinvoicedetail soi "; 
			$query 		.= "ON soi.soinvoice_cd = '$id' AND i.item_cd = soi.item_cd ";
			$itemdatadp = DAO::queryAllSql($query);
		}//end if modelInvoice
		else
		{
			$query		= "SELECT ' ' AS rwnum ,CONCAT(i.item_name,'\n(',soi.qty, i.itemmeasurement_name,')'), soi.total_price ";
			$query 		.= "FROM tdpitem i JOIN tdpsoinvoicedetail soi "; 
			$query 		.= "ON soi.soinvoice_cd = '$id' AND i.item_cd = soi.item_cd ";
			$itemdata 	= DAO::queryAllSql($query);
		}//end else
		
		if($modelInvoice->currency_cd=='IDR')
		{
			if($modelInvoice->is_down_payment==1)
			{
				$template_file_name = "faktur_idr_dp.xlsx";
				$template_path 		= Yii::app()->basePath.'/excel-template/';
				$template_file_path = $template_path.$template_file_name;
				$template_file_type = 'Excel2007';
				$objExcelReporting->loadTemplate($template_file_type,$template_file_path);
				$objExcelReporting->renderTableDAO('B',15,$itemdatadp,array('B-C','D-J','K'));
			}//end if modelInvoice
			else
			{
				$template_file_name = "faktur_idr_non_dp.xlsx";
				$template_path 		= Yii::app()->basePath.'/excel-template/';
				$template_file_path = $template_path.$template_file_name;
				$template_file_type = 'Excel2007';
				$objExcelReporting->loadTemplate($template_file_type,$template_file_path);
				$objExcelReporting->renderTableDAO('B',15,$itemdata,array('B-C','D-J','K'));
			}//end else
		}//end if
		else
		{
			if($modelInvoice->is_down_payment==1)
			{
				$template_file_name = "faktur_non_idr_dp.xlsx";
				$template_path 		= Yii::app()->basePath.'/excel-template/';
				$template_file_path = $template_path.$template_file_name;
				$template_file_type = 'Excel2007';
				$objExcelReporting->loadTemplate($template_file_type,$template_file_path);
				$objExcelReporting->renderCell('B15',"Dp ".$modelInvoice->payment_percent."%");
				$objExcelReporting->renderTableDAO('B',16,$itemdatadp,array('B-C','D-J','K'));
			}//end if modelInvoice
			else
			{
				$template_file_name = "faktur_non_idr_non_dp.xlsx";
				$template_path 		= Yii::app()->basePath.'/excel-template/';
				$template_file_path = $template_path.$template_file_name;
				$template_file_type = 'Excel2007';
				
				$objExcelReporting->loadTemplate($template_file_type,$template_file_path);
				$objExcelReporting->renderTableDAO('B',16,$itemdata,array('B-C','D-J','K'));
			}//end else

		}//end else

		//header
		$objExcelReporting->renderCell('F2', $modelInvoice->tax_kurs);
		$objExcelReporting->renderCell('A2',$modelInvoice->payment_percent);
		$objExcelReporting->renderCell('B2',$total_percent);
		
		$objExcelReporting->renderCell('H5',$serifp);
		if(!empty($modelCompany->npwp_name)){ $objExcelReporting->renderCell('G7',$modelCompany->npwp_name); }else{$objExcelReporting->renderCell('G7',$modelCompany->company_name);}
		$objExcelReporting->renderCellWNL('G8',$modelCompany->npwp_address);
		$objExcelReporting->renderCell('G9',$modelCompany->npwp_no);
		
		if(!empty($modelCompany->npwp_name)){ $objExcelReporting->renderCell('G11',$modelClient->npwp_name); }else{$objExcelReporting->renderCell('G11',$modelClient->client_name);}
		$objExcelReporting->renderCellWNL('G12',$modelClient->npwp_address);
		$objExcelReporting->renderCell('G13',$modelClient->npwp_no);
		//end header
		
		//footer
		$rowPos = $objExcelReporting->getLastDetailRow();
		$coor = $rowPos+2; //diskon
		$tempCoor = $rowPos+1; //subtotal
		//$objExcelReporting->renderCell('K'.$coor++,$discount);
		$objExcelReporting->renderCell('D2',$discount);
		if($modelInvoice->is_down_payment==0)
		{
			//$objExcelReporting->renderCell('K'.$coor++,$used_dp);
			$objExcelReporting->renderCell('E2',$used_dp);
		}
		$coor +=2;
		$objExcelReporting->renderCell('K'.$coor++,"=K".$tempCoor++."-K".$tempCoor++."-K".$tempCoor);
		
		$newCoor = $coor + 4;
		$objExcelReporting->renderCell('J'.$newCoor,"Jakarta, ".$format->formatDate($modelInvoice->soinvoice_dt));
		$newCoor += 4;
		$objExcelReporting->renderCell('J'.$newCoor,$sign->employee_name);
		
		if($modelInvoice->currency_cd!='IDR')
		{
			$newCoor += 2;
			$objExcelReporting->renderCell('B'.$newCoor,"Kurs : Rp.".$modelInvoice->tax_kurs."/".$modelInvoice->currency_cd);
			$newCoor += 1;
			$objExcelReporting->renderCell('B'.$newCoor,"Berdasarkan KMK NO.".$modelInvoice->kmk_no." Tanggal ".$format->formatDate($modelInvoice->kmk_date));
		}
		
		$filename =  str_replace(array('\\','/',':','?','*','"','<','>','|'), '_', $modelInvoice->soinvoice_cd);
		ob_end_clean();
		ob_start();
	
		//header('Content-Type: application/vnd.ms-excel'); //excel 97-2003
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//excel 2007
		header('Content-Disposition: attachment;filename="FP_'.$filename.'"');
		header('Cache-Control: max-age=0');
		// $objWriter = PHPExcel_IOFactory::createWriter($objExcelReporting->oPHPExcel,$template_file_type);
		$objWriter->save('php://output');
		
	}
	
}
