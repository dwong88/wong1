<?php
$this->breadcrumbs=array(
	'Usergroups',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('usergroup-grid', {
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
<style>
	td a img{
		margin-right: 5px;
	}
</style>
<?php $this->widget('application.extensions.widget.GridView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'usergroup_id',
		'usergroup_name',
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
			'htmlOptions'=>array('width'=>'150px'),
			'template'=>'{add user list}{menu config}{view}{update}{delete}',
			'buttons'=>array(
		        'menu config'=>array(
		                'imageUrl'=>Yii::app()->request->baseUrl.'/images/menu_conf.png',                          
		                'url' => 'Yii::app()->createUrl("/core/usergroup/menuconf", array("id" => $data->usergroup_id))'
		         ),
		         'add user list'=>array(
		                'imageUrl'=>Yii::app()->request->baseUrl.'/images/user_group.png',                          
		                'url' => 'Yii::app()->createUrl("/core/usergroup/userlist", array("id" => $data->usergroup_id))',
		         ),
        	 )
		),
	),
)); ?>
