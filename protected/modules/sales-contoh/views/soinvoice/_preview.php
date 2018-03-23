<style>
	/*================Layout===================*/
	#wrapper{ font-family:Arial, Helvetica, sans-serif;width:90%;margin:auto;font-size:8px;border:1px solid;padding:5px; }
	#company_name{ font-size:12px; }
	#title{ font-size:14px;font-weight:bold;text-align:center; }
	#faktur_header{ width:100%;height:auto;margin-bottom:10px; }
	.left{ float:left;height:auto;width:50%; }
	.right{ float:right;height:auto;width:50%;text-align:right; }
	#content{ border:1px solid;height:auto; }
	#data_header { padding:10px;}
	#data_detail{ padding: 5px 0 5px 0;margin:auto;width:100%; }
	#footer{ width:100%;height:auto;padding:10px;}
	
	/*================Property===================*/
	.label{width:49%;float:left;height:auto;}
	.fill{width:49%;border-bottom:1px solid;float:right;height:auto;text-align:left;}
	.clear{ clear:both; }
	table{ font-size:8px;}
	textarea{ margin:5px;font-family:Arial, Helvetica, sans-serif;overflow:hidden;width:95%;resize:none;font-size:8px; }
	
	/*==============Table property===============*/
	.mystyle
	{
		width:99%;
		margin:auto;
		margin-top:10px;
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
		<div class="left">
			<div id="company_name">
				<b><?php echo $company->company_name ?></b><br />
				<?php echo $company->address ?><br />
				<?php echo "Telp : ".$company->phone." Fax : ".$company->phone ?><br />
			</div>
		</div>
		<div class="right">
			<H1>INVOICE</H1>
		</div>
		<div class="clear"></div>
	</div>
	<div id="content">
		<div id="data_header">
			<div class="left">
				<div class="row">
				<div class="label" style="width:19%">Customer</div>
				<div style="float:left;"> : </div>
				<div class="fill" style="width:80%;font-weight:bold;"><?php echo $client->client_name; ?></div>
				<div class="clear"></div>
				</div>
				<div class="row">
				<div class="label" style="width:19%">&nbsp;</div>
				<div style="float:left;"></div>
				<div class="fill" style="width:80%;"><?php if(!empty($client->address)){ echo $client->address; }else{echo "&nbsp;";} ?></div>
				<div class="clear"></div>
				</div>
				<div class="row">
				<div class="label" style="width:19%">&nbsp;</div>
				<div style="float:left;"></div>
				<div class="fill" style="width:80%;"><?php echo "Telp : ".$client->phone." Fax : ".$client->fax; ?></div>
				<div class="clear"></div>
				</div>
				<div class="row">
				<div class="label" style="width:19%">UP</div>
				<div style="float:left;"> : </div>
				<div class="fill" style="width:80%;"><?php if(!empty($client->contact_person)){ echo $client->contact_person; }else{echo "&nbsp;";} ?></div>
				<div class="clear"></div>
				</div>
			</div>
			<div class="right">
				<div class="row"><div class="label" style="text-align: left;width:19%">No Invoice</div>
				<div style="float:left;"> : </div>
				<div class="fill" style="width:80%;"><?php echo $soinvoice->soinvoice_cd; ?></div>
				<div class="row"><div class="label" style="text-align: left;width:19%">Date</div>
				<div style="float:left;"> : </div>
				<div class="fill" style="width:80%;"><?php //echo $formatter = new Formatter(); echo $formatter->formatDate($soinvoice->soinvoice_dt); 
						$newDate = DateTime::createFromFormat("Y-m-d", $soinvoice->soinvoice_dt);
						echo $newDate->format("d M Y");
					?></div>
				<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<table class="mystyle">
		<tr>
	    	<th>No. SO</th>
			<th>No. DO</th>
	    	<th>No. PO</th>
	    </tr>
	    
	    <tr>
	    	<td><?php echo $so->so_cd; ?></td>
	    	<td>
	    		<?php 
	    		if($soinvoice->is_down_payment==0):
	    			foreach($devo as $devoItem)
					{
						echo $devoItem['do_cd']."<br/>";
					}
				endif;
	    		?>
	    	</td>
	    	
	    	<td> <?php echo $so->client_po_no ?> </td>
	    </tr>
	</table>

	<div id="data_detail">
		<table class="mystyle">
			<tr>
				<th width="5%">No.</th>
		    	<th width="30%">Descriptions</th>
		    	<th width="20%">Code</th>
		    	<th width="10%">Qty</th>
		    	<th width="15%">Price</th>
		    	<th width="15%">Total IDR</th>
			</tr>
			<?php
		    	$no=1;$total = 0;
				foreach($itemdata as $item)
				{
		    ?>
		    <tr>
		    	<td style="text-align: left">
		    		<?php echo $no?>
		    	</td>
		    	<td align="left">
		    		<b><?php echo $item['item_name']; ?></b><br />
					<textarea onkeyup="autoresize(this)"><?php echo $item['item_desc']; ?></textarea>
		    	</td>
		    	
		    	<td>
		    		<?php echo $item['product_number']; ?>
		    	</td>
		    	
		    	<td align="center">
		    		<?php echo $item['qty']." ".$item['itemmeasurement_name']; ?>
		    	</td>
		    	
		    	<td align="right">
		    		<table width="100%" >
			    		<tr>
			    			<td width="50%" style="border:none;"><?php echo $symbol->symbol; ?></td>
		    			    <td width="50%" style="text-align:right;border:none;"><?php echo number_format($item['price'], 2, '.', ','); ?></td>
		    		    </tr>
		    		</table>
		    	</td>
		    	
		    	<td align="right">
			    	<table width="100%" >
				    	<tr>
				    		<td width="50%" style="border:none;"><?php echo $symbol->symbol; ?></td>
    			    		<td width="50%" style="text-align:right;border:none;"><?php echo number_format($item['total_price'], 2, '.', ','); ?></td>
    			    	</tr>
    			    </table>
		    		<?php
						$total += $item['total_price'];
		    		?>
		    	</td>
		    </tr>
		   <?php
		    	$no++;
				} 
		    ?>
		    <tr>
		    	<td colspan="2" align="left" valign="top">
		    		<!-- bank detail ???-->
		    		Bank Detail <br />
		    		<?php echo $bank->bank_name ?> <br />
		    		A/C :<?php echo " ".$bank->account_no." / ".$bank->currency; ?> <br />
		    		A/N :<?php echo " ".$bank->beneficiary_name; ?>
		    	</td>
		    	
		    	<td colspan="3" align="right" valign="top">
		    		<?php 
		    			if($soinvoice->is_down_payment==1)
						{
							echo "<br/>";
						}
		    		?>
		    		<div>Sub Total </div>
		    		<div>Discount</div>
		    		<?php foreach($soinvoicetax as $taxItem) 
		    		{
							echo "<div>Tax ( ".$taxItem['tax_cd']." )</div>";
		    		} ?>
		    		<?php
		    			if($soinvoice->is_down_payment==0)
		    			{
		    				echo "<div>Used Dp </div>";
		    			}
		    		?>
		    		<div>Total</div>
		    	</td>
		    	
		    	<td align="right" valign="top">
		    		<?php
		    		
		    		/*$discount = $soinvoice->discount_value;
		    		
		    		if($soinvoice->discount_type == 1)
					{
						$discount = ($discount/100)*$total;
					}*/
					
					$tax = 0;
		    		$grand_total = 0;
					$discount = $soinvoicedetail['discount_amt'];
					$used_dp = 0;
					
					if($soinvoice->is_down_payment==1)
					{
						$persen = ($soinvoice->payment_percent)/100;
						$discount = $persen * $discount;
						$total = $persen * $total;
						echo "<center><b> DP ".$soinvoice->payment_percent."%</center></b>";
					}
					
		    		?>
		    		<div>
		    			<div style="float:left;"><?php echo $symbol->symbol; ?></div>
    				   	<div style="float:right;"><?php echo number_format($total, 2, '.', ','); ?></div>
    				   	<div class="clear"></div>
    				</div>
    				<div>
		    			<div style="float:left;"><?php echo $symbol->symbol; ?></div>
    				   	<div style="float:right;"><?php echo number_format($discount, 2, '.', ','); ?></div>
    				   	<div class="clear"></div>
    				</div>
		    		<?php
			    		foreach($soinvoicetax as $taxItem) 
			    		{
		    				$tax += $taxItem['tax_amount'];
		    			?>
		    				<div>
				    			<div style="float:left;"><?php echo $symbol->symbol; ?></div>
		    				   	<div style="float:right;"><?php echo number_format($taxItem['tax_amount'], 2, '.', ','); ?></div>
		    				   	<div class="clear"></div>
		    				</div>
						<?php
			    		}
						if($soinvoice->is_down_payment==0)
						{
							$used_dp = $soinvoice->used_dp;
						?>
							<div>
		    					<div style="float:left;"><?php echo $symbol->symbol; ?></div>
    				   			<div style="float:right;"><?php echo number_format($used_dp, 2, '.', ','); ?></div>
		    				   	<div class="clear"></div>
		    				</div>
						<?php
						}
			    		$grand_total = $total - $discount + $tax - $used_dp;
			    		?>
			    		<div>
		    				<div style="float:left;"><?php echo $symbol->symbol; ?></div>
    				   		<div style="float:right;"><?php echo number_format($grand_total, 2, '.', ','); ?></div>
	    				   	<div class="clear"></div>
	    				</div>
		    	</td>
		    </tr>
		    
		    <tr>
				<td colspan="6">
					<i>Amount In Words : 
					<?php
					$a= (string)number_format($grand_total, 2, '.',',');

					$temp = strstr($a,'.');
					$coma = substr($temp,-2,2);
					
					if($coma=='00') $coma = 0;
					
					//$bil = strstr($a,'.',true);
					$bil = $grand_total;
					
					//echo "grand_total = ".$grand_total."temp = ".$temp." coma = ".$coma."<br/>";
								
					function Terbilang($satuan)
					{
						$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
						if ($satuan < 12)
						return " " . $huruf[$satuan];
						elseif ($satuan < 20)
						return Terbilang($satuan - 10) . "Belas";
						elseif ($satuan < 100)
						return Terbilang($satuan / 10) . " Puluh" . Terbilang($satuan % 10);
						elseif ($satuan < 200)
						return " seratus" . Terbilang($satuan - 100);
						elseif ($satuan < 1000)
						return Terbilang($satuan / 100) . " Ratus" . Terbilang($satuan % 100);
						elseif ($satuan < 2000)
						return " seribu" . Terbilang($satuan - 1000);
						elseif ($satuan < 1000000)
						return Terbilang($satuan / 1000) . " Ribu" . Terbilang($satuan % 1000);
						elseif ($satuan < 1000000000)
						return Terbilang($satuan / 1000000) . " Juta" . Terbilang($satuan % 1000000);
						elseif ($satuan < 10000000000)
						return Terbilang($satuan / 10000000) . " Milyar" . Terbilang($satuan % 10000000);
						elseif ($satuan < 100000000000)
						return Terbilang($satuan / 100000000) . " Triliun" . Terbilang($satuan % 10000000);
						elseif ($satuan <= 1000000000000)
						echo "Maaf Tidak Dapat di Prose Karena Jumlah Uang Terlalu Besar ";
					}
					function Koma($satuan)
					{
						$huruf = array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
						return " " . $huruf[$satuan];
					}
					
					if($soinvoice->currency_cd=='USD')
						$curency="Dolar Amerika";
					elseif($soinvoice->currency_cd=='IDR')
						$curency="Rupiah";
					elseif($soinvoice->currency_cd=='SGD') {
						$curency="SGD";
					}
					else {
						$currency='';
					}
					/*
					 * untuk terbilang dengan koma 
					 *echo Terbilang($a)." Koma ".Koma(substr($a,-2,1)).Koma(substr($a,-1))." Rupiah";
					 */
					if(empty($coma))
					{
						#bilangan tidak memiliki koma
						echo Terbilang($bil)." ".$curency;
						#echo $grand_total;
					}
					else
					{
						#bilangan memiliki koma
						echo Terbilang($bil)." Koma ".Terbilang($coma)." ".$curency;
						#echo $grand_total;
					}
					
					?>
					</i> 
				</td>
			</tr>
		</table>
	</div>
	<div id="footer">
		<table width="100%">
			<tr>
				<td>
					<?php $formatter = new Formatter(); echo "Due Date : ".$formatter->formatDate($soinvoice->due_date)  ?>
				</td>
			</tr>
			<tr>
				<td width="80%">
					1. Pembayaran harus dilakukan sesuai dengan mata uang yang tertera di invoice (Full Amount)<br />
					2. Mohon mencantumkan nomor invoice apabila melakukan pembayaran secara transfer bank
				</td>
				<td width="20%" style="text-align:center;">
					Regards, <br /><br /><br /><br /><br /><br /><br /><br />
					<?php echo $employee->employee_name;?>
				</td>
			</tr>
		</table>
	</div>
</div>