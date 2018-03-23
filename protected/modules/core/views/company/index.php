<?php
$this->breadcrumbs=array(
	'Companies',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('company-grid', {
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
	'id'=>'company-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'company_name',
		array('name'=>'address', 'type'=>'raw','htmlOptions'=>array('width'=>'30%'), 'value'=>'nl2br($data->address)'),
		'phone',
		'fax',
		'npwp_no',
		'npwp_name',
		array('name'=>'npwp_address', 'type'=>'raw','htmlOptions'=>array('width'=>'30%'), 'value'=>'nl2br($data->npwp_address)'),
		/*'create_by',
		'create_dt',
		'update_by',
		'update_dt',
		*/
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
