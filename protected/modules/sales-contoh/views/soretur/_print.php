<script>
	window.onload = function(e)
	{
		window.print();
	}
</script>
<style>
	.line
	{
		border:1px solid;
	}
</style>
<table cellpadding="0" cellspacing="0" width=100%">
	<tr>
		<td colspan="6"><center><h3>NOTA RETUR - SO RETUR</h3></center></td>
	</tr>
	<tr>
		<td colspan="6">No : <?php echo $sor_h->soretur_cd; ?></td>
	</tr>
	<tr>
		<td colspan="6">PEMBELI</td>
	</tr>
	<tr>
		<td colspan="2">Nama</td>
		<td colspan="4"> : PT. Karlwei Multi Global</td>
	</tr>
	<tr>
		<td colspan="2">Alamat</td>
		<td colspan="4"> : Jl. Jelambar Selatan No.24 Jelambar Baru Grogol Petamburan<br />Jakarta Barat 11460</td>
	</tr>
	<tr>
		<td colspan="2">NPWP</td>
		<td colspan="4"> : 02.691.688.2-036.000</td>
	</tr><tr>
		<td colspan="6"><br />KEPADA PENJUAL</td>
	</tr>
	<tr>
		<td colspan="2">Nama</td>
		<td colspan="4"> : <?php echo $soh->client->client_name; ?></td>
	</tr>
	<tr>
		<td colspan="2">Alamat</td>
		<td colspan="4"> : <?php echo $soh->client->address; ?></td>
	</tr>
	<tr>
		<td colspan="2">NPWP</td>
		<td colspan="4"> : <?php echo 021//$soh->vendor->vendor_name; ?></td>
	</tr>
	<tr>
		<td colspan="6">No. Pengakuan<br />PKP</td>
	</tr>
	<tr>
		<td class="line">No urut</td>
		<td class="line">Macam dan Jenis Barang Kena Pajak</td>
		<td class="line">Kuantum (Unit)</td>
		<td class="line">Harga Satuan dalam USD</td>
		<td class="line">Jumlah dalam USD</td>
		<td class="line">Harga BKP yang dikembalikan dalam IDR</td>	
	</tr>
	<?php
	$i=1;
	$hargaBKP = 0;
	foreach($sod as $item)
	{
		$hargaBKP += $item['total_sell_price']*$soh->sell_kurs;
	?>
		<tr>
			<td class="line"><?php echo $i;?></td>
			<td class="line"><?php echo $item['item_cd']."<br />".$item->item->item_name; ?></td>
			<td class="line"><?php echo $item['qty']?></td>
			<td class="line"><?php echo $item['sell_price']?></td>
			<td class="line"><?php echo $item['total_sell_price']?></td>
			<td class="line"><?php echo $item['total_sell_price']*$soh->sell_kurs; ?></td>
		</tr>
	<?php
	$i++;
	}
	?>
	<tr>
		<td colspan="5" class="line">Jumlah Harga BKP yang dikembalikan</td>
		<td class="line"><?php echo $hargaBKP; ?></td>
	</tr>
	<tr>
		<td colspan="5" class="line">Pajak Pertambahan Nilai yang diminta kembali</td>
		<td class="line"></td>
	</tr>
	<tr>
		<td colspan="5" class="line">a. Pajak Pertambahan Nilai</td>
		<td class="line"><?php echo $hargaBKP/10;?></td>
	</tr>
	<tr>
		<td colspan="5" class="line">b. Pajak Penjualan Atas Barang Mewah</td>
		<td class="line"></td>
	</tr>
	<tr>
		<td colspan="6" style="text-align:right;">Jakarta, <?php echo $sor_h->create_dt; ?><br /><br /><br /><br /><br /></td>
	</tr>
	<tr>
		<td colspan="6" style="text-align:right;"><?php echo $sor_h->signed->employee_name; ?></td>
	</tr>
	<tr>
		<td colspan="6">Invoice : <?php echo 121212 ?></td>
	</tr>
	<tr>
		<td colspan="6">Kurs : <?php echo $soh->sell_kurs."/".$soh->sell_currency; ?></td>
	</tr>
</table>