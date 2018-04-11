<?php
$this->breadcrumbs=array(
	'Roomphototypes'=>array('index'),
	$model->roomphototype_id,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->roomphototype_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->roomphototype_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'roomphototype_id',
		'roomphototype_name',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
