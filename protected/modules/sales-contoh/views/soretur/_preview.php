<style>
	/*================Layout===================*/
	#wrapper{ font-family:Arial, Helvetica, sans-serif;width:90%;margin:auto;font-size:8px; }
	#company_name{ font-size:12px;font-weight:bold; }
	#title{ font-size:14px;font-weight:bold;text-align:center; }
	#faktur_header{ width:100%;height:auto;margin-bottom:10px; }
	.left{ float:left;height:auto;width:49%; }
	.right{ float:right;height:auto;width:49%;text-align:right; }
	#content{ height:auto; }
	#data_header { padding:10px;}
	#data_detail{ padding: 5px 0 5px 0;margin:auto;width:100%; }
	#footer{ width:100%;height:auto;}
	
	/*================Property===================*/
	.label{width:49%;float:left;height:14px;}
	.fill{width:49%;border-bottom:1px solid;float:right;height:14px;text-align:left;}
	.clear{ clear:both; }
	table{ font-size:8px;}
	textarea{ margin:5px;font-family:Arial, Helvetica, sans-serif;overflow:hidden;width:95%;resize:none;font-size:8px; }
	
	/*==============Table property===============*/
	.mystyle
	{
		width:100%;
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
		<div id="company_name">
			<?php echo $company->company_name ?>
		</div>
		<div id="title">
			DEBIT NOTE
		</div>
		<div id="faktur_header">
			<div class="left">
				<?php echo $soh->client->client_name; ?><br />
				<?php echo $soh->client->address; ?>
			</div>
			<div class="right">
				<div class="row"><div class="label">INVOICE CODE</div>
				<div style="float:left;"> : </div>
				<div class="fill"><?php echo $sor_h->soinvoice_cd ?></div>
				<div class="clear"></div>
				</div>
				<div class="row"><div class="label">TAX INVOICE NO</div>
				<div style="float:left;"> : </div>
				<div class="fill">
					<?php
						$result = DAO::queryRowSql("SELECT * FROM tdpcompanyfp WHERE soinvoice_cd='".$sor_h->soinvoice_cd."'");
						echo $result['serifp'];
					?>
				</div>
				<div class="clear"></div>
				</div>
				<div class="row"><div class="label">DATE</div>
				<div style="float:left;"> : </div>
				<div class="fill"><?php $formatter = new Formatter(); echo $formatter->formatDate($soh->create_dt)?></div>
				<div class="clear"></div>
				</div>
				<div class="row"><div class="label">PAYMENT TERM</div>
				<div style="float:left;"> : </div>
				<div class="fill"><?php echo $soh->top." days"; ?></div>
				<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div style="width:200px;height:auto">
				<div class="label" style="width:30px;">Attn : </div>
				<div class="fill" style="border:none;width:80%;height:auto"><textarea style="width:100%;margin:0px;"></textarea></div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div id="content">
		<div id="data_header">
		<div id="data_detail">
			<table class="mystyle">
				<tr>
					<th width="5%">S/No.</th>
			    	<th width="35%">Descriptions</th>
			    	<th width="10%">Qty</th>
			    	<th width="25%">Unit Price</th>
			    	<th width="25%">Total</th>
				</tr>
				<?php
			    	$no=1;
			    	$total = 0;
					foreach($sor_d as $item)
					{
						$total +=$item['sell_price']*$item['qty'];
			    ?>
			    <tr>
			 
			    	<td style="text-align: left">
			    		<?php echo $no?>
			    	</td>
			    	<td style="text-align: left">
			    		<b><?php echo $item->item->item_name; ?></b><br />
						<textarea onkeyup="autoresize(this)"><?php echo $item->item->item_desc; ?></textarea>
			    	</td>
			    	<td style="text-align: right">
			    		<?php echo $item['qty']." ".$item['itemmeasurement_name']; ?>
			    	</td>
			    	<td style="text-align: right">
				    	<table width="100%" >
					    	<tr>
					    		<td width="50%" style="border:none;"><?php echo $soh->symbol->symbol; ?></td>
	    			            <td width="50%" style="text-align:right;border:none;"><?php echo number_format($item['sell_price'], 2, '.', ','); ?></td>
	    			        </tr>
	    			    </table>
			    	</td>
			    	<td style="text-align: right">
			    		<table width="100%" >
					    	<tr>
					    		<td width="50%" style="border:none;"><?php echo $soh->symbol->symbol; ?></td>
    		    			    <td width="50%" style="text-align:right;border:none;"><?php echo number_format($item['sell_price']*$item['qty'], 2, '.', ','); ?></td>
    		    			</tr>
    		    		</table>
			    	</td>
			    </tr>
			   <?php
			    	$no++;
					} 
			    ?>
			    <tr>
			    	<td colspan="4" style="text-align: right">
			    		Total :<br />
			    	</td>
			    	<td style="text-align: right">
			    		<table width="100%" >
				    		<tr>
				    			<td width="50%" style="border:none;"><?php echo $soh->symbol->symbol; ?></td>
    	    		    		<td width="50%" style="text-align:right;border:none;"><?php echo number_format($total['sell_price'], 2, '.', ','); ?></td>
    	    		    	</tr>
    	    		   	</table>
			    	</td>
			    </tr>
			    <?php
			    $query = "SELECT tax_cd, SUM( tax_amount ) AS tax_amount
							FROM (
							SELECT SUM( qty *sell_tax_amount1 ) AS tax_amount, sell_tax_cd1 AS tax_cd
							FROM vwsoretur
							WHERE soretur_cd =  '".$sor_h->soretur_cd."'
							AND sell_tax_cd1 IS NOT NULL 
							AND sell_tax_cd1 <>  ''
							GROUP BY sell_tax_cd1
							UNION 
							SELECT SUM(qty * sell_tax_amount2 ) AS tax_amount, sell_tax_cd2 AS tax_cd
							FROM vwsoretur
							WHERE soretur_cd =  '".$sor_h->soretur_cd."'
							AND sell_tax_cd2 IS NOT NULL 
							AND sell_tax_cd2 <>  ''
							GROUP BY sell_tax_cd2
							) AS x
							GROUP BY tax_cd
							ORDER BY tax_cd DESC";
				$result = DAO::querySql($query);
				$tax_amt = 0;
				foreach($result as $tax)
				{
				?>
			    <tr>
			    	<td colspan="4" style="text-align: right">
			    		<?php echo $tax['tax_cd']?> : 
			    	</td>
			    	<td style="text-align: right">
			    		<table width="100%" >
					    	<tr>
					    		<td width="50%" style="border:none;"><?php echo $soh->symbol->symbol; ?></td>
    	    	    		    <td width="50%" style="text-align:right;border:none;"><?php echo number_format($tax['tax_amount'], 2, '.', ','); ?></td>
    	    	    		</tr>
    	    	    	</table>
			    	</td>
			    </tr>
			    <?php $tax_amt+=$tax['tax_amount'];}?>
			    <tr>
			    	<td colspan="4" style="text-align: right">
			    		GRAND TOTAL : 
			    	</td>
			    	<td style="text-align: right">
			    		<table width="100%" >
					    	<tr>
					    		<td width="50%" style="border:none;"><?php echo $soh->symbol->symbol; ?></td>
			    	    	    <td width="50%" style="text-align:right;border:none;"><?php echo number_format($total+($tax_amt), 2, '.', ','); ?></td>
			    	    	</tr>
    	    	    	</table>
			    	</td>
			    </tr>
			</table>
		</div>
		<div>
			<div class="left">
				Amount In Word :
				<?php
					$a= (string)$total+($tax_amt);
					$temp = strstr($a,'.');
					$coma = substr($temp,-2,2);
					
					if($coma=='00') $coma = 0;
					
					//$bil = strstr($a,'.',true);
					$bil = $total+($tax_amt);
					
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
					
					if($soi->currency_cd=='USD')
						$curency="Dolar Amerika";
					elseif($soi->currency_cd=='IDR')
						$curency="Rupiah";
					elseif($soi->currency_cd=='SGD') {
						$curency="SGD";
					}
					else {
						$curency="";
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
				<div>
					Ditujukan ke Rekening : <br />
					<?php
						$company_bank = Companybank::model()->find("company_id = '".$company->company_id."'");
						echo $company_bank->bank_name."<br />";
						echo "A.N. ".$company_bank->beneficiary_name."<br />";
						echo "A.C. ".$company_bank->account_no."<br />";
					?>
				</div>
			</div>
			<div class="right">
				Jakarta,  <?php $formatter = new Formatter(); echo $formatter->formatDate($soh->create_dt)?><br /><br /><br /><br /><br /><br />
				<?php echo $sor_h->signed->employee_name; ?>
			</div>
			<div style="clear:both"></div>
		</div>
	</div>
	<div id="footer">
	</div>
</div>