<?php
$this->breadcrumbs=array(
	'Banks'=>array('index'),
	$model->bank_cd,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->bank_cd);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->bank_cd),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'bank_cd',
		'bank_name',
		array('name'=>'refUsercreate.user_name', 'label'=>'Create By'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'refUserupdate.user_name', 'label'=>'Update By'),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>
