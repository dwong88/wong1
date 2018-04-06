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
		'photo_name',
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
