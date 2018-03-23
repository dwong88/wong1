<?php


$this->breadcrumbs=array(
	'Pengaturan',
	'Menu'=>array('index'),
	$model->menu_name => array('view','id'=>$model->menu_id),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create','parent_id'=>$model->menu_id);
$buttonBar->viewUrl = array('view', 'id'=>$model->menu_id);
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'mDetail'=>$mDetail)); ?>