<?php
$csrf = '';
if(Yii::app()->request->enableCsrfValidation)
{
    $csrfTokenName = Yii::app()->request->csrfTokenName;
    $csrfToken = Yii::app()->request->csrfToken;
    $csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
}

$this->breadcrumbs=array(
	'Properties',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#property-grid').yiiGridView('update', {
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

<?php $this->widget('application.extensions.widget.GridViewProperty', array(
	'id'=>'property-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'property_id',
		'property_name',
		'addressline1',
		'addressline2',
		'city_id',
		'postal_code',
		/*
		'suburb',
		'country',
		'state',
		'weekend_start',
		'hotel_phone_number',
		'phone_number',
		'tax_number',
		'minimumroomrate',
		'star_rated',
		'numberofstar',
		'maximumchildage',
		'maximuminfantage',
		'bookingconfirmationemail',
		'bookingconfirmationccemail',
		'enquiryemail',
		'availabilityalertemail',
		'description',
		'gmaps_longitude',
		'gmaps_latitude',
		'available_cleaning_start',
		'available_cleaning_end',
		'locationinstruction',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
		*/
		array(
            'header'=>'Add Room Type',
            'class'=>'application.extensions.widget.ButtonColumn',
            'template'=>'{roomtype}',
            'buttons'=>array(
                'roomtype'=>array(
                    'imageUrl'=>Yii::app()->theme->baseUrl.'/images/create.png',
                    'url'=>'CHtml::normalizeUrl(array("/master/roomtype/create","id"=>$data->property_id))',
                    'options'=>array('title'=>'Add Room Type'),
                ),
            )
        ),
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
