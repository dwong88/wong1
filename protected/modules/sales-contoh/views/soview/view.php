<?php
$this->breadcrumbs=array(
	'SO'=>array('index'),
	$model->so_cd,
);
?>

<?php Helper::showFlash(); ?>
<?php 
/*
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->so_cd);
if($model->status == 2)
{
	$buttonBar = new ButtonBar('{list} {create} {update} {print}');
	$buttonBar->listUrl = array('index');
	$buttonBar->createUrl = array('create');
	$buttonBar->updateUrl = array('update', 'id'=>$model->so_cd);
	$buttonBar->printUrl = Yii::app()->createUrl('sales/so/preview',array('id'=>$model->so_cd));
	$buttonBar->printLinkHtmlOptions= array('target'=>'_blank');
	$buttonBar->printLinkHtmlOptions= array('target'=>'_blank');
}
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->so_cd),'confirm'=>'Are you sure you want to delete this item?');
*/
if($model->status == Status::CORE_STATUS_OPEN && $model->invoice_status == Status::DEPEDENCY_STATUS_NOTYET && $model->payment_status == Status::DEPEDENCY_STATUS_NOTYET && $model->delivery_status == Status::DEPEDENCY_STATUS_NOTYET && $model->purchase_status==Status::DEPEDENCY_STATUS_NOTYET)
{
	$buttonBar = new ButtonBar('{list}');
	$buttonBar->listUrl = array('index');
	$buttonBar->createUrl = array('create');
	$buttonBar->updateUrl = array('update', 'id'=>$model->so_cd);
	$buttonBar->printUrl = Yii::app()->createUrl('sales/so/preview',array('id'=>$model->so_cd));
	$buttonBar->sendnotificationUrl = array('sendnotif', 'so_cd'=>$model->so_cd);
	$buttonBar->printLinkHtmlOptions= array('target'=>'_blank');
	$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->so_cd),'confirm'=>'Are you sure you want to delete this item?');
}
else
{
	$buttonBar = new ButtonBar('{list}');
	$buttonBar->listUrl = array('index');
	$buttonBar->createUrl = array('create');
	$buttonBar->updateUrl = array('update', 'id'=>$model->so_cd);
	$buttonBar->printUrl = Yii::app()->createUrl('sales/so/preview',array('id'=>$model->so_cd));
	$buttonBar->sendnotificationUrl = array('sendnotif', 'so_cd'=>$model->so_cd);
	$buttonBar->printLinkHtmlOptions= array('target'=>'_blank');
}
$buttonBar->render();
?>

<br/>
<h3>SO</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'so_cd',
		array('label'=>'Client Name', 'value'=>$model->client->client_name),
		'client_po_no',
		'company.company_name',
		
		//ER
		//echo CHtml::link($model->client_po_clientfile, FileUpload::getHttpPath($model->so_cd, FileUpload::CLIENT_PO_PATH), array('id'=>'file_link'));
		/*array('label'=>'Client Po Client File','type'=>'raw','value'=>(($model->client_po_clientfile == null)? '' :
				 CHtml::link(CHtml::encode($model->client_po_clientfile), FileUpload::getHttpPath($model->so_cd, FileUpload::CLIENT_PO_PATH) )) ),*/
		
		array('label'=>'Sales Name', 'value'=>$model->employee->employee_name),
		array('name'=>'est_delivery_dt', 'type'=>'date'),
		
		'sell_currency',
		'top',
		
		array('label'=>'is_tax', 'value'=>(($model->is_tax == 0) ? 'Non Tax' : 'Tax')),
		array('label'=>'is_indent','value'=>Status::$is_status[$model->is_indent]),
		
		'notes',
		array('name'=>'status','value'=>Status::$so_status[$model->status]),
		array('name'=>'purchase_status','value'=>Status::$depedency_status[$model->purchase_status]),
		array('name'=>'invoice_status','value'=>Status::$depedency_status[$model->invoice_status]),
		array('name'=>'payment_status','value'=>Status::$depedency_status[$model->payment_status]),
	),
)); ?>


<br/>
<h3>Identity Attributes</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('label'=>'Employee Create', 'value'=>$model->create->employee_name),
		array('name' =>'create_dt', 'type'=>'date'),
		array('label'=>'Employee Update', 'value'=>$model->update->employee_name),
		array('name' =>'update_dt', 'type'=>'date'),
	),
)); ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'sodetail-grid',
		'dataProvider'=>$mDetail->search(),
		'filter'=>$mDetail,
		'filterPosition'=>'',
		'columns'=>array(
			'item_cd',
			'item.item_name',
			array('name'=>'qty','type'=>'number' ,'value'=>'$data->qty','htmlOptions'=>array('class'=>'col-right')),
			'vendor.vendor_name',
			'notes',
			
		),
));
?>

<h3>List RR</h3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'sodetail-grid',
		'dataProvider'=>$modelVwrr->search(),
		'filter'=>$modelVwrr,
		'filterPosition'=>'',
		'columns'=>array(
			'rr_cd',
			'actor_name',
		),
));
?>