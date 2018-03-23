<?php
/* @var $this SoreturController */
/* @var $data Soretur */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('do_cd')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->do_cd), array('view', 'id'=>$data->do_cd)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('letter_cd')); ?>:</b>
	<?php echo CHtml::encode($data->letter_cd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actor_cd')); ?>:</b>
	<?php echo CHtml::encode($data->actor_cd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('received_dt')); ?>:</b>
	<?php echo CHtml::encode($data->received_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('received_by')); ?>:</b>
	<?php echo CHtml::encode($data->received_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_by')); ?>:</b>
	<?php echo CHtml::encode($data->checked_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked_dt')); ?>:</b>
	<?php echo CHtml::encode($data->checked_dt); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rr_type')); ?>:</b>
	<?php echo CHtml::encode($data->rr_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_tax')); ?>:</b>
	<?php echo CHtml::encode($data->is_tax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_status')); ?>:</b>
	<?php echo CHtml::encode($data->payment_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_dt')); ?>:</b>
	<?php echo CHtml::encode($data->create_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_dt')); ?>:</b>
	<?php echo CHtml::encode($data->update_dt); ?>
	<br />

	*/ ?>

</div>