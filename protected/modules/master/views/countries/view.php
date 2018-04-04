<?php
$this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->country_name,
);
?>

<?php Helper::showFlash(); ?>
<?php
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->country_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->country_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'country_id',
		'country_name',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
