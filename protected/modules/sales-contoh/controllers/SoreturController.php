<?php

class SoreturController extends Controller
{
	public $layout='//layouts/column1';
	
	public function accessRules()
	{
		return parent::getArrayAccessRules();
	}
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$mDetail = new Soreturdetail('search');
		$mDetail->soretur_cd = $model->soretur_cd;
		
		$this->render('view',array(
			'model'=>$model,
			'mDetail'=>$mDetail,
		));
	}
	
	public function actionAjxValidateDetail()
	{
		if(isset($_POST['qty_retur']) && isset($_POST['item_cd']) && isset($_POST['Soretur'])):
			$soretur_cd = $_POST['Soretur']['soretur_cd'];
			$do_cd 		= $_POST['Soretur']['do_cd'];
			
			$resp	 	= NULL;
			$resp_sccss	= NULL;
			
			for($err_pos = 0;$err_pos < count($_POST['item_cd']);$err_pos++)
			{
				$qty_retur		= $_POST['qty_retur'][$err_pos];
				$item_cd	 	= $_POST['item_cd'][$err_pos];
				
				$mDetail 			   = new Rrdetail();
				$mDetail->qty_retur = $qty_retur;
				
				$iStockChecking	= -1;
				$mStockChecking	= Devodetail::model()->find('do_cd=:do_cd AND item_cd=:item_cd',
										array(':do_cd' => $do_cd,':item_cd'=>$item_cd));
				$mStockChecking->qty_retur  = Devodetail::getQtyRetur($do_cd,$item_cd);
				$mSRdetail 		= Soreturdetail::model()->find('soretur_cd=:soretur_cd AND item_cd=:item_cd',
									array(':soretur_cd'=>$soretur_cd,':item_cd'=>$item_cd));
				
				if($mSRdetail == NULL)
					$iStockChecking	= $mStockChecking->qty - $mStockChecking->qty_retur;
				else
					$iStockChecking	= $mStockChecking->qty - ( $mStockChecking->qty_retur - $mSRdetail->qty);
					
				if(!$mDetail->validate(array('qty_retur')))
					$resp[]  = array( 'err_index'=>$err_pos,
							'err_desc' =>$mDetail->getError('qty_retur'));
				else if($qty_retur < 0)
					$resp[]  = array( 'err_index'=>$err_pos,
							'err_desc' =>'Qty Retur must >= 0');
				else if($qty_retur > $iStockChecking)
					$resp[]  = array( 'err_index'=>$err_pos,
							'err_desc' =>'Quantity Retur ('.$qty_retur.') must less than  ('.$iStockChecking.') ');
				else if($qty_retur > 0 || $mSRdetail != NULL )
					$resp_sccss[] = $err_pos;
				
			}
			
			if($resp == NULL)
			{
				$mSRH = Soretur::model()->findByPk($soretur_cd);
				$mDOH = Devo::model()->findByPk($mSRH->do_cd);
				
				foreach ($resp_sccss as $idx_sccs)
				{
					$qty_retur 		  = $_POST['qty_retur'][$idx_sccs];
					$item_cd	  	  = $_POST['item_cd'][$idx_sccs];
					$received_notes   = $_POST['received_notes'][$idx_sccs];
					
					// AH: getting detail and preparing for update
					$mDetail = Soreturdetail::model()->find('soretur_cd=:soretur_cd AND item_cd=:item_cd',
								array(':soretur_cd'=>$soretur_cd,':item_cd'=>$item_cd));
					
					if($mDetail == NULL)
						$mDetail = new Soreturdetail();
					
					// saving the Soreturdetail by user input data
					$mDetail->soretur_cd  	= $soretur_cd;
					$mDetail->qty 			= $qty_retur;
					$mDetail->item_cd   	= $item_cd;
					$mDetail->notes			= $received_notes;
					
					if($qty_retur == 0)
						$mDetail->delete();
					else
						$mDetail->save(FALSE);
					
				}
				
				//AH: updating core status
				$mSRH->updateCoreStatus();
				$mDOH->updateDepedencyStatus('retur_status');
				
				echo json_encode(array('success'=>$this->createUrl('index')));					
			}
			else
				echo json_encode(array('errordetail'=>$resp));
		else:
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		endif;
	}
	
	public function actionAjxsoretur()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$do_cd 		 = $_POST['do_cd'];
			if(!empty($do_cd) )
			{
				$list = Vwdevo::model()->findAll(array(
							    "select"	=>"actor_cd",
							    "condition" =>"do_cd = '".$do_cd."'",
				));
					
				foreach($list as $object)
				{
					$client = Client::model()->find("client_cd='".$object->actor_cd."'");
					echo $object->actor_cd.' - '.$client->client_name;
					echo "<input type='hidden' name='Soretur[client_cd]' value='".$object->actor_cd."' />";
				}
			}
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function generatesoinvoice($do_cd)
	{
		if(Yii::app()->request->isPostRequest)
		{
			//$do_cd 		 = $_POST['do_cd'];
			if(!empty($do_cd) )
			{
				$list = Devo::model()->find(array(
							    "select"	=>"letter_cd",
							    "condition" =>"do_cd = '".$do_cd."'",
				));
				
				$letter_cd = $list->letter_cd;
				
				$list2 = Soinvoicedo::model()->findAll(array(
								    "select"	=>"t.soinvoice_cd as soinvoice_cd",
								    "join"		=>"JOIN tdpsoinvoice h on h.soinvoice_cd = t.soinvoice_cd",
								    "condition" =>"so_cd = '".$letter_cd."' AND status != ".Status::CORE_STATUS_VOID,
				));
					
				foreach($list2 as $object)
				{
					//echo "<option value='".$object->soinvoice_cd."'>".$object->soinvoice_cd."</option>";
					return $object->soinvoice_cd;
				}
			}
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionCreate()
	{
		$model 		= new Soretur();

		if(isset($_POST['Soretur']))
		{
			$model->attributes = $_POST['Soretur'];
			$model->soretur_cd 	= Pattern::generate('SO_RETUR');
			$model->soinvoice_cd = $this->generatesoinvoice($model->do_cd);
			
			if($model->validate())
			{
				Pattern::increase('SO_RETUR');
				
				// AH : Starting point status is void because detail not yet inserted
				$model->status = Status::CORE_STATUS_OPEN;	
				
				$model->save(FALSE);
				Yii::app()->user->setFlash('success', 'create successfully '.$model->soretur_cd);
				$this->redirect(array('update','id'=>$model->soretur_cd));
			}
			/*else
			{
				$model->soinvoice_cd = $_POST['Soretur']['soinvoice_cd'];
			}*/
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
		$modelHeader = $this->loadModel($id);
		$resp  = $modelHeader->isCanDeletedOrModified();
		
		if($resp['status'])
		{
			$modelDetail = new Devodetail('search');
			$modelDetail->unsetAttributes();
			$modelDetail->do_cd = $modelHeader->do_cd;
			
			$this->performAjaxValidation($modelHeader);
	
			if(isset($_POST['Soretur'])){
				$modelHeader->attributes=$_POST['Soretur'];
				if($modelHeader->save())
					$this->redirect(array('view','id'=>$modelHeader->soretur_cd));
			}
	
			$this->render('update',array(
				'modelHeader'=>$modelHeader,
				'modelDetail'=>$modelDetail
			));
		}else{
			throw new CHttpException('',$resp['message']);
		}
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
			$model = $this->loadModel($id); 
			$resp  = $model->isCanDeletedOrModified();
		
			if($resp['status'])
			{
				$model->status = Status::CORE_STATUS_VOID;
				$model->save(array('status'));
				
				/*$query = "UPDATE tdpdevodetail a LEFT JOIN tdpsoretur b ON a.do_cd = b.do_cd ";
				$query .= "LEFT JOIN tdpsoreturdetail c ON b.soretur_cd = c.soretur_cd AND a.item_cd = c.item_cd ";
				$query .= "SET qty_retur = qty_retur - c.qty ";
				$query .= "WHERE c.soretur_cd= '$id' AND a.do_cd='$model->do_cd'";
				
		
				$row 	= DAO::executeSql($query);*/
				
			}
			else
			{
				echo $resp['message'];
			}
			
			Devo::model()->findByPk($model->do_cd)->updateDepedencyStatus('retur_status');
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Soretur('search');
        $model->unsetAttributes(); // clear any default values
        if(isset($_GET['Soretur']))
		{
            $model->attributes=$_GET['Soretur'];
			$model->validate(array('create_dt','update_dt'));
		}
        $this->render('index',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Soretur the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Soretur::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Soretur $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='soretur-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionPreview()
	{
	 	$id = $_REQUEST['id'];
		$sor_h = Soretur::model()->find("soretur_cd = '".$id."'");
		$sor_d = Vwsoretur::model()->findAll("soretur_cd = '".$id."'");
		
		$do_h = Devo::model()->find("do_cd = '".$sor_h->do_cd."'");
		
		$soh = So::model()->find("so_cd = '".$do_h->letter_cd."'");
		$sod = Sodetail::model()->findAll("so_cd = '".$soh->so_cd."'");
		
		$soi = Soinvoice::model()->find("soinvoice_cd = '".$sor_h->soinvoice_cd."'");
		
		$company = Company::model()->find("company_id = ".$soh->company_id);
		
		$this->renderPartial('_preview',array('sor_h'=>$sor_h,'sor_d'=>$sor_d,'do_h'=>$do_h,'soh'=>$soh,'sod'=>$sod,'company'=>$company,'soi'=>$soi));
	}
}
