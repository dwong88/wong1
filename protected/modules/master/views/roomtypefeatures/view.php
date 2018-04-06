<?php
$this->breadcrumbs=array(
	'Room type features'=>array('index'),
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'roomfeatures','value'=>$model->refRoomfeatures->room_features_name),
		array('name'=>'roomtype','value'=>$model->refRoomtype->room_type_name),
	),
)); ?>
