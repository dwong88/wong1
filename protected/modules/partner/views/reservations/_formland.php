<div class="form">
<?php
$room_id = $model->room_id;
$start = $model->start_date;
$end = $model->end_date;
$id_type = $model->type;
		if($model->isNewRecord){
		 $actions[]='loadcreateevent&start='.$start."&end=".$end."&resource".$room_id."&idtype".$id_type;
		}
		else{
			$id=$model->reservations_id;
			$actions[]='update&id='.$id;
		}
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'reservations-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'action'=>$actions,
)); ?>
	<table>
		<tr>
				<td><?php
					//echo $model->room_id;
					echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/images/bed.png', 'Bed'),array('roomclosure/createcal',
				                                         'start'=>$start,'end'=>$end,'resource'=>$room_id)); ?> Room Closure</td>
			 <td><?php
					//echo $model->room_id;
					echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/images/reservation.png', 'Reservation'),array('reservations/loadcreateevent',
				                                         'start'=>$start,'end'=>$end,'resource'=>$room_id,'idtype'=>$id_type)); ?>Room Reservation
		  </td>
		</tr>

<?php $this->endWidget(); ?>

</div><!-- form -->
