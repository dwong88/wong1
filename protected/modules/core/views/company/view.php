<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->company_name,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->company_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->company_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'company_name',
		array('name'=>'Address', 'type'=>'raw','htmlOptions'=>array('width'=>'30%'), 'value'=>nl2br($model->address)),
		'phone',
		'fax',
		'npwp_no',
		'npwp_name',
		array('name'=>'npwp_address', 'type'=>'raw','htmlOptions'=>array('width'=>'30%'), 'value'=>nl2br($model->npwp_address)),
		/*'create_by',
		'create_dt',
		'update_by',
		'update_dt',*/
	),
)); ?>
