<?php
$this->breadcrumbs=array(
	'Partners'=>array('index'),
	$model->partner_id,
);
?>

<?php Helper::showFlash(); ?>
<?php
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->partner_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->partner_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'partner_id',
		'partner_name',
		'pic',
		array('name'=>'refUsercreate.user_name', 'header'=>'Create By'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'refUserupdate.user_name', 'header'=>'Update By'),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>
