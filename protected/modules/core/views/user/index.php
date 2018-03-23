<?php
$this->breadcrumbs=array(
	'User',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
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
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'user_id',
		'user_name',
		'user_type',
		array('name'=>'is_active', 'type'=>'text', 'value'=>'(($data->is_active==1)? "Yes" : "No")' ),
		/*
		'create_by',
		'create_dt',
		'update_by',
		'update_dt',
		*/
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
			'template'=>'{changepass}{view}{update}{delete}',
			'htmlOptions'=>array('width'=>'100px'),
			'buttons'=>array(
				'changepass'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/changepass.png',       
					'url'=>'Yii::app()->createUrl("/core/user/changepass",array("id"=>$data->user_id))'
				),
			),
		),
	),
)); ?>

















