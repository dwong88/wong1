<?php
$this->breadcrumbs=array(
	'Mspropertyfeatures'=>array('index'),
	$model->prop_features_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->prop_features_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->prop_features_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'prop_features_id',
		'features_name',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
