<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Create',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>