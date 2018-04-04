<?php
$this->breadcrumbs=array(
	'Countries',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#countries-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	$('.search-form').hide();
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
	'id'=>'countries-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'country_id',
		'country_name',
		array('name'=>'refUsercreate.user_name', 'header'=>'Create By'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'refUserupdate.user_name', 'header'=>'Update By'),
		array('name'=>'update_dt', 'type'=>'datetime'),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update}'
		),
	),
));

 ?>
