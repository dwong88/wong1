<?php
$this->breadcrumbs=array(
	'Property type'=>array('index'),
	$model->property_type_name,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->property_type_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->property_type_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'property_type_id',
		'property_type_name',
		'property_desc',
		array('name'=>'create_dt', 'type'=>'datetime'),
        array('name'=>'create_by','value'=>$model->refUserupdate->user_name),
        array('name'=>'update_dt', 'type'=>'datetime'),
        array('name'=>'update_by','value'=>$model->refUserupdate->user_name)
	),
)); ?>
