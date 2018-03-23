<style>
	*
	{
		font-size:xx-small;
	}
	#logo,#location,#sublocation,#notes
	{
		text-align:left;
	}
	#judul,#nofak
	{
		text-align:center;
	}
	.data
	{
		border:1px solid;
	}
	.head
	{
		text-align: center;
	}
	.value
	{
		text-align:right;
	}
</style>
<table cellpadding="0" cellspacing="0">
	<?php
		$pph23 = 0;
		$pph25 = 0;
		$ppn = 0;
    ?>
    <tr><!-- Judul -->
    	<td colspan="7" id="judul"> <h1>SALES ORDER</h1> </td>
    </tr>
    <tr><!-- Vendor dan tanggal -->
    	<td>Customer</td>
    	<td colspan="3" style="border-bottom:1px solid;"> : <?php echo $header->client->client_name." - ".$header->client->client_cd; ?></td>
        <td>No. SO</td>
        <td style="border-bottom:1px solid;" colspan="2"> : <?php echo $header->so_cd; ?></td>
    </tr>
    <tr>
    	<td>Address</td>
        <td colspan="3" style="border-bottom:1px solid;"> : <?php echo $header->client->address; ?></td>
        <td>Date</td>
        <td style="border-bottom:1px solid;" colspan="2"> : 
        	<?php
	        	$date = new DateTime();
	        	$result = $date->format('d-M-Y');
	        	echo $result;
        	?>
       	</td>
    </tr>
    <tr>
    	<td>Telepon</td>
    	<td colspan="3" style="border-bottom:1px solid;"> : <?php echo $header->client->phone; ?></td>
        <td>Sales</td>
        <td style="border-bottom:1px solid;" colspan="2"> : <?php echo $header->employee->employee_name." - ".$header->sales_cd; ?></td>
    </tr>
    <tr>
    	<td>TOP</td>
    	<td colspan="3" style="border-bottom:1px solid;"> : <?php echo $header->top; ?> day(s)</td>
        <td>NO. PO : </td>
        <td style="border-bottom:1px solid;" colspan="2"> : <?php echo $header->client_po_no; ?></td>
    </tr>
    <tr><!-- Vendor dan tanggal -->
    	<td>Currency </td>
    	<td colspan="6" style="border-bottom:1px solid;"> : <?php echo $header->sell_currency; ?></td>
    </tr>
    <tr>
    	<td colspan="7">&nbsp; </td>
    </tr>
    <tr><!-- Header tabel -->
    	<td class="data head" width="5">No</td>
        <td class="data head" width="400">Desc</td>
        <td class="data head" width="200">Qty</td>
        <td class="data head" width="200">Unit Sell Price</td>
        <td class="data head" width="200">Total Sell</td>
        <td class="data head" width="200">Total Cost</td>
        <td class="data head" width="200">Vendor</td>
    </tr>
    <?php
    $count = 1;
	foreach($detail as $datadetail)
	{
    ?>
    <tr><!-- Cotent tabel -->
    	<td class="data" valign="top">
    		<?php echo $count;?>
    	</td>
    	<td class="data" valign="top">
			<?php echo $datadetail['item_name']." - ".$datadetail['item_cd']."<br />"; ?>
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
    	<td class="data value" valign="top"><?php echo number_format($datadetail['qty'], 0, '.', ','); ?></td>
        <td class="data value" valign="top"><?php echo $header->sell_currency.number_format($datadetail['sell_price'], 2, '.', ','); ?></td>
        <td class="data value" valign="top">
			<?php echo $header->sell_currency.number_format($datadetail['total_sell_price'], 2, '.', ',')."<br />"; ?>
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
        <td class="data value" valign="top">
			<?php echo $header->sell_currency.number_format($datadetail['total_cost_price'], 2, '.', ',')."<br />"; ?>
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
        <td class="data" valign="top"><?php echo $datadetail['vendor_name']; ?></td>
    </tr>
    <?
	}
	?>
    <tr>
    	<td colspan="7"> </td>
    </tr>
    <tr>
    	<td>Delivery Date</td>
    	<td colspan="3" style="border-bottom:1px solid;"> : <?php
        		$oFormatter = new Formatter();
        		echo $oFormatter->formatDate($header->est_delivery_dt);
        	?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
    	<td>Expedisi</td>
    	<td colspan="3" style="border-bottom:1px solid;"><?php if($header->expedisi_cd != ""){echo $header->expedisi->expedisi_name." - ".$header->expedisi_cd;}?></td>
        <td></td>
        <td>Subtotal Sales : </td>
        <td style="border-bottom:1px solid;" class="value"><?php echo $header->sell_currency.number_format($header->subtotal_sell, 2, '.', ','); ?></td>
    </tr>
    <tr>
    	<td colspan="4" rowspan="4"><H1><?php echo ($header->is_indent == 0)? " " : "INDENT" ;?></H1></td>
        <td></td>
    <?php
 	   	$i=0;
    	$query = "SELECT * FROM tdpsotax WHERE so_cd = '".$header->so_cd."'";
    	$result = DAO::querySql($query);
    	foreach($result as $tax)
    	{
    		if($i==0)
    		{
    ?>
            <td><?php echo $tax['tax_cd'].' : '; ?></td>
            <td style="border-bottom:1px solid;" class="value"><?php echo $header->sell_currency.number_format($tax['tax_amount'], 2, '.', ','); ?></td>
        </tr>
    <?php
    		}
    		else
    		{
    ?>
	    	<tr>
		    	<td> </td>
    			<td><?php echo $tax['tax_cd'].' : '; ?></td>
                <td style="border-bottom:1px solid;" class="value"><?php echo $header->sell_currency.number_format($tax['tax_amount'], 2, '.', ','); ?></td>
            </tr>
    <?php
    		}
    		$i++;
    	}
    ?>
    
    <tr>
    	<td></td>
    	<td>Discount : </td>
        <td style="border-bottom:1px solid;" class="value">
			<?php
				$disc = 0;
            	if($header->discount_type == 1)
					$disc = (($header->subtotal_sell*$header->discount_value)/100);
				echo $header->sell_currency.number_format($disc, 2, '.', ',');
			?>
        </td>
    </tr>
    <tr>
    	<?php
    	if($i==2)
    	{
    	?>
    	<td></td>
    	<?php }else{?>
    	<td colspan="5"></td>
    	<?php } ?>
    	<td>Total : </td>
        <td style="border-bottom:1px solid;" class="value"><?php echo $header->sell_currency.number_format($header->subtotal_sell+$ppn-$pph23-$pph25-$disc, 2, '.', ','); ?></td>
    </tr>
    <tr>
    	<td colspan="7">Notes</td>
    </tr>
    <tr>
    	<td colspan="4" style="text-align:center;"> Salesman<br /><br /><br /><br /><br />(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td colspan="4" style="text-align:center;"> Approved<br /><br /><br /><br /><br />(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
    </tr>
</table>