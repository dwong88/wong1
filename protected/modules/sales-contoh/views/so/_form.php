<?php
Helper::registerNumberField('.tnumber'); 

$deletelink=CHtml::normalizeUrl(array('deletefile','id'=>$model->so_cd));
Yii::app()->clientScript->registerScript(
					    '__inPageScript',
					    "
					    $('.disc-type-radio').click(function()
					    {
					    	if($('.disc-type-radio').val() == 0)
					    	{
					    		$('#So_discount_value').val(0);
					    	}
							$('#td-disc-content').removeClass('td-disc0 td-disc1 td-disc2').addClass('td-disc'+this.value);
						});
						
						$('#del_file').click(function(){
							var answ=confirm('Are you sure want to delete this file?');
							if(answ==true) self.location = '$deletelink';
						});
					    ",
CClientScript::POS_READY
);

?>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function()
	{
		<?php
			if($model->isNewRecord) echo "var data = $('#client_cd').val();";
			else echo "var data = $('#client_cd').val();";
		?>
			
		if(data!="")
			a(data);
			
		$('#client_cd').change(function()
		{
		
	    	var data = $('#client_cd').val();
			if(data!="")
			{
				a(data);
			}//end if data!=""
			
		});//end change function
		function a(data)
		{
			$.ajax({
		    	type: 'POST',
			    url : '<?php echo $this->createUrl('AjxCmbType'); ?>',
			   	data: { client_cd : data, so_cd :$('#so_cd').val()},
			   	dataType:'html',
				success:function(data)
				{
					$('#project_cd').html(data);
					<?php
						$project = DAO::queryRowSql("SELECT project_name FROM tdpproject WHERE client_cd = '".$model->client_cd."'");
						if(isset($model->project_name))
						{
					?>
					$('#project_cd').val("<?php echo $model->project_name; ?>");
					<?php } ?>
		        },
			   	error: function(data) 
			   	{ // if error occured
			        //alert('Error occured.please try again');
			        console.log("Error occured, please try again");
			    },
			});//end ajax

			$.ajax({
		    	type: 'POST',
			    url : '<?php echo $this->createUrl('AjxSales'); ?>',
			   	data: { client_cd : data},
			   	dataType:'html',
				success:function(data)
				{
					$('#sales_cd').html(data);
		        },
			   	error: function(data) 
			   	{ // if error occured
			        //alert('Error occured.please try again');
			        console.log("Error occured, please try again");
			    },
			});//end ajax
			
			$.ajax({
			    	type: 'POST',
				    url : '<?php echo $this->createUrl('AjxTop'); ?>',
				   	data: { client_cd : data},
				   	dataType:'html',
					success:function(data)
					{
						<?php
							if($model->isNewRecord||!$model->isNewRecord)
							echo "$('#top').val(data)";
						?>
			        },
				   	error: function(data) 
				   	{ // if error occured
				        //alert('Error occured.please try again');
				        console.log("Error occured, please try again");
				    },
				});//end ajax
				
			$.ajax({
			    	type: 'POST',
				    url : '<?php echo $this->createUrl('AjxClientContact'); ?>',
				   	data: { client_cd : data},
				   	dataType:'html',
					success:function(data)
					{
						
						$('#cmbinvoicecontact').html(data);
						$('#cmbdeliverycontact').html(data);
						
						var invoice_contact_id = '<?php echo $model->invoice_contact_id; ?>';
						var delivery_contact_id = '<?php echo $model->delivery_contact_id; ?>';
						
						$('#cmbinvoicecontact').val(invoice_contact_id);
						$('#cmbdeliverycontact').val(delivery_contact_id);
			        },
				   	error: function(data) 
				   	{ // if error occured
				        //alert('Error occured.please try again');
				        console.log("Error occured, please try again");
				    },
				});//end ajax
				
				$.ajax({
			    	type: 'POST',
				    url : '<?php echo $this->createUrl('AjxClientAddress'); ?>',
				   	data: { client_cd : data},
				   	dataType:'html',
					success:function(data)
					{
						$('#cmbinvoiceaddress').html(data);
						$('#cmbdeliveryaddress').html(data);
						
						var invoice_address_id = '<?php echo $model->invoice_address_id; ?>';
						var delivery_address_id = '<?php echo $model->delivery_address_id; ?>';
						
						$('#cmbinvoiceaddress').val(invoice_address_id);
						$('#cmbdeliveryaddress').val(delivery_address_id);
			        },
				   	error: function(data) 
				   	{ // if error occured
				        //alert('Error occured.please try again');
				        console.log("Error occured, please try again");
				    },
				});//end ajax
		}//end function a(data)
	});//end document ready function
