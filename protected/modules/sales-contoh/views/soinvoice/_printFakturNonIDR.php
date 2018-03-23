<style>
.trbl {border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; }
.trb {border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; }
.rbl {border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; }
.tb {border-top: 1px solid black; border-bottom: 1px solid black; }
.rb {border-right: 1px solid black; border-bottom: 1px solid black; }
.b {border-bottom: 1px solid black; }
.r {border-right: 1px solid black; }
.line-through {text-decoration:line-through;}
.head-text{font-family:Arial, Helvetica, sans-serif;font-size:12px}
#align-right{text-align:right;font-family:Arial, Helvetica, margin:auto;font-size:10px;}
#align-center{text-align:center;font-family:Arial, Helvetica, margin:auto;font-size:10px;}
#align-harga{text-align:right;vertical-align:middle;font-family:Arial, Helvetica,margin:auto;font-size:10px;}
#wrapper{font-family:Arial, Helvetica, sans-serif;width:90%;margin:auto;font-size:10px;padding:5px; }
#title{ font-size:20px;font-weight:bold;text-align:center; }
#sub-title{font-size:13px;font-weight:bold;}
#body{font-size:11px}
</style>
<div id="wrapper">
<table width="100%">
	<tr>
		<td class="head-text" id="align-right" colspan="2">
			Lembar ke-1: Untuk Pembeli BKP/Penerima JKP sebagai bukti Pajak Masukan
		</td>
	</tr>

	<tr>
		<td class="head-text" id="align-right" colspan="2">
			Lembar ke-2: Untuk Pembeli BKP/Penerima JKP sebagai bukti Pajak Masukan
		</td>
	</tr>
	
</table>

<center id="title">
	<br><b>FAKTUR PAJAK</b><br><br>
</center>

