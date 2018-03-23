<?php
$this->breadcrumbs=array(
	'Projects',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('project-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{search} {create}');
$buttonBar->searchLinkHtmlOptions = array('id'=>'srcbutton');
$buttonBar->createUrl = array('create');
$buttonBar->render();
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'client.client_name', 'header'=>'Client Name'),
		'project_name',
		array('name'=>'client.employee.employee_name', 'header'=>'Employee Name'),
		array('name'=>'start_date', 'type'=>'date'),
		array('name'=>'end_date', 'type'=>'date'),
		array('name'=>'Is Closed','value'=>'Status::$is_status[$data->is_closed]'),
		'project_notes',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
