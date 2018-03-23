<?php
$this->breadcrumbs=array(
	'Soinvoices'=>array('index'),
	$model->soinvoice_cd,
);
?>

<?php Helper::showFlash(); ?>
<?php 
if($model->status==Status::CORE_STATUS_OPEN && $model->payment_status==Status::DEPEDENCY_STATUS_NOTYET )
{
	if($model->is_tax==1)
	{
		$buttonBar = new ButtonBar('{list} {create} {update} {delete} {printSoInvoice} {printFp}');
	}
	else 
	{
		$buttonBar = new ButtonBar('{list} {create} {update} {delete} {printSoInvoice}');
	}
	$buttonBar->printSoInvoiceUrl = Yii::app()->createUrl('sales/soinvoice/preview',array('id'=>$model->soinvoice_cd));
	$buttonBar->listUrl = array('index');
	$buttonBar->createUrl = array('create');
	$buttonBar->updateUrl = array('update', 'id'=>$model->soinvoice_cd);
	$buttonBar->printFpUrl = Yii::app()->createUrl('sales/soinvoice/printFakturPajak',array('id'=>$model->soinvoice_cd));
	$buttonBar->printSoInvoiceLinkHtmlOptions= array('target'=>'_blank', '');
	$buttonBar->printFpLinkHtmlOptions=array('target'=>'_blank');
	$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->soinvoice_cd),'confirm'=>'Are you sure you want to delete this item?');
	$buttonBar->render();
}
else
{
	$buttonBar = new ButtonBar('{list} {create}');
	$buttonBar->listUrl = array('index');
	$buttonBar->createUrl = array('create');
	//$buttonBar->printFpUrl = Yii::app()->createUrl('sales/soinvoice/printFakturPajak',array('id'=>$model->soinvoice_cd));
	//$buttonBar->printSoInvoiceUrl = Yii::app()->createUrl('sales/soinvoice/preview',array('id'=>$model->soinvoice_cd));
	//$buttonBar->printSoInvoiceLinkHtmlOptions= array('target'=>'_blank');
	//$buttonBar->printFpLinkHtmlOptions=array('target'=>'_blank');
	$buttonBar->render();
}
?>

<h1>
<?php 
	if($model->is_down_payment==1)
	{
		echo "Proforma Invoice";
	}
	else 
	{
		echo "Invoice";
	}
?>
</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'soinvoice_cd',
		'so_cd',		
		array('name'=>'is_down_payment','value'=>Status::$is_status[$model->is_down_payment]),
		array('name'=>'is_tax','value'=>Status::$is_status[$model->is_tax]),
		'top',
		array('name'=>'soinvoice_dt', 'type'=>'date'),
		array('name'=>'due_date', 'type'=>'date'),
	),
)); ?>

<br/> <br />
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('label'=>'Invoice Contact', 'value'=>$model->invoiceContact->contact_name." - ".$model->invoiceContact->position." / ".$model->invoiceContact->phone_no),
		array('label'=>'Invoice Address', 'value'=>$model->invoiceAddress->address),
	),
)); ?>

<br/ ><br />

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'signed_by','value'=>$model->employee->employee_name),
		'company.company_name',
		'client.client_name',
		array('name'=>'prefix_fp','value'=>$model->prefix_fp.'-'.((!empty($model->prefix_fp))? PrefixFp::$prefixFaktur[$model->prefix_fp]: "")),
		array('label'=>'Invoice File','type'=>'raw','value'=>(($model->invoice_file_name == null)? '' :
				 CHtml::link(CHtml::encode($model->invoice_file_name), FileUpload::getHttpPath($model->soinvoice_cd, FileUpload::CLIENT_SOINVOICE_PATH) )) ),
		array('label'=>'FP File','type'=>'raw','value'=>(($model->fp_file_name == null)? '' :
				 CHtml::link(CHtml::encode($model->fp_file_name), FileUpload::getHttpPath($model->soinvoice_cd, FileUpload::CLIENT_SOINVOICE_PATH) )) ),		 
	),
)); ?>
<br/ ><br />

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array('name'=>'subtotal_price','value'=>$model->currency_cd." ".number_format($model->subtotal_price, 2, ".", ",")),
		array('name'=>'subtotal_disc','value'=>$model->currency_cd." ".number_format($model->subtotal_disc, 2, ".", ",")),
		array('name'=>'subtotal_tax','value'=>$model->currency_cd." ".number_format($model->subtotal_tax, 2, ".", ",")),
		array('name'=>'grandtotal_price','value'=>$model->currency_cd." ".number_format($model->grandtotal_price, 2, ".", ",")),
	),
)); ?>
<br /><br />

<?php if($model->is_down_payment==0): ?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array('name'=>'used_dp','value'=>$model->currency_cd." ".number_format($model->used_dp, 2, ".", ",")),
		array('name'=>'payment_amount','value'=>$model->currency_cd." ".number_format($model->payment_amount, 2, ".", ",")),
		array('name'=>'currency_kurs','value'=>number_format($model->currency_kurs, 2, ".", ",")),
		array('name'=>'tax_kurs','type'=>'number'),
		array('name'=>'kmk_no'),
		array('name'=>'kmk_date','type'=>'date')
	),
)); ?>
<?php elseif($model->is_down_payment==1):?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'payment_percent',
		array('name'=>'payment_amount','value'=>$model->currency_cd." ".number_format($model->payment_amount, 2, ".", ",")),
		array('name'=>'currency_kurs','value'=>number_format($model->currency_kurs, 2, ".", ",")),
		array('name'=>'tax_kurs','type'=>'number'),
		array('name'=>'kmk_no'),
		array('name'=>'kmk_date','type'=>'date')
	),
)); ?>
<?php endif;?>
<br /><br />

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array('name'=>'status','value'=>Status::$core_status[$model->status]),
		array('name'=>'payment_status','value'=>Status::$depedency_status[$model->payment_status]),
		'notes',
	),
)); ?>
<br /><br />

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'create_by','value'=>$model->create->employee_name),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'update_by','value'=>$model->update->employee_name),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>
<br /><br />

<?php Helper::registerNumberField('.tnumber'); ?>
<?php if($modelSoInvoice->is_down_payment==0):?>
<?php echo $this->renderPartial('_formdetailview', array('model'=>$modelSoInvoiceDO,'soinvoice_cd'=>$modelSoInvoice->soinvoice_cd,'so_cd'=>$modelSoInvoice->so_cd)) ?>
<?php endif;?>
<?php echo $this->renderPartial('_griditemdetail', array('model'=>$modelSoInvoiceDetail,'item_code'=>$modelSoInvoiceDetail->item_cd)); ?>
