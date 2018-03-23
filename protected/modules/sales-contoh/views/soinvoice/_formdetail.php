<hr/>
<h3>DO-Detail</h3>
<script>

	$(document).ready(function(){
	
		var part1 = "javascript:popup('<?php echo CHtml::normalizeUrl(array('/sales/Soinvoice/ShwDoDetail')); ?>";
		var part2 = "', 'winselect', 900, 900)";

		$('#cmb-soinvoicedo').change(function(){
			var do_cd = $('#cmb-soinvoicedo').html();
			if(do_cd != ''){
				var url =  part1+'&do_cd='+$('#cmb-soinvoicedo').val()+part2; // AH: change
				
				$('#link-shwdodetail').attr('href',url);
				$('#link-shwdodetail').show();
			}else{
				$('#link-shwdodetail').hide();
			}
		});
		
		function sendDoDetail(formdata)
		{
			$.ajax({
		    	type: 'POST',
			    url : '<?php echo CHtml::normalizeUrl(array('soinvoice/adddodetail')); ?>',
			    data: formdata,
			   	dataType:'json', 
			   	success: function(jsondata) {
			   		var status			= jsondata.status;
				 			
					if(status == 'success')
					{
						var grand_total 			= jsondata.grand_total_sum;
						var subtotal_price			= jsondata.subtotal_price;
						var subtotal_disc			= jsondata.subtotal_disc;
						var subtotal_tax			= jsondata.subtotal_tax;
						var grand_total_float		= jsondata.grand_total_sum_float;
						var subtotal_price_float	= jsondata.subtotal_price_float;
						var subtotal_disc_float		= jsondata.subtotal_disc_float;
						var subtotal_tax_float		= jsondata.subtotal_tax_float;
						var delivery_dt				= jsondata.delivery_dt;
				 		
						$.fn.yiiGridView.update('dodetail-grid');
						$.fn.yiiGridView.update('itemdetail-grid');
						updateCmbpoinvoicerr();
						
						 $("#grand_total").html(grand_total);
						 $("#hidden_grandtotal").val(grand_total_float);
						 
						 $("#subtotal_price").html(subtotal_price);
						 $("#hidden_subtotal_price").val(subtotal_price_float);
						
						 $("#subtotal_disc").html(subtotal_disc);
						 $("#hidden_subtotal_disc").val(subtotal_disc_float);
						
						 $("#subtotal_tax").html(subtotal_tax);
						 $("#hidden_subtotal_tax").val(subtotal_tax_float);
						 
						 $("#soinvoice_dt_picker").val(delivery_dt);
					}else
						$('#err-adddodetail').html(jsondata.err_msg);
						
				},
			   	error: function(data) { // if error occured
			        alert('Error occured.please try again');
			        
			    },
			});//end ajax
		}
		
		$('#link-adddodetail').click(function(e){
			e.preventDefault();
			var formdata = $('#soinvoicedo-form').serialize();		// AH: change
		
			if($('#cmb-soinvoicedo').val()==''||$('#cmb-soinvoicedo').val()==null)
			{
				//console.log("null");
			}
			else
			{
				//console.log("!null");
				sendDoDetail(formdata);
			}
			
		});

		function updateCmbpoinvoicerr()
		{
				
		}		
	});
</script>

<a id='link-adddodetail' href="<?php echo CHtml::normalizeUrl(array('soinvoice/adddodetail'));?>">Add DO</a>
<?php echo CHtml::link('browse', "",array('id'=>'link-shwdodetail','style'=>'display:none;'))?>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'soinvoicedo-form',
	'enableAjaxValidation'=>false,
)); 
	echo $form->hiddenField($model,'soinvoice_cd',array('value'=>$soinvoice_cd));
	echo $form->dropDownList($model, 'do_cd',CHtml::listData(
							Devo::model()->findAll("letter_cd = '".$so_cd."' AND invoice_status = ".Status::DEPEDENCY_STATUS_NOTYET." AND is_from_retur = ".Status::IS_STATUS_NO." AND status = ".Status::CORE_STATUS_OPEN)                                                                                         
							,'do_cd','do_cd'),
							 array('id' => 'cmb-soinvoicedo','prompt'=>'-Choose DO-'));
	
$this->endWidget(); ?>
<div id="err-adddodetail"></div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dodetail-grid',
	'dataProvider'=>$model->search(),
	'filterPosition'=>'',
	'columns'=>array(
		'do_cd',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
			'viewButtonUrl'=>'"javascript:popup(\"".CHtml::normalizeUrl(array("soinvoice/shwdodetail", "do_cd"=>$data->do_cd))."\",\"winselect\",900,900);"',			// AH : change
			'deleteButtonUrl'=>'CHtml::normalizeUrl(array("soinvoice/deletedetail", "id"=>$data->primaryKey))',		// AH : change
			'afterDelete'=>'function(link,success,data){ if(success) 
				{
					$.fn.yiiGridView.update("itemdetail-grid");
					var jsondata = $.parseJSON(data),
					 		grand_total = jsondata.grand_total_sum,
					 		subtotal_price	= jsondata.subtotal_price,
					 		subtotal_disc	= jsondata.subtotal_disc,
					 		subtotal_tax	= jsondata.subtotal_tax,
					 		grand_total_float		= jsondata.grand_total_sum_float,
					 		subtotal_price_float	= jsondata.subtotal_price_float,
					 		subtotal_disc_float		= jsondata.subtotal_disc_float,
					 		subtotal_tax_float		= jsondata.subtotal_tax_float;
							
					 $("#grand_total").html(grand_total);
					 $("#hidden_grandtotal").val(grand_total_float);
					 
					 $("#subtotal_price").html(subtotal_price);
					 $("#hidden_subtotal_price").val(subtotal_price_float);
					
					 $("#subtotal_disc").html(subtotal_disc);
					 $("#hidden_subtotal_disc").val(subtotal_disc_float);
					
					 $("#subtotal_tax").html(subtotal_tax);
					 $("#hidden_subtotal_tax").val(subtotal_tax_float);
				
				} 
			}',				// AH : optional to create depedeny to another grid 
			'buttons'=>array(
				'update'=> array('visible'=>'false'),
				'view'=>array('options'=>array('class'=>'viewdetail')),
				'delete'=>array('visible'=>'true')
			),
		),
	),
)); ?>




