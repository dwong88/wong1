<?php
$this->breadcrumbs=array(
	'Temproomprices'=>array('index'),
	$model->random_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->random_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->random_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'random_id',
		'hours',
		'price',
	),
)); ?>
