<?php
$this->breadcrumbs=array(
	'Promosis'=>array('index'),
	$model->promosi_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->promosi_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->promosi_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'promosi_id',
		'promosi_name',
		'amount',
		'promosi_code',
		'date_start',
		'date_end',
		'promosi_status',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
