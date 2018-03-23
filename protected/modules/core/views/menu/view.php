<?php
$this->breadcrumbs=array(
	'Pengaturan',
	'Menu'=>array('index'),
	$model->menu_name => array('#')
	
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create', 'parent_id'=>$model->menu_id);
$buttonBar->updateUrl = array('update', 'id'=>$model->menu_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->menu_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php 
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'menu_id',
		'parent_menu_name',
		'menu_name',
		'default_url',
		'menu_order',
		'active_status',
	),
));
 
?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'menuaction-grid',
		'dataProvider'=>$mDetail->search(),
		'filter'=>$mDetail,
		'filterPosition'=>'',
		'columns'=>array(
			'menuaction_id',
			'action_url',
			'group_name',
			'menuaction_desc',
			
		),
	));
?>
