<style>
    #dp-menu-ordering {list-style-type: none; width: 50%; margin:0px; padding: 0px; }
    #dp-menu-ordering li {padding:5px; margin: 0px 3px 3px 3px;}
</style>
<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'menu-order-form',
		'enableAjaxValidation'=>false,
	    'htmlOptions'=>array('class'=>'inline'),
	)); 
?>
<?php
	$listMenu = CHtml::listData($model,'menu_id','menu_name');
	$this->widget('zii.widgets.jui.CJuiSortable', array(
	    'items'=>$listMenu,
	    'itemTemplate'=>'<li value="{id}" class="ui-state-default">{content}
	    					<input type="hidden" name="Menu[menu_id][]" value="{id}" />
	    				</li>',
	    'htmlOptions'=>array('id'=>'dp-menu-ordering'),
	    'options'=>array(
	        'delay'=>'200',
	    ),
	));
?>
<div class="span-20">
    <?php echo CHtml::submitButton('Save'); ?>
</div>
<?php $this->endWidget(); ?>