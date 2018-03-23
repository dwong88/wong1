<?php Helper::registerNumberField('.tnumber'); ?>
<?php $deletelink1=CHtml::normalizeUrl(array('deletefile','id'=>$model->soinvoice_cd,'file'=>"1")); ?>
<?php $deletelink2=CHtml::normalizeUrl(array('deletefile','id'=>$model->soinvoice_cd,'file'=>"2")); ?>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function()
	{
		var data = $('#so_cd_dd').val();
		$('#del_file1').click(function(){
			var answ=confirm('Are you sure want to delete this file?');
			if(answ==true) self.location = '<?php echo $deletelink1?>';
		});
		
		$('#del_file2').click(function(){
			var answ=confirm('Are you sure want to delete this file?');
			if(answ==true) self.location = '<?php echo $deletelink2?>';
		});
		
		var part1 = "javascript:popup('<?php echo CHtml::normalizeUrl(array('/sales/Soinvoice/BrowseSo')); ?>";
		var part2 = "', 'winselect', 900, 900)";

		$('#payment_check_box').change(function()
		{
			if ($('#payment_check_box').is(':checked'))
		    {
				if(data!="")
				{
					$.ajax({
				    	type: 'POST',
					    url : '<?php echo $this->createUrl('shwdetail'); ?>', //link to actionShwDetail in PoinvoiceController
					   	data: { so_cd : data},
					   	dataType:'html',
						success:function(data){
							$('#grid-detail').html(data);
				        },
					   	error: function(data) { // if error occured
					        //alert('Error occured.please try again');
					        console.log("Error occured, please try again");
					    },
					});//end ajax
				}//end if data!=""
				$('#grid-detail').show();
		    }//end if #payment_check_box
		    else
		    {
		    	$('#grid-detail').hide();
		    }
			
		});//end change function
		
		if(data!='') a(data);
		
		$('#so_cd_dd').change(function()
		{
			$('#grid-detail').hide();
			$("#prefix_dd").val("");
			var so_cd = $('#so_cd_dd').val();
			if(so_cd != ''){
				var url =  part1+'&so_cd='+so_cd+part2; // AH: change
				
				$('#browse_so').attr('href',url);
				a(data);
			}//end if
		});//end change function
		
		function a(data)
		{
			$.ajax({
			    	type: 'POST',
				    url : '<?php echo $this->createUrl('AjxInvoiceContactAndAddress'); ?>',
				   	data: $("#soinvoice-form").serialize(),
				   	dataType:'html',
					success:function(data)
					{
						var data = $.parseJSON(data);
						$('#cmbinvoicecontact').html(data.cmbContact);
						$('#cmbinvoiceaddress').html(data.cmbAddress);
						
						var contact_id = ('<?php echo $model->invoice_contact_id; ?>' != '')?'<?php echo $model->invoice_contact_id; ?>':data.soContact;
						var address_id = ('<?php echo $model->invoice_address_id; ?>' != '')?'<?php echo $model->invoice_address_id; ?>':data.soAddress;
						
						$('#cmbinvoicecontact').val(contact_id);
						$('#cmbinvoiceaddress').val(address_id);
			        },
				   	error: function(data) 
				   	{ // if error occured
				        //alert('Error occured.please try again');
				        console.log("Error occured, please try again");
				    },
				});//end ajax
		}//end function a
		
	});//end document ready function
	
	function showPrefix()
	{
		$('#prefix_div').show();
	}
	
	function hidePrefix()
	{
		$('#prefix_div').hide();
	}
	
	function showPay()
	{
		$('#pay_amount').show();
		$('#pay_percent').show();
	}
	
	function hidePay()
	{
		$('#pay_amount').hide();
		$('#pay_percent').hide();
	}
	
	function showSub()
	{
		$('#subtotalPrice').show();
		$('#subtotalDisc').show();
		$('#subtotalTax').show();
	}
	
	function hideSub()
	{
		$('#subtotalPrice').hide();
		$('#subtotalDisc').hide();
		$('#subtotalTax').hide();
	}
	
	function change() {
    	if ($('#payment_check_box').is(':checked'))
	    {
	    	//Checkbox is checked
	    	//alert("checked");
	    	showPay();
			
			$('#used_dp_text').val(0);			//ganti nilai used dp menjadi 0
			$('#used_dp').hide();				//sembunyikan used_dp
			$('#grandtotal').show();
			
			showSub();
	    }
	    else
	    {
	    	//Checkbox is unchecked
	    	//alert("unchecked");
	    	$('#pay_percent_text').val('');		//kosongkan textfield pay_percent
	    	$('#pay_amount_text').html('');		//kosongkan textfield pay_amount
	    	$('#hidden_payment_amount').val('');
	    	$('#used_dp').show();
	    	
	    	hidePay();
			
			$('#used_dp_text').val(0);
			$('#grandtotal').hide();
			
			hideSub();
			//$('#used_dp').show();				//munculkan pay percent

	    }
	}
	
	function fillAmount()
	 {
	 	var grandtotal = $('#hidden_grandtotal').val();			//subtotal
	 	var percent = parseFloat($('#pay_percent_text').val());					//payment percent
	 	var amount = parseFloat((percent/100)*grandtotal);
	 	amount = amount.toFixed(2);
	 	$('#hidden_payment_amount').val(amount);
	 	amount = Karlwei.helper.number.addCommas(amount);
	 	$('#pay_amount_text').html(amount);
	 }
