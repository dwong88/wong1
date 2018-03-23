<style>
	/*================Layout===================*/
	#wrapper{ font-family:Arial, Helvetica, sans-serif;width:90%;margin:auto;font-size:8px; }
	#company_name{ font-size:12px;font-weight:bold; }
	#title{ font-size:14px;font-weight:bold;text-align:center; }
	#faktur_header{ width:100%;height:auto;margin-bottom:10px; }
	.left{ float:left;height:auto;width:49%; }
	.right{ float:right;height:auto;width:49%;}
	#content{ border:1px solid;height:auto; }
	#data_header { padding:10px;}
	#data_detail{ padding: 5px 0 5px 0;margin:auto;width:99%; }
	#footer{ width:100%;height:auto;}
	.value{ border:none; }
	
	/*================Property===================*/
	.row{width:100%;height:auto;}
	.label{width:49%;float:left;height:auto;padding-top:1px;}
	.fill{width:49%;border-bottom:1px solid;float:right;height:auto;text-align:left;}
	.clear{ clear:both; }
	table{ font-size:8px;}
	textarea{ margin:5px;font-family:Arial, Helvetica, sans-serif;overflow:hidden;width:95%;resize:none;font-size:8px;height:20px; }
	input{ margin:5px;margin-top:0px;overflow:hidden;width:95%;resize:none;font-size:8px;height:20px; }
	/*==============Table property===============*/
	.mystyle
	{
		width:90%;
		margin:auto;
		border-width: 0 0 1px 1px;
		border-spacing: 0;
		border-collapse: collapse;
		border-style: solid;
	}
	.mystyle td, .mystyle th
	{
		margin: 0;
		padding: 4px;
		border-width: 1px 1px 0 0;
		border-style: solid;
		border:1px solid;
	}
	
	/*==============Print property===============*/
	@media print{ input{ border:0px;resize:none;margin:5px;font-size:8px; }}
</style>
<script>
	window.onload = function()
	{
		var elements = document.getElementsByTagName("textarea");
		for(var i=0;i<elements.length;i++)
			autoresize(elements[i]);
	};
	function autoresize(textarea) {
        textarea.style.height = '24px';
        textarea.style.height = textarea.scrollHeight + 12 + 'px';
    }
</script>
<div id="wrapper">
	<div id="header">
	<?php
		$pph23 = 0;
		$pph25 = 0;
		$ppn = 0;
    ?>
    	<div id="title">
			FORM TITIPAN
		</div>
		<div id="faktur_header">
			<div class="left">
				<div class="row">
					<div class="label" style="width:19%;">No.SO</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->so_cd)){ echo $header->so_cd;}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Penerima Titipan</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;">&nbsp;</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Detail Bank Penerima</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;">&nbsp;</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Total Titipan</div></div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:20%;float:left;margin-left:10px;">
						<table width="20%" >
							<tr>
								<td width="50%" style="border:none;">
									<?php
						        		$symbol = DAO::queryRowSql("SELECT * FROM tdpcurrency WHERE currency_cd='".$header->titipan_currency."'");
							        	echo $symbol['symbol']; 
							        ?>
								</td>
		                        <td width="50%" style="text-align:right;border:none;"><?php echo number_format($header->total_titipan, 2, '.', ','); ?></td>
		                    </tr>
		                </table>
                	</div>
				<div class="clear"></div>
				</div>
			</div>
			<div class="right">
				<div class="row">
					<div class="label" style="width:19%;">Sales</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->sales_cd)){ echo $header->employee->employee_name;}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">No.Invoice</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;">
						<?php
							echo $invoice->soinvoice_cd;
			        	?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Customer</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->client->client_name)){ echo $header->client->client_name;}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div><br />
	<table class="mystyle">
		<tr>
			<th width="45%">Item Barang</th>
	    	<th width="10%">Qty</th>
	    	<th width="15%">Harga Beli</th>
	    	<th width="15%">Harga Jual</th>
	    	<th width="15%">Titipan</th>
		</tr>
		<?php
		    $disc = 0;
			foreach($detail as $datadetail)
			{
				$disc += $datadetail->discount_amt;
				$item = Item::model()->find("item_cd ='".$datadetail['item_cd']."'");
	    ?>
	    <tr><!-- Cotent tabel -->
	    	<td valign="top">
				<b><?php echo $item->item_name." - ".$item->item_cd; ?></b>
	        </td>
	    	<td valign="top"><?php echo number_format($datadetail['qty'], 0, '.', ',')." ".$item->itemmeasurement_name; ?></td>
	        <td valign="top">
	        	<table width="100%">
				    <tr>
				        <td width="50%" style="border:none;">
					        <?php
				        		$symbol = DAO::queryRowSql("SELECT * FROM tdpcurrency WHERE currency_cd='".$datadetail['cost_currency']."'");
					        	echo $symbol['symbol']; 
					        ?>
				        </td>
	                    <td width="50%" style="text-align:right;border:none;"><?php echo number_format($datadetail['total_cost_price']/$datadetail['cost_kurs'], 2, '.', ','); ?></td>
	                </tr>
	            </table>
	        </td>
	        <td valign="top">
	        	<table width="100%" class="value">
		        	<tr>
			        	<td width="50%" style="border:none;"><?php echo $header->symbol->symbol; ?></td>
	                    <td width="50%" style="text-align:right;border:none;"><?php echo number_format($datadetail['sell_price'], 2, '.', ','); ?></td>
	                </tr>
	            </table>
	        </td>
	        <td valign="top" height="20">
        		<table width="100%" style="margin-top:0px;">
					<tr>
						<td width="50%" style="border:none;">
							<?php
				        		$symbol = DAO::queryRowSql("SELECT * FROM tdpcurrency WHERE currency_cd='".$header->titipan_currency."'");
					        	echo "<input type='text' style='width:25px;' value='".$symbol['symbol']."' />"; 
					        ?>
						</td>
                        <td width="50%" style="text-align:right;border:none;"><input type="text" /></td>
                    </tr>
                </table>
	        </td>
	    </tr>
	   <?php
			}
	    ?>
	</div>
	<div id="footer">
		<table width="100%">
			<tr>
		    	<td style="text-align:center;" width="30%"> Dibuat Oleh<br /><br /><br /><br /><br />(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		        <td style="text-align:center;" width="30%"> Diketahui Oleh<br /><br /><br /><br /><br />(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		        <td style="text-align:center;" width="30%"> Diterima Oleh<br /><br /><br /><br /><br />(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		    </tr>
		</table>
	</div>
</div>