</script>

<style>
	.td-disc0 #dis-val-content, .td-disc2 #dis-val-percent {display: none;}
	#divdetail-itemdesc {width: 100%; height: 140px; overflow: auto;}
	#detail-content {background-color: #ebebeb; padding: 5px;}
	.selltax0 .selecttax {display: none;}
</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'so-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
echo $form->hiddenField($model, 'so_status_temp', array('id'=>'so-status-temp'));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
	
	
	<table cellpadding="0" cellspacing="0" border="0" style="width: 100%" class="k-table-form">
	<tr>
		<td style="width: 50%; vertical-align:top">
			<table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<?php if($model->isNewRecord === false) { ?>
			<tr>
				<td style="width: 100px;"><?php echo $form->labelEx($model,'so_cd'); ?></td>
				<td style="width: 5px;">:</td>
				<td>
					<?php
                    	echo $model->so_cd;
						echo $form->hiddenField($model,'so_cd',array('id'=>'so_cd'));
					?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td><?php echo $form->labelEx($model,'company_id'); ?></td>
				<td>:</td>
				<td>
					<?php echo $form->dropDownList($model, 'company_id', CHtml::listData(Company::model()->findAll(), 'company_id', 'company_name') , array('prompt'=>'-Select Company-')); ?>
					<?php echo $form->error($model,'company_id'); ?>	
				</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'Sales'); ?></td>
				<td>:</td>
				<td>
					<?php
						if($model->isNewRecord)
						{
							echo $form->dropDownList($model, 'sales_cd', CHtml::listData(Employee::model()->findAll("employee_type='BOD' OR employee_type='sales'"), "employee_cd", "employee_name"), array('prompt'=>'','id'=>'sales_cd'));
						}
						else
						{
							echo $model->sales_cd .' - '. $model->employee->employee_name;
							echo $form->hiddenField($model,'sales_cd',array('id'=>'sales_cd'));
						}
					?>
					<?php echo $form->error($model,'sales_cd'); ?>
				</td>
			</tr>
			<tr>
				<td style="width: 100px;"><?php echo $form->labelEx($model,'client'); ?></td>
				<td style="width: 5px;">:</td>
				<td>
					<?php if($model->isNewRecord||!$model->isNewRecord): 
								if(Yii::app()->user->employee_type == 'Sales')
								{
						 			echo $form->dropDownList($model, 'client_cd',
						 			CHtml::listData(Client::model()->findAll(array("condition"=>"employee_cd = '".Yii::app()->user->employee_cd."'",'order'=>'t.client_name')),'client_cd', 'client_name'),
									array('id'=>'client_cd', 'prompt' => ''));
								}
								else
								{
									echo $form->dropDownList($model, 'client_cd',
									CHtml::listData(Client::model()->findAll(array('order'=>'t.client_name')),'client_cd', 'client_name'),
									array('id'=>'client_cd', 'prompt' => ''));
								}
						  else:
						  	echo $model->client_cd .' - '. $model->client->client_name;
						  	echo $form->hiddenField($model,'client_cd',array('id'=>'client_cd'));
						  endif;
					?>
					<?php echo $form->error($model,'client_cd'); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'project_name'); ?></td>
				<td>:</td>
				<td>
					<?php echo $form->dropDownList($model, 'project_name',array(), array('prompt'=>'', 'id'=>'project_cd')); ?>
					<?php echo $form->error($model,'project_name'); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'client_po_no'); ?></td>
				<td>:</td>
				<td>
					<?php echo $form->textField($model,'client_po_no',array('size'=>30,'maxlength'=>100)); ?>
					<?php echo $form->error($model,'client_po_no'); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'client_po_clientfile'); ?></td>
				<td>:</td>
				<td>
					<?php
						if(!$model->isNewRecord) 
						{
							if($model->client_po_clientfile!='')
							{
								echo CHtml::link($model->client_po_clientfile, FileUpload::getHttpPath($model->so_cd, FileUpload::CLIENT_PO_PATH), array('id'=>'file_link'));
								//'<a id="file_link" href="'.Yii::app()->request->baseUrl."/upload/client_po/".$model->client_po_clientfile.'" target="_blank">'.$model->client_po_clientfile.'</a>';
								echo ' '. CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete_red.png'), 'javascript://', array('id'=>'del_file')). '<br />';
							}
						}
					?>
					<?php echo CHTML::activeFileField($model, 'client_po_clientfile');?>
					<?php //echo $form->textField($model,'client_po_clientfile',array('size'=>60,'maxlength'=>255)); ?>
					<?php echo $form->error($model,'so_file_name'); ?>
							
				</td>
			</tr>
			
			<tr>
				<td><?php echo $form->labelEx($model,'Invoice Information'); ?></td>
				<td>:</td>
				<td>
					<?php
						if($model->isNewRecord||true)
						{
							echo $form->dropDownList($model, 'invoice_contact_id',array(),
											 array('prompt'=>'-Select Contact-','id'=>'cmbinvoicecontact'/*,
													'ajax' => array('type'=>'POST',
									                 	'url' =>CController::createUrl('po/ajxPotop'),
									                 	'update' => '#cmbpotop',*/
												)
											);
						}//end if model->isnewrecord
						else
						{
							echo $form->dropDownList($model,'invoice_contact_id',CHtml::listData(Clientcontactdetail::model()->findAll(
							"client_cd = '$model->client_cd' AND status = ".Status::STATUS_ACTIVE), 
							'contact_id', 'ConcatContactClient'));
						}//end else
					?>
					<?php
						if($model->isNewRecord||true)
						{
							echo $form->dropDownList($model, 'invoice_address_id',array(),
											 array('prompt'=>'-Select Address-','id'=>'cmbinvoiceaddress'/*,
													'ajax' => array('type'=>'POST',
									                 	'url' =>CController::createUrl('po/ajxPotop'),
									                 	'update' => '#cmbpotop',*/
												)
											);
						}//end if model->isnewrecord
						else
						{
							echo $form->dropDownList($model,'invoice_address_id',CHtml::listData(Clientaddress::model()->findAll(
							"client_cd = '$model->client_cd' AND status = ".Status::STATUS_ACTIVE), 
							'address_id', 'short_desc'));
						}//end else
					?>
					
					<?php echo $form->error($model,'invoice_contact_id'); ?>
					<?php echo $form->error($model,'invoice_address_id'); ?>
				</td>
			</tr>
			
			<tr>
				<td><?php echo $form->labelEx($model,'Delivery Information'); ?></td>
				<td>:</td>
				<td>
					<?php
						if($model->isNewRecord || true)
						{
							echo $form->dropDownList($model, 'delivery_contact_id',array(),
											 array('prompt'=>'-Select Contact-','id'=>'cmbdeliverycontact'/*,
													'ajax' => array('type'=>'POST',
									                 	'url' =>CController::createUrl('po/ajxPotop'),
									                 	'update' => '#cmbpotop',*/
												)
											);
						}//end if model->isnewrecord
						else
						{
							echo $form->dropDownList($model,'delivery_contact_id',CHtml::listData(Clientcontactdetail::model()->findAll(
							"client_cd = '$model->client_cd' AND status = ".Status::STATUS_ACTIVE), 
							'contact_id', 'ConcatContactClient'));
						}//end else
					?>
					<?php
						if($model->isNewRecord || true)
						{
							echo $form->dropDownList($model, 'delivery_address_id',array(),
											 array('prompt'=>'-Select Address-','id'=>'cmbdeliveryaddress'/*,
													'ajax' => array('type'=>'POST',
									                 	'url' =>CController::createUrl('po/ajxPotop'),
									                 	'update' => '#cmbpotop',*/
												)
											);
						}//end if model->isnewrecord
						else
						{
							echo $form->dropDownList($model,'delivery_address_id',CHtml::listData(Clientaddress::model()->findAll(
							"client_cd = '$model->client_cd' AND status = ".Status::STATUS_ACTIVE), 
							'address_id', 'short_desc'));
						}//end else
					?>
					<?php echo $form->error($model,'delivery_contact_id'); ?>
					<?php echo $form->error($model,'delivery_address_id'); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'est_delivery_dt'); ?></td>
				<td>:</td>
				<td>
					<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
				                        'model'=>$model,
				                        'attribute'=>'est_delivery_dt',
		                                ));?>
					<?php echo $form->error($model,'est_delivery_dt'); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'Expedisi'); ?></td>
				<td>:</td>
				<td>
					<?php echo $form->dropDownList($model, 'expedisi_cd', CHtml::listData(Expedisi::model()->findAll(), "expedisi_cd", "expedisi_name"), array('prompt'=>'')); ?>
					<?php echo $form->error($model,'expedisi_cd'); ?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top"><?php echo $form->labelEx($model,'notes'); ?></td>
				<td style="vertical-align:top">:</td>
				<td>
					<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
					<?php echo $form->error($model,'notes'); ?>
				</td>
			</tr>
			</table>
		</td>
		<td style="vertical-align:top">
			<table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
			<tr>
				<td style="width: 100px;"><?php echo $form->label($model,'is_tax'); ?></td>
				<td style="width: 5px;">:</td>
				<td>
					<?php
						if($model->isNewRecord) echo $form->checkBox($model,'is_tax', array('value'=>1, 'uncheckValue'=>0)).' Yes';
						else echo ($model->is_tax==0? 'No' : 'Yes'); 
					?>
					<?php echo $form->error($model,'is_tax'); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->label($model,'is_indent'); ?></td>
				<td>:</td>
				<td>
					<?php echo $form->checkBox($model,'is_indent', array('value'=>1, 'uncheckValue'=>0)).' Yes'; ?>
					<?php echo $form->error($model,'is_indent'); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model,'sell_currency'); ?></td>
				<td>:</td>
				<td>
					<?php echo $form->dropDownList($model, 'sell_currency', CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd"), array('prompt'=>'')); ?>
					<?php echo $form->error($model,'sell_currency'); ?>
				</td>
			</tr>
			
			<tr>
				<td><?php echo $form->labelEx($model,'top'); ?></td>
				<td>:</td>
				<td>
					<?php echo $form->textField($model,'top',array('size'=>'5', 'class'=>'col-right', 'id'=>'top')).' day(s)'; ?>
					<?php echo $form->error($model,'top'); ?>
				</td>
			</tr>
			
			<tr>
				<td><?php echo $form->labelEx($model,'total_titipan'); ?></td>
				<td>:</td>
				<td>
                	<?php echo $form->dropDownList($model, 'titipan_currency', CHtml::listData(Currency::model()->findAll(), "currency_cd", "currency_cd"), array('prompt'=>'')); ?>
					<?php echo $form->textField($model,'total_titipan',array('size'=>19,'maxlength'=>19, 'class'=>'col-right tnumber')); ?>
					<?php echo $form->error($model,'total_titipan'); ?>
				</td>
			</tr>
		
			</table>
		</td>
	</tr>
	</table>

	<div class="row buttons">
		<?php
			if($model->isNewRecord)
			echo CHtml::submitButton('Create'); 
			else
			{
				if(Yii::app()->user->employee_type == 'BOD')
				{
					switch($model->status)
					{
						case 1:
							echo CHtml::submitButton('Save', array('onclick'=>'$("#so-status-temp").val("1"); this.form.submit();')). ' '. CHtml::button('Save & Approve', array('onclick'=>'$("#so-status-temp").val("2"); this.form.submit();'));
								break;
						case 2: echo\ CHtml::button('ReOpen SO', array('onclick'=>'$("#so-status-temp").val("1"); this.form.submit();'));
					}
				}
				else
				{
					switch($model->status)
					{
						case 1:
							echo CHtml::submitButton('Save');
								break;
					}
				}
			}
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php if(!$model->isNewRecord) :?>
<hr />
<script type="text/javascript">
//WT: Untuk handle popup item pada saat add detail
function handleItem(itemData)
{
	$('#ipt-item-cd').val(itemData.item_cd);
	$('#tddetail-itemname').html(itemData.item_name);
	$('#tddetail-prodnumber').html(itemData.product_number);
	$('#divdetail-itemdesc').html(itemData.item_desc);
}
//WT: Untuk handle popup vendor pada saat add detail
function handleVendor(vendorData)
{
	$('#ipt-vendor-cd').val(vendorData.vendor_cd);
	$('#tddetail-vendorname').html(vendorData.vendor_name);
}
//WT: Untuk show detail pada saat click link add/update detail. 
function showDetail(oLink)
{
	$.ajax({
    	type: 'POST',
	    url : oLink.href,
	   	dataType:'html',
	   	success: function(data) {
			$('#detail-content').html(data).show();
			Karlwei.helper.date.registerTableDetailDateField($('#detail-content').find('.dtl-date'));
			$('#detail-content').find('.tnumber').trigger('blur');
			self.location = '#sodetail-form';
		},
	   	error: function(data) { // if error occured
	        alert('Error occured.please try again');
	        $('#detail-content').html(data);
	        //Karlwei.helper.date.registerTableDetailDateField($('#div-detail').find('.dtl-date'));
	    },
	});
}
//WT: Untuk pada saat mau create/update detail.
function validateDetailForm()
{
	var jForm 	= $('#sodetail-form');													// AH:ubah
	var data	= jForm.serialize();
	$.ajax({
    	type: 'POST',
	    url : jForm.attr('action'),
	   	data: data,
	   	dataType:'html',
		success:function(data) {
			$('#detail-content').html(data);
			if($(data).find('.errorSummary').length > 0) 
			{	
				//kalau error.
				Karlwei.helper.date.registerTableDetailDateField($('#detail-content').find('.dtl-date'));
				$('#detail-content').find('.tnumber').trigger('blur');
			}
			else {
				//kalau Sukses.
				$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");
				$.fn.yiiGridView.update('sodetail-grid');
			}
        },
	   	error: function(data) { // if error occured
	        alert('Error occured.please try again');
	        $('#detail-content').html(data);
	        Karlwei.helper.date.registerTableDetailDateField($('#detail-content').find('.dtl-date'));
	    },
	});
}
</script>

<a href="<?php echo CHtml::normalizeUrl(array('so/createdetail', 'so_cd'=>$model->so_cd));?>" onclick="showDetail(this); return false;">Add Detail</a>
<div id="detail-content" class="selltax<?php echo $model->is_tax;?>" style="display:none;">...</div>
<hr />
<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'sodetail-grid',
		'dataProvider'=>$mDetail->search(),
		'filter'=>$mDetail,
		'filterPosition'=>'',
		'columns'=>array(
			'item_cd',
			'item.item_name',
			array('name'=>'qty','value'=>'number_format($data->qty, 2, ".", ",")','htmlOptions'=>array('class'=>'col-right')),
			array('name'=>'cost_currency'),
			array('name'=>'cost_price','value'=>'number_format($data->cost_price, 2, ".", ",")','htmlOptions'=>array('class'=>'col-right')),
			array('header'=>'Sell Price - Disc','value'=>'number_format(($data->sell_price - ($data->discount_amt/$data->qty)), 2, ".", ",")','htmlOptions'=>array('class'=>'col-right')),
			array('name'=>'total_cost_price','value'=>'number_format($data->total_cost_price, 2, ".", ",")','htmlOptions'=>array('class'=>'col-right')),
			array('header'=>'Total Sell Price - Disc','htmlOptions'=>array('class'=>'col-right'),'value'=>'number_format($data->total_sell_price - $data->discount_amt, 2, ".", ",")'),
			array('header'=>'Margin (IDR)','type'=>'number','value'=>'$data->marginIDR','htmlOptions'=>array('class'=>'col-right')),
			array('name'=>'margin_percent','type'=>'text','value'=>'$data->marginIDRPercent."%"','htmlOptions'=>array('class'=>'col-right')),
			'vendor.vendor_name',
			'notes',
			array(
				'class'=>'CButtonColumn',
				'template'=>($model->status == 1)?'{update} {delete}':'{update}',
				'updateButtonUrl'=>'CHtml::normalizeUrl(array("so/updatedetail", "id"=>$data->primaryKey))',			// AH : ubah
				'deleteButtonUrl'=>'CHtml::normalizeUrl(array("so/deletedetail", "id"=>$data->primaryKey))',			// AH : ubah
				'updateButtonOptions'=>array(
					'class'=>'update',
					'onclick'=>'showDetail(this); return false;',
				),
			),
		),
));

endif; //endifnewrecord
?>