<table class="trbl" cellspacing="0" width="100%" id="body">

	<tr>
		<td colspan="4" class="b" id="sub-title">
			<b>Kode dan Nomor Seri Faktur Pajak : <?php echo $serifp; ?></b>
		</td>
	</tr>
	<tr>
		<td colspan="4" class = "b" id="sub-title">
			Pengusaha Kena Pajak
		</td>
	</tr>
	<tr class="b">
		<td colspan="4" class="b">
			<table cellpadding="5" id="body">
				<tr>
					<td>
						Nama
					</td>
					<td>
						:
					</td>
					<td>
						<?php if(!empty($modelCompany->npwp_name)){ echo $modelCompany->npwp_name; }else{echo $modelCompany->company_name;}?>
					</td>
				</tr>
				<tr>
					<td>
						Alamat
					</td>
					<td>
						:
					</td>
					<td>
						<?php if(!empty($modelCompany->npwp_address)){ echo $modelCompany->npwp_address; }else{echo '&nbsp;';}?>
					</td>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						NPWP
					</td>
					<td>
						:
					</td>
					<td>
						<?php if(!empty($modelCompany->npwp_no)){ echo $modelCompany->npwp_no; }else{echo "00.000.000.0-000.000";}?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr >
		<td colspan="4" class="b" id="sub-title">
			Pembeli Barang Kena Pajak / Penerima Jasa Kena Pajak
		</td>
	</tr>
	<tr>
		<td colspan="4" class="b">
			<table cellpadding="5" id="body">
				<tr>
					<td>
						Nama
					</td>
					<td>
						:
					</td>
					<td>
						<?php if(!empty($modelClient->npwp_name)){ echo $modelClient->npwp_name; }else{echo $modelClient->client_name;}?>
					</td>
				</tr>
				<tr>
					<td>
						Alamat
					</td>
					<td>
						:
					</td>
					<td>
						<?php if(!empty($modelClient->npwp_address)){ echo $modelClient->npwp_address; }else{echo '&nbsp;';}?>
					</td>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						NPWP
					</td>
					<td>
						:
					</td>
					<td>
						<?php if(!empty($modelClient->npwp_no)){ echo $modelClient->npwp_no; }else{echo "00.000.000.0-000.000";}?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td class="r">
			<center>No.<br>Urut</center>	
		</td>
		<td class="r">
			<center>Nama Barang Kena Pajak / Jasa Kena Pajak	</center>
		</td>
		<td class="b" colspan="2">
			<center>Harga Jual / Penggantian /<br>Uang Muka / Termin (IDR)</center>	
		</td>
	</tr>
	<tr>
		<td class="rb" style="width: 10%">&nbsp;</td>
		<td class="rb" style="width: 60%">&nbsp;</td>
		<td class="rb" style="width: 15%" id="align-center">
			<?php
				echo $modelInvoice->currency_cd;
			?>
		</td>
		<td class="b" style="width: 15%" id="align-center">
			IDR
		</td>
	</tr>
	<?php
	$i=1;
	$j=0;
	foreach($modelD as $dataDetail)
	{
		?>
		<tr>
			
			<td class="r">
				<?php 
				if($modelInvoice->is_down_payment==1 && $i==2)
					{
						echo "<br/>";
					}
				?>
				<center><?php echo $i++;?></center>
			</td>
			<td class="r">
				<?php 
				if($modelInvoice->is_down_payment==1 && $i==2)
					{
						echo "<center>DP ".$modelInvoice->payment_percent."%</center><div style='border-bottom: 1px solid !important;'>&nbsp;<br/></div>";
						//echo "<br/>";
					}
				?>
				<?php
					$item = Item::model()->findByPk($dataDetail->item_cd);
					echo $item->item_name."<br> ($dataDetail->qty $item->itemmeasurement_name)";
				?>
			</td>
			<td id="align-harga" class="r">
				<?php
				$payment_percent = $modelInvoice->payment_percent;
				$subtotal = $modelInvoice->subtotal_price;
				
				$query = "SELECT SUM(discount_amt) AS discount_amt FROM tdpsoinvoicedetail WHERE soinvoice_cd = '".$model->soinvoice_cd."'";
				$res = DAO::queryRowSql($query);
				$discount = $res['discount_amt'];
				
				if(empty($discount)) $discount = 0.00;
				
				$grand_total = ($payment_percent/100)*($subtotal);
				
				if($modelInvoice->is_down_payment==1 && $i==2)
					{
						echo "<br/>";
					}
				?>
				<?php
					if($modelInvoice->is_down_payment==0)
					{
						echo number_format($dataDetail->total_price, 2, '.', ',');
					}
					else if($modelInvoice->is_down_payment==1 && $j==0)
					{
						echo number_format($grand_total, 2, '.', ',');
						$j=1;
					}
						
				 ?>&nbsp;
			</td>
			<td>&nbsp;
			</td>
		</tr>
	<?php 
	}//end for each
	?>
	<?php
	if($i==1)
	{
	?>
		<tr>
			<td class="r">
					<center>-</center>
				</td>
				<td class="r">
					-
				</td>
				<td>
					-
				</td>
				<td>
					-
				</td>
		</tr>
	<?php 
	}
	?>
	<tr>
		<td colspan="2" class="trb">
			<?php if($modelInvoice->is_down_payment==0) {?>
			
			Harga Jual/<span class="line-through">Penggantian</span>/<span class="line-through">Uang Muka</span>/<span class="line-through">Termin</span>
			<?php } else if($modelInvoice->is_down_payment==1){ ?>
			<span class="line-through">Harga Jual</span>/<span class="line-through">Penggantian</span>/Uang Muka/<span class="line-through">Termin</span>
			<?php } ?>
		</td>
		<td class="trb" id="align-right">
			<?php 
				if($modelInvoice->is_down_payment==1)
				{
					$sub_percent =  ($payment_percent/100)*$subtotal; 
					echo number_format($sub_percent, 2, '.', ',');
				}
				else
				{
					echo number_format($modelInvoice->subtotal_price, 2, '.', ',');					
				}
				?>
		</td>
		<td class="tb">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" class="rb">
			Dikurangi Potongan Harga
		</td>
		<td class="rb" id="align-right">
			<?php 
			
			if($model->is_down_payment==1)
			{
				$disc_percent = ($payment_percent/100)*$discount;
				echo number_format($disc_percent, 2, '.', ',');
			}
			else 
			{
				
				echo number_format($discount, 2, '.', ',');
			}
			
			?>
		</td>
		<td class="b">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" class="rb">
			Dikurangi Uang Muka yang telah diterima
		</td>
		<td class="rb" id="align-right">
			<?php
				$used_dp = 0;
				if($modelInvoice->is_down_payment==1)
				{
					echo "0.00";
				} 
				else if($modelInvoice->is_down_payment==0)
				{
					$so_cd = $modelH->so_cd;
					$query = "SELECT SUM(payment_percent) as payment_percent FROM tdpsoinvoice where so_cd = '$so_cd' AND is_down_payment = 1";
					$result = DAO::queryRowSql($query);
					
					$total_percent = $result['payment_percent'];
					$used_dp = ($total_percent/100)*($modelH->subtotal_sell - $modelH->subtotal_sell_disc);
					echo number_format($used_dp, 2, '.', ',');
				}
			?>
		</td>
		<td class="b">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" class="rb">
			Dasar Pengenaan Pajak
		</td>
		<td class="rb" id="align-right">
			<?php 
				if($model->is_down_payment==1)
				{
					$dpp= $sub_percent-$used_dp-$disc_percent;
					echo number_format($dpp, 2, '.', ',');
				}
				else {
					$dpp = $subtotal-$used_dp-$discount;
					echo number_format($dpp, 2, '.', ',');
				}
				
			?>
		</td>
		<td class="b" id="align-right">
			<?php 
				$tax_kurs = $modelInvoice->tax_kurs;
				$dpp_rupiah = $tax_kurs * $dpp;
				echo number_format($dpp_rupiah, 2, '.', ',');
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="rb">
			PPN = 10%  x Dasar Pengenaan Pajak
		</td>
		<td class="rb" id="align-right">
			<?php $pajak = 0.1 * ($dpp);
				echo number_format($pajak, 2, '.', ',');
			?>
		</td>
		<td class="b" id="align-right">
			<?php
				$pajak_rupiah = $pajak * $tax_kurs;
				echo number_format($pajak_rupiah, 2, '.', ',');
			?>
		</td>
	</tr>
	
	<tr>
		<td colspan=3 id="sub-title">
			<br>
			Pajak Penjualan Atas Barang Mewah
			<br /><br/>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<table width=80% cellspacing="0" id="body">
				<tr>
					<td class="trb">
						Tarrf
					</td>
					<td class="trb">
						DPP
					</td>
					<td class="trb">
						PPnBM
					</td>
				</tr>
				<?php for($i=0;$i<4;$i++){?>
				<tr>
					<td class="r">
						.....%
					</td>
					<td class="r">
						Rp ...........
					</td>
					<td class="r">
						Rp ...........
					</td>
				</tr>
				<?php }?>
				<tr>
					<td colspan="2" class="rb" style="border-top: 1px solid !important;">
						Jumlah
					</td>
					<td class="rb" style="border-top: 1px solid !important;">
						Rp ..........
					</td>
				</tr>
			</table>
			<br>
		</td>
		<td colspan="2">
			<?php $mydate=getdate(date("U"));?>
			Jakarta, <?php $format = new Formatter;
			echo $format->formatDate($modelInvoice->soinvoice_dt); ?><br><br><br><br><br>
			<?php $sign=Employee::model()->findByPk($modelInvoice->signed_by);
			echo $sign->employee_name;?>
		</td>
		
		<tr>
			<td colspan="4">
				<span>
					Catatan : <br />
					<?php
						echo "Kurs : Rp".$tax_kurs."/".$modelInvoice->currency_cd; 
					?>
				</span>
			</td>
		</tr>
		
		<tr>
			<td colspan="4">
				<span>
					<?php $format = new Formatter; 
					echo "Berdasarkan KMK No. ".$modelInvoice->kmk_no." tanggal ".$format->formatDate($modelInvoice->kmk_date) ?>
				</span>
			</td>
		</tr>
		
</table>
</div>



















