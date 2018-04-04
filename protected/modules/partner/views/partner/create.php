<?php
$this->breadcrumbs=array(
	'Partners'=>array('index'),
	'Create',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<?php //$this->renderPartial('_form', array('model'=>$model)); ?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'model1'=>$model1
)); ?>
