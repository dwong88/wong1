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
	textarea{ margin:5px;font-family:Arial, Helvetica, sans-serif;overflow:hidden;width:95%;resize:none;font-size:8px; }
	
	/*==============Table property===============*/
	.mystyle
	{
		width:99%;
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
	@media print{ textarea{ border:0px;resize:none;margin:5px; }}
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
			SALES ORDER
		</div>
		<div id="faktur_header">
			<div class="left">
				<div class="row">
					<div class="label" style="width:19%;">Customer</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->client->client_name)){ echo $header->client->client_name." - ".$header->client->client_cd;}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Address</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->deliveryAddress->address)){ echo nl2br($header->deliveryAddress->address);}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Telepon</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->client->phone)){ echo $header->client->phone;}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">TOP</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->top)){ echo $header->top;}else{echo "&nbsp;";} ?> day(s)</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Currency</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->sell_currency)){ echo $header->symbol->currency_cd;}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="right">
				<div class="row">
					<div class="label" style="width:19%;">No. SO</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if(!empty($header->so_cd)){ echo $header->so_cd;}else{echo "&nbsp;";} ?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Date</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;">
						<?php
				        	$date = new DateTime();
				        	$result = $date->format('d-M-Y');
				        	echo $result;
			        	?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">Sales</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php echo $header->employee->employee_name; ?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="label" style="width:19%;">NO. PO</div>
					<div style="float:left;"> : </div>
					<div class="fill" style="width:79%;"><?php if($header->client_po_no != ""){echo $header->client_po_no;}else {echo "&nbsp;";}?></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="content">
		<div id="data_detail">
			<table class="mystyle">
				<tr>
					<th width="5%">No.</th>
			    	<th width="35%">Desc</th>
			    	<th width="5%">Qty</th>
			    	<th width="15%">Unit Sell Price</th>
			    	<th width="15%">Total Sell</th>
			    	<th width="15%">Total Cost</th>
			    	<th width="15%">Vendor</th>
				</tr>
				<?php
			    	$count = 1;
				    $disc = 0;
					foreach($detail as $datadetail)
					{
						$disc += $datadetail->discount_amt;
						$item = Item::model()->find("item_cd ='".$datadetail['item_cd']."'");
			    ?>
			    <tr><!-- Cotent tabel -->
			    	<td valign="top">
			    		<?php echo $count;?>
			    	</td>
			    	<td valign="top">
						<b><?php echo $item->item_name." - ".$item->item_cd; ?></b><br />
						<textarea onkeyup="autoresize(this)"><?php echo $datadetail['item']['item_desc']; ?></textarea>
			            <?php
							if($datadetail->product_number != "" || $datadetail->product_number != NULL)
			            		echo "Part No : ".$datadetail['product_number']."<br />";
						?>
			            <?php echo $datadetail['item_desc']."<br /><br />"; ?>
			            <?php
							if($datadetail->notes != "" || $datadetail->notes != NULL)
			            		echo "Part No : ".$datadetail['notes']."<br />";
						?>
			        </td>
			    	<td valign="top"><?php echo number_format($datadetail['qty'], 0, '.', ',')." ".$item->itemmeasurement_name; ?></td>
			        <td valign="top">
					   	<table width="100%" class="value">
				        	<tr>
					        	<td width="50%" style="border:none;"><?php echo $header->symbol->symbol; ?></td>
			                    <td width="50%" style="text-align:right;border:none;"><?php echo number_format($datadetail['sell_price'], 2, '.', ','); ?></td>
			                </tr>
			            </table>
			        </td>
			        <td valign="top">
		        			<table width="100%" >
							    <tr>
							        <td width="50%" style="border:none;"><?php echo $header->symbol->symbol; ?></td>
		                            <td width="50%" style="text-align:right;border:none;"><?php echo number_format($datadetail['total_sell_price'], 2, '.', ','); ?></td>
		                        </tr>
		                    </table>
			            <?php
							$sell_tax = "";
							if($datadetail->sell_tax_cd1 != "" || $datadetail->sell_tax_cd1 != NULL)
							{
								if($datadetail->sell_tax_cd2 != "" || $datadetail->sell_tax_cd2 != NULL)
			            			$sell_tax .= $datadetail['sell_tax_cd1'].", ";
								else
									$sell_tax .= $datadetail['sell_tax_cd1'];
							}
							if($datadetail->sell_tax_cd2 != "" || $datadetail->sell_tax_cd2 != NULL)
								$sell_tax .= $datadetail['sell_tax_cd2'];
							echo $sell_tax;
						?>
			        </td>
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
			        	
			            <?php
							$cost_tax = "";
							if($datadetail->cost_tax_cd1 != "" || $datadetail->cost_tax_cd1 != NULL)
							{
								if($datadetail->cost_tax_cd2 != "" || $datadetail->cost_tax_cd2 != NULL)
			            			$cost_tax .= $datadetail['cost_tax_cd1'].", ";
								else
									$cost_tax .= $datadetail['cost_tax_cd1'];
							}
							if($datadetail->cost_tax_cd2 != "" || $datadetail->cost_tax_cd2 != NULL)
								$cost_tax .= $datadetail['cost_tax_cd2'];
							echo $cost_tax;
						?>
			        </td>
			        <td valign="top"><?php echo $datadetail['vendor']['vendor_name']; ?></td>
			    </tr>
			   <?php
			   		$count++;
					}
			    ?>
			</table>
			<div style="width:100%;">
				<div class="left">
					<div class="row">
						<div class="label">Notes</div>
						<div style="float:left;"> : </div>
						<div class="fill"><?php if($header->notes != ""){echo $header->notes;}else {echo "&nbsp;";}?></div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="label">Delivery Date</div>
						<div style="float:left;"> : </div>
						<div class="fill">
							<?php
							if(!empty($header->est_delivery_dt))
							{
				        		$oFormatter = new Formatter();
				        		echo $oFormatter->formatDate($header->est_delivery_dt);
							}
							else
								echo "&nbsp;";
				        	?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="label">Expedisi</div>
						<div style="float:left;"> : </div>
						<div class="fill"><?php if($header->expedisi_cd != ""){echo $header->expedisi->expedisi_name." - ".$header->expedisi_cd;}else {echo "&nbsp;";}?></div>
						<div class="label"><H1><?php echo ($header->is_indent == 0)? " " : "INDENT" ;?></H1></div>
						<div class="clear"></div>
					</div>
				</div>
			<div class="right">
				<div class="row">
					<div class="label">Subtotal Sales</div>
					<div style="float:left;"> : </div>
					<div class="fill">
						<table width="100%">
					        <tr>
					        	<td width="50%" style="border:none;"><?php echo $header->symbol->symbol; ?></td>
				                <td width="50%" style="text-align:right;border:none;"><?php echo number_format($header->subtotal_sell, 2, '.', ','); ?></td>
				            </tr>
				        </table>
				    </div>
				    <div class="clear"></div>
				</div>
			    <div class="row">
					<div class="label">Discount</div>
					<div style="float:left;"> : </div>
					<div class="fill">
						<table  width="100%">
			        		<tr>
			        			<td width="50%" style="border:none;"><?php echo $header->symbol->symbol; ?></td>
			        			<td width="50%" style="text-align:right;border:none;"><?php echo number_format($disc, 2, '.', ','); ?></td>
			        		</tr>
			        	</table>
					</div>
					<div class="clear"></div>
				</div>
				<?php
			 	   	$i=0;
			 	   	$tax_amt = 0;
			    	$query = "SELECT * FROM tdpsotax WHERE so_cd = '".$header->so_cd."' ORDER BY tax_cd DESC";
			    	$result = DAO::querySql($query);
			    	foreach($result as $tax)
			    	{
			    		$tax_amt += floatval( $tax['tax_amount']);
			    		if($i==0)
			    		{
			    ?>
			    		<div class="row">
							<div class="label"><?php echo $tax['tax_cd']; ?></div>
							<div style="float:left;"> : </div>
							<div class="fill">
					            <table  width="100%">
					        		<tr>
					        			<td width="50%" style="border:none;"><?php echo $header->symbol->symbol; ?></td>
					        			<td width="50%" style="text-align:right;border:none;"><?php echo number_format($tax['tax_amount'], 2, '.', ','); ?></td>
					        		</tr>
					        	</table>
							</div>
							<div class="clear"></div>
						</div>
					<?php
			    		}
			    		else
			    		{
			   		 ?>
			   		 	<div class="row">
							<div class="label"><?php echo $tax['tax_cd']; ?></div>
							<div style="float:left;"> : </div>
							<div class="fill">
								<table  width="100%">
					        		<tr>
					        			<td width="50%" style="border:none;"><?php echo $header->symbol->symbol; ?></td>
					        			<td width="50%" style="text-align:right;border:none;"><?php echo number_format($tax['tax_amount'], 2, '.', ','); ?></td>
					        		</tr>
					        	</table>
							</div>
							<div class="clear"></div>
						</div>
						<?php
			    		}
			    		
			    		
			    		$i++;
			    	}
			    ?>
			    <div class="row">
			    	<div class="label">Total</div>
					<div style="float:left;"> : </div>
					<div class="fill">
						<table  width="100%">
			        		<tr>
			        			<td width="50%"><?php echo $header->symbol->symbol; ?></td>
			        			<td width="50%" style="text-align:right"><?php echo number_format($header->subtotal_sell+$tax_amt-$disc, 2, '.', ','); ?></td>
			        		</tr>
			        	</table>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		<table>
			<tr>
		    	<td colspan="4" style="text-align:center;"> Salesman<br /><br /><br /><br /><br />(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		        <td colspan="4" style="text-align:center;"> Approved<br /><br /><br /><br /><br />(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		    </tr>
		</table>
	</div>
</div>