</script>

<div class="form">

	<div class="wide form">
		
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'soinvoice-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
		
		
		<?php Helper::showFlash(); ?>
		
		<?php if(!$model->isNewRecord): ?>
		<div class="row">
			<?php echo $form->labelEx($model,'soinvoice_cd'); ?>
			<?php 
				echo $model->soinvoice_cd;
			?>
			<?php echo $form->error($model,'soinvoice_cd'); ?>
		</div>
		<?php endif; ?>
		
		<div class="row">
			<?php echo $form->labelEx($model,'so_cd'); ?>
			<?php if($model->isNewRecord):
						echo $form->dropDownList($model, 'so_cd', 
						CHtml::listData(So::model()->findAll("status= ".Status::SO_STATUS_APPROVED." AND invoice_status!= ".Status::DEPEDENCY_STATUS_COMPLETE.""), 'so_cd','ConcatSoClient')
						, array('id'=>'so_cd_dd','prompt'=>'-Select So Code-',
						'ajax' => array('type'=>'POST',
										'url'=>CController::createUrl('Soinvoice/ajxclientname'),
										'success'=>'function(data) {
											var jsondata		= $.parseJSON(data),
											subtotal_sell		= jsondata.subtotal_sell,
											subtotal_tax		= jsondata.subtotal_tax,
											subtotal_sell_disc	= jsondata.subtotal_sell_disc,
											subtotal_sell_float = jsondata.subtotal_sell_float,
											subtotal_sell_disc_float = jsondata.subtotal_sell_disc_float,
											subtotal_tax_float	= jsondata.subtotal_tax_float,
											is_tax				= jsondata.is_tax,
											currency_kurs		= jsondata.currency_kurs,
											tax_kurs			= jsondata.tax_kurs,
											so_cd				= jsondata.so_cd,
											top 				= jsondata.top,
											grand_total			= jsondata.grand_total,
											grand_total_float	= jsondata.grand_total_float,
											currency_cd			= jsondata.currency_cd;
											
											$("#hidden_currency_cd").val(currency_cd);
											$("#hidclient_name").val(jsondata.kode_client);
                    						$("#client_name").html(jsondata.kode_client+" - "+jsondata.nama_client);
											
											$("#grand_total").html(grand_total);
											$("#hidden_grandtotal").val(grand_total_float);
											
											$("#subtotal_price").html(subtotal_sell);
											$("#hidden_subtotal_price").val(subtotal_sell_float);
											
											$("#subtotal_disc").html(subtotal_sell_disc);
											$("#hidden_subtotal_disc").val(subtotal_sell_disc_float);
											
											$("#subtotal_tax").html(subtotal_tax);
											$("#hidden_subtotal_tax").val(subtotal_tax_float);
											
											//console.log("subtotal_tax_float = "+subtotal_tax_float+" subtotal_sell_disc = "+subtotal_sell_disc_float);
											
											$("#grand_total").html(grand_total);
											$("#hidden_grandtotal").val(grand_total_float);
											
											$("#pay_amount_code_text").html(currency_cd);
											$("#subtotal_price_code_text").html(currency_cd);
											$("#subtotal_disc_code_text").html(currency_cd);
											$("#subtotal_tax_code_text").html(currency_cd);
											$("#grand_total_code_text").html(currency_cd);
											
											$("#payment_check_box").attr("checked", false);
											$("#pay_percent_text").val("");
									    	$("#pay_amount_text").html("");
									    	$("#hidden_payment_amount_text").val("");
											
											$("#currency_kurs_text").val(currency_kurs);
											$("#tax_kurs_text").val(tax_kurs);
											
									    	hidePay();
											hideSub();
											
											$("#used_dp_text").val(0);
											$("#grandtotal").hide();
											
											if(currency_kurs==""||currency_kurs==null)
											{
												$("#currency_kurs_text").val("");
											}
											else 
											{
												$("#currency_kurs_text").val(currency_kurs);
											}
											
											if(tax_kurs==""||tax_kurs==null)
											{
												$("#tax_kurs_text").val("");
											}
											else
											{
												$("#tax_kurs_text").val(tax_kurs);
											}
											
											if(jsondata.remaining_dp==null||jsondata.remaining_dp=="")
											{
												$("#used_dp_span").html("");
											}
											else
											{
												$("#used_dp_span").html(jsondata.remaining_dp);
											}
											
											if(so_cd==""||so_cd==null)
											{
												$("#pay_amount_text").html("");
												$("#hidden_payment_amount_text").val("");
												$("#pay_percent_text").val("");
											}
											
											if($("#used_dp_text").val()=="")
												$("#used_dp_text").val(0);
											
											if(top==null||top=="")
											{
												$("#top_text").val("");
											}
											else {
												$("#top_text").val(top);
											}
											
											if(is_tax==1)
											{
												showPrefix();
											}
											else
											{
												hidePrefix();
											}
	                					}')
						));
						else: 
							echo $model->so_cd;
							echo $form->hiddenField($model,'so_cd');
						endif;
						//$url = CHtml::normalizeUrl(array('/sales/soinvoice/browseso','id'=>$model->so_cd));
						//echo "  ".CHtml::link('browse', "",array('id'=>'browse_so'));
				?>
			<?php echo $form->error($model,'so_cd'); ?>
		</div>
		
		<div class="row" id="prefix_div" style="display: <?php echo ($model->is_tax==1)?"":"none" ?>">
			<?php echo $form->labelEx($model,'prefix_fp'); ?>
			<?php if($model->isNewRecord): ?>
			<?php echo $form->dropDownList($model, 'prefix_fp', array(PrefixFp::Umum=>'010 - Umum',PrefixFp::Bumn1=>'020 - Bendahara Negara (BUMN)',PrefixFp::Bumn2=>'030 - Bendahara Negara (BUMN)',PrefixFp::DPP_Nilai_Lain=>'040 - DPP Nilai Lain', PrefixFp::Kawasan_Berikat=>'060 - Kawasan Berikat', PrefixFp::Yang_Tidak_Dipungut_PPN=>'070 - Yang Tidak Dipungut PPN', PrefixFp::Lembaga_Asing=>'080 - Lembaga Asing'),array('prompt'=>'-Select Prefix-', 'id'=>'prefix_dd'));  ?>                                                                                                      
			<?php else:
				if (!empty($model->prefix_fp))
				{
					$temp = PrefixFp::$prefixFaktur[$model->prefix_fp];
					echo $model->prefix_fp.'-'.$temp;
				}
				endif;
			?>
		</div>

		<div class="row">
			<?php echo $form->label($model,'Client'); ?>
			<span id="client_name">
				<?php 
					if(!empty($model->client_cd)){
						$client = Client::model()->find("client_cd = '".$model->client_cd."'");
						echo $model->client_cd." - ".$client->client_name;
					}
				?>
			</span> <br />
				<?php echo $form->hiddenField($model,'client_cd',array('id'=>'hidclient_name')); ?>
				<?php echo $form->error($model,'client_cd'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'invoice_contact_id'); ?>
			<?php
				if($model->isNewRecord)
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
			<?php echo $form->error($model,'invoice_contact_id'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'invoice_address_id'); ?>
			<?php
				if($model->isNewRecord)
				{
					echo $form->dropDownList($model, 'invoice_address_id',array(),
									 array('prompt'=>'-Select Contact-','id'=>'cmbinvoiceaddress'/*,
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
			<?php echo $form->error($model,'invoice_address_id'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'signed_by'); ?>
			<?php echo $form->dropDownList($model, 'signed_by', CHtml::listData(Employee::model()->findAll(array('condition'=>"employee_type = 'BOD' OR employee_name='Herlina Xu'",'order'=>'employee_name ASC')), 'employee_cd', 'employee_name'), array('prompt'=>'-Select Employee-')); ?>
			<?php echo $form->error($model,'signed_by'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'soinvoice_dt'); ?>
			<?php $this->widget('application.extensions.widget.JuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'soinvoice_dt',
                    'htmlOptions' => array
                    	(
		                    'id' => 'soinvoice_dt_picker',
		                ),
                   )); ?>
			<?php echo $form->error($model,'soinvoice_dt'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'top'); ?>
			<?php echo $form->textField($model,'top',array('size'=>19,'id'=>'top_text')); ?>
			<?php echo $form->error($model,'top'); ?>
		</div>
		
		<br />
		
		<div class="row">
			<?php echo $form->labelEx($model,'tax_kurs'); ?>
			<?php echo $form->textField($model,'tax_kurs',array('id'=>'tax_kurs_text','class'=>'col-right tnumber')); ?>
			<?php echo $form->error($model,'tax_kurs'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'currency_kurs'); ?>
			<?php echo $form->textField($model,'currency_kurs',array('id'=>'currency_kurs_text','class'=>'col-right tnumber')); ?>
			<?php echo $form->error($model,'currency_kurs'); ?>
		</div>
		
		<br />
		
		<div class="row">
			<?php echo $form->label($model,'is_down_payment'); ?>
			<?php if($model->isNewRecord) 
					echo $form->checkBox($model,'is_down_payment', array('value'=>1, 'uncheckValue'=>0,'id'=>'payment_check_box','onchange'=>'javascript:change()')).' Yes';
				  else 
					echo ($model->is_down_payment==0? 'No' : 'Yes'); ?>
			<?php echo $form->error($model,'is_down_payment'); ?>
		</div>
		
		<div class="row" id="subtotalPrice" <?php echo ($model->is_down_payment == 0)? "style='display:none'": ""; ?>>
			<?php echo $form->label($model,'subtotal_price'); ?>
			<span id="subtotal_price_code_text">
				<?php if($model->currency_cd!="")
				{
					echo $model->currency_cd;
				}?>
			</span>
			<span id='subtotal_price'>
				<?php 
					if(!$model->isNewRecord||!empty($model->subtotal_price))
					{
						echo number_format($model->subtotal_price,2,".",",");
						
					}
				?>
			</span> <br />
			<?php echo $form->hiddenField($model,'subtotal_price',array('id'=>'hidden_subtotal_price')); ?>
		</div>
		
		<div class="row" id="subtotalDisc" <?php echo ($model->is_down_payment == 0)? "style='display:none'": ""; ?>>
			<?php echo $form->label($model,'subtotal_disc'); ?>
			<span id="subtotal_disc_code_text">
				<?php if($model->currency_cd!="")
				{
					echo $model->currency_cd;
				}?>
			</span>
			
			<span id='subtotal_disc'>
				<?php
					if(!$model->isNewRecord||!empty($model->subtotal_disc))
					{
						echo number_format($model->subtotal_disc,2,".",",");
						//echo $model->subtotal_disc;
					}
				?>
			</span> <br />
			<?php echo $form->hiddenField($model,'subtotal_disc',array('id'=>'hidden_subtotal_disc')); ?>
		</div>
		
		<div class="row" id="subtotalTax" <?php echo ($model->is_down_payment == 0)? "style='display:none'": ""; ?>>
			<?php echo $form->label($model,'subtotal_tax'); ?>
			<span id="subtotal_tax_code_text">
				<?php if($model->currency_cd!="")
				{
					echo $model->currency_cd;
				}?>
			</span>
			<span id='subtotal_tax'>
				<?php 
					if(!$model->isNewRecord||!empty($model->subtotal_tax))
					{
						echo number_format($model->subtotal_tax,2,".",",");
						//echo $model->subtotal_tax;
					}
				?>
			</span> <br />
			<?php echo $form->hiddenField($model,'subtotal_tax',array('id'=>'hidden_subtotal_tax')); ?>
		</div>
		
		<div class="row"id="grandtotal" <?php echo ($model->is_down_payment == 0)? "style='display:none'": ""; ?>>
			<?php echo $form->labelEx($model,'grandtotal_price'); ?>
			<span id="grand_total_code_text">
				<?php if($model->currency_cd!="")
				{
					echo $model->currency_cd;
				}?>
			</span>
			<span id='grand_total'>
				<?php 
					if(!$model->isNewRecord||!empty($model->grandtotal_price))
					{
						echo number_format($model->grandtotal_price,2,".",",");
						//echo $model->grandtotal_price;
					}
				?>
			</span> <br />
			<?php echo $form->hiddenField($model,'grandtotal_price',array('id'=>'hidden_grandtotal')); ?>
			<?php echo $form->error($model,'grandtotal_price'); ?>
		</div>

		<br/>
		
		<div class="row" id="pay_percent" <?php echo ($model->is_down_payment == 0)? "style='display:none'": ""; ?>>
			<?php echo $form->labelEx($model,'payment_percent'); ?>
			<?php if($model->isNewRecord):?>
				<?php echo $form->textField($model,'payment_percent',array('size'=>5,'maxlength'=>5,'id'=>'pay_percent_text','onchange'=>'javascript:fillAmount()')); ?> <span>%</span>
			<?php elseif($model->is_down_payment==1 && !$model->isNewRecord):?>
				<?php echo $model->payment_percent; ?><span>%</span>
			<?php endif; ?>
			<?php echo $form->error($model,'payment_percent'); ?>
		</div>
	
		<?php echo $form->hiddenField($model,'currency_cd',array('id'=>'hidden_currency_cd')); ?>
		
		<div class="row" id="pay_amount" <?php echo ($model->is_down_payment == 0)? "style='display:none'": ""; ?>>
			<?php echo $form->labelEx($model,'payment_amount'); ?>
			<span id="pay_amount_code_text">
				<?php if($model->currency_cd!="")
				{
					echo $model->currency_cd;
				}?>
			</span>
			<span id="pay_amount_text">
				<?php if($model->payment_amount!=""):  ?>
					<?php echo $model->payment_amount; ?>
				<?php endif; ?>
			</span> <br />
			<?php echo $form->hiddenField($model,'payment_amount',array('id'=>'hidden_payment_amount')); ?>
			<?php echo $form->error($model,'payment_amount'); ?>
		</div>
		
		<div class="row" id="used_dp">
			<?php if($model->isNewRecord||$model->is_down_payment==0):?>		<!-- Validasi untuk update, hilangkan field used dp jika is down payment tidak dicentang -->
			<?php echo $form->labelEx($model,'used_dp'); ?>
			<?php echo $form->textField($model,'used_dp',array('min'=>0,'size'=>19,'maxlength'=>19,'id'=>'used_dp_text','style'=>'display:none')); ?> 
			<span id="used_dp_span">
				<!-- Edit Max Dp Here -->
				<?php
					if(!$model->isNewRecord)
					{
						if($model->so->remaining_dp==null)
						{
							echo "0";
						}//end if model->so->remaining_dp
						else 
						{
							$so_dp = $model->so->remaining_dp;
							//$soinvoice_dp = DAO::queryRowSql("SELECT IFNULL(used_dp,0) AS used_dp FROM tdpsoinvoice WHERE soinvoice_cd = '$model->soinvoice_cd'");
							//$max_dp = $so_dp + $soinvoice_dp['used_dp'];
							echo  Yii::app()->format->formatNumber($so_dp);
						}//end else
					}//end if model is new record
					else
					{
						if(!empty($model->so_cd))
						{
							$so = So::model()->findByPk($model->so_cd); //select * from So where (primary key) = $so_cd
							echo  Yii::app()->format->formatNumber($so->remaining_dp);
							
						}//end if empty
					}//end else
				?>
			</span>
			<?php echo $form->error($model,'used_dp'); ?>
			<?php endif;?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'invoice_file_name'); ?>
 			<?php
					if(!$model->isNewRecord) 
					{
						if($model->invoice_file_name!='')
						{
							echo CHtml::link($model->invoice_file_name, FileUpload::getHttpPath($model->soinvoice_cd, FileUpload::CLIENT_SOINVOICE_PATH), array('id'=>'file_link'));
							//'<a id="file_link" href="'.Yii::app()->request->baseUrl."/upload/client_po/".$model->client_po_clientfile.'" target="_blank">'.$model->client_po_clientfile.'</a>';
							echo ' '. CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete_red.png'), 'javascript://', array('id'=>'del_file1'))."<br/>" ;
							echo $form->label($model,'&nbsp');
						}
					}
				?>
				<?php echo CHTML::activeFileField($model, 'invoice_file_name');?>
				<?php echo $form->error($model,'invoice_file_name');
			?>
        </div>
        
        <div class="row">
			<?php echo $form->labelEx($model,'fp_file_name'); ?>
 			<?php
					if(!$model->isNewRecord) 
					{
						if($model->fp_file_name!='')
						{
							echo CHtml::link($model->fp_file_name, FileUpload::getHttpPath($model->soinvoice_cd, FileUpload::CLIENT_SOINVOICE_PATH), array('id'=>'file_link'));
							//'<a id="file_link" href="'.Yii::app()->request->baseUrl."/upload/client_po/".$model->client_po_clientfile.'" target="_blank">'.$model->client_po_clientfile.'</a>';
							echo ' '. CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete_red.png'), 'javascript://', array('id'=>'del_file2'))."<br/>" ;
							echo $form->label($model,'&nbsp');
						}
					}
				?>
				<?php echo CHTML::activeFileField($model, 'fp_file_name');?>
				<?php echo $form->error($model,'fp_file_name');
			?>
        </div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'notes'); ?>
			<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'notes'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div>
</div><!-- form -->


<div id="grid-detail">
	<!-- Tabel detail poinvoicedetail -->
</div>

<?php
	$total = $model->grandtotal_price;
	if(!$model->isNewRecord && $model->is_down_payment==1):
		echo '<script type="text/javascript">'
			   ,'showPay();'
			   ,'$("#grandtotal").show();'
			   ,'showSub();'
			   ,'$("#used_dp").hide();'
			   ,"$('#hidden_grandtotal').val('$total');"
			   , '</script>';
	endif;
	
	if(!$model->isNewRecord && $model->is_down_payment==0):
		echo "<script>"
		 	,'$("#grandtotal").show();'
		    ,'showSub();'
		 	,'$("#used_dp").show();'
			,"$('#hidden_grandtotal').val('$total');"
			,"</script>";
	endif;
?>
	












