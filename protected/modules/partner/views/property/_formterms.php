<?php

Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
$('#id-sel-language').change(function() {
	var thisvalue = this.value;
	var url = $(location).attr('href')+'&lang=';
	var thisid = ".$_GET['id'].";
	console.log(thisid);
	if ($(this).value != 'None') {
								 window.location.href = 'index.php?r=partner/property/update&id='+thisid+'&lang='+thisvalue;
					 };
});

							",
CClientScript::POS_READY
);


?>

<?php/*
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
							$(function () {

							    // Lets be professional, shall we?
							    'use strict';

							    // Some variables for later
							    var dictionary, set_lang;

							    // Object literal behaving as multi-dictionary
							    dictionary = {
							        'en': {
							            '_hello': 'Hello',
							            '_january': 'January'
							        },
							        'id': {
							            '_hello': 'Oie',
							            '_january': 'Janeiro'
							        },
							        'russian': {
							            '_hello': 'привет',
							            '_january': 'январь'
							        }
							    };

							    // Function for swapping dictionaries
							    set_lang = function (dictionary) {
							        $('[data-translate]').text(function () {
							            var key = $(this).data('translate');
							            if (dictionary.hasOwnProperty(key)) {
							                return dictionary[key];
							            }
							        });
							    };

							    // Swap languages when menu changes
							    $('#id-sel-language').on('change', function () {
							        var language = $(this).val().toLowerCase();
												console.log(language);
							        if (dictionary.hasOwnProperty(language)) {
							            set_lang(dictionary[language]);
							        }
							    });

							    // Set initial language to English
							    set_lang(dictionary.en);

							});

							",
CClientScript::POS_READY
);

*/
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertydesc-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($modeldesc->hasErrors()) echo $form->errorSummary($modeldesc); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($modeldesc,'lang'); ?>
		<?php echo $form->dropDownList($modeldesc, 'lang', Helper::$listLanguage, array('prompt'=>'', 'id'=>'id-sel-language')); ?>
	</div>

	<?php foreach (Propertydesc::$publicTypeDesc as $key => $value) { ?>
		<div class="row">
			<?php echo $form->labelEx($modeldesc,$value); ?>
			<?php //echo $form->textField($modeldesc,'propertyname',array('size'=>60,'maxlength'=>100)); ?>
	        <?php echo $form->textArea($modeldesc,$value,array('rows'=>6, 'cols'=>50)); ?>
			<?php //echo $form->error($modeldesc,'desc[]'); ?>
		</div>
	<?php } ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($modeldesc->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<!--
<select id="id-sel-language">
    <option>English</option>
    <option>Portuguese</option>
    <option>Russian</option>
</select>
<span data-translate="_hello">Hello</span>,
<span data-translate="_january">January</span>!-->
