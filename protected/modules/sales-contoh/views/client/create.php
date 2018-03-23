<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	'Create',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>