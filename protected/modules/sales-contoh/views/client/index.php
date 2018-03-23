<?php
$this->breadcrumbs=array(
	'Clients',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('client-grid', {
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
	'id'=>'client-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'client_cd',
		'client_name',
		array('name'=>'employee.employee_name','header'=>'Sales Name'),
		array('name'=>'top','value'=>'$data->top." day(s)"','htmlOptions'=>array('class'=>'col-right')),
		array('name'=>'notes','type'=>'raw','htmlOptions'=>array('width'=>'30%'),'value'=>'nl2br($data->notes)'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
