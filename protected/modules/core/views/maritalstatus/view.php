<?php
$this->breadcrumbs=array(
	'Marital Status'=>array('index'),
	$model->mastertype_code,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->mastertype_id);
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'mastertype_code',
		'mastertype_name',
		array('name'=>'refUsercreate.user_name', 'label'=>'Create By'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'refUserupdate.user_name', 'label'=>'Update By'),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>
