<?php
$this->breadcrumbs=array(
	'Expedisis',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('expedisi-grid', {
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
	'id'=>'expedisi-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'expedisi_cd',
		'expedisi_name',
		array('name'=>'expedisi address','type'=>'raw','htmlOptions'=>array('width'=>'25%'),'value'=>'nl2br($data->expedisi_address)'),
		'expedisi_contact',
		array('name'=>'create.employee_name', 'header'=>'Create By'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'update.employee_name', 'header'=>'Update By'),
		array('name'=>'update_dt', 'type'=>'datetime'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
