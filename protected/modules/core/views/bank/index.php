<?php
$this->breadcrumbs=array(
	'Bank',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bank-grid').yiiGridView('update', {
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

<?php $this->widget('application.extensions.widget.GridView', array(
	'id'=>'bank-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'bank_cd',
		'bank_name',
		array('name'=>'create_by', 'type'=>'text', 'value'=>'$data->refUsercreate->user_name'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'update_by', 'type'=>'text', 'value'=>'$data->refUserupdate->user_name'),
		array('name'=>'update_dt', 'type'=>'datetime'),
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
