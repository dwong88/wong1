<?php
//print_R($models);
?>

<?php $this->widget('application.extensions.widget.GridView', array(
	'id'=>'property-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'filterPosition'=>'',
	'columns'=>array(
		'photo_id',
		'filename',
		array(
      'class'=>'CButtonColumn',
      'template'=>'{delete}',
			'deleteButtonUrl'=>'CHtml::normalizeUrl(array("property/delete", "id"=>$_GET["id"], "pid"=>$data->photo_id))',
		),
	),
)); ?>
<script type="text/javascript">
// default  rows form
 $(function() {
     addRow('tb_item','','');
  });

     function deleteRow(btn){
      var row = btn.parentNode.parentNode;
      row.parentNode.removeChild(row);
  }
  function addRow(tableID,nama_gambar,gambar) {

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            global_variable=rowCount;


            var cell2 = row.insertCell(0);
            var element1 = document.createElement("input");
            element1.type = "text";
            element1.name="nama_gambar[]";
            element1.className="form-control";
            element1.selectedIndex=nama_gambar;
            cell2.appendChild(element1);

            var cell3 = row.insertCell(1);
            var element2 = document.createElement("input");
            element2.type = "file";
						element2.name = "gambar[]";
            element2.value = gambar;
            element2.className="form-control";
            element2.style= 'width:130px';

						cell3.appendChild(element2);

						var cell3 = row.insertCell(2);

            var t=document.createElement("input");
            t.type="submit";
            t.value="Delete";

            t.setAttribute("onclick","deleteRow(this)");
            t.style.cssText="cursor: pointer;";
            cell3.appendChild(t,'Delete');
        }

</script>
<br/>
  <form method="post" name="foto-form" action="<?php echo Yii::app()->baseUrl; ?>/index.php?r=partner/property/createrenderphotos&id=<?php echo $_GET['id'];?>"  onSubmit="return confirm('Apakah data yang di input sudah benar?');">
		<table width="100%">
		                  <tr>
		                     <td align="left" width="700px"><strong style="font-size:12px;" > Produk </strong></td>
		                     <td align="right">
		                     <button type="button"  onClick="addRow('tb_item','','','','')" style="width:100px;">
		                     <span class="fa fa-plus"></span> Add Item
		                     </button>

		                     </td>
		                  </tr>

		               </table>

		               <table class="tbl_1" id="tb_item">
		            <tr>
		                <td>Nama Gambar</td>
		                <td>image</td>
		                <td></td>
		            </tr>

		        </table>
				<div style="margin-bottom:5px;">
				         <input type="hidden" name="produk_id" value="<?=$_GET['id']?>">
				         <button type="submit"  name="simpan" value="Simpan"   onClick="return validate();"> Simpan </button>
			 </div>
  </form>


	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'propertyphoto-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'title' => 'form title'),

	)); ?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php if($models->hasErrors()) echo $form->errorSummary($models); ?>

		<?php Helper::showFlash(); ?>
		<div class="row">
			<?php echo $form->labelEx($models,'doc'); ?>
			<?php echo $form->fileField($models,'doc'); ?>
			<?php echo $form->error($models,'doc'); ?>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton($models->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
