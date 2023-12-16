<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receipt</title>
<style>
    @page {
			size: 3in auto; /* width of 3 inches */
			margin: 0;
    }
    body {
			font-family: 'Courier New', Courier, monospace; /* monospaced font for receipt printing */
			font-size: 10pt; /* adjust the font size as needed */
			width: 3in;
			margin: 0;
    }
    .receipt {
			text-align: center;
			max-width: 2.8in;
			margin: auto;
			padding: 10px;
    }
		.receipt-title {
			font-weight: bolder !important;
			text-align: center;
			text-transform: uppercase;
			font-size: 20px !important;
			font-family: arial !important;
		}
    .receipt-header {
			text-align: center;
			border-bottom: 1px dashed #000;
			padding-bottom: 5px;
    }
		.receipt-header p {
			margin: 5px 0px;
		}
    .receipt-body {
			text-align: left;
			padding: 5px;
    }
		table {
        width: 100%;
        border-collapse: collapse; /* For a clean table look */
    }
    th {
			border-top: 1px dashed #000; /* For dashed lines in table */
			border-bottom: 1px dashed #000; /* For dashed lines in table */
			padding: 2px;
    }
		.txt-center { 
			text-align: center;
		}
		.txt-left { 
			text-align: left;
		}
		.txt-right { 
			text-align: right;
		}
    td {
			text-align: left;
			padding: 2px;
    }
    th {
        text-align: center;
    }
    .total-row td {
        border-top: 1px dashed #000;
        font-weight: bold;
    }
    .item {
			display: flex;
			justify-content: space-between;
			margin-bottom: 2px;
    }
    .item span {
			display: inline-block;
    }
    .total {
			display: flex;
			justify-content: space-between;
			font-weight: bold; /* bold for total */
			border-top: 1px dashed #000;
			padding-top: 5px;
    }
    .footer {
			text-align: center;
    }
		.footer p {
			margin: 5px 0px 0px 0px;
		}
		.company-details {
			border-top: 1px dashed #000;
		}
		.company-details p {
			margin:2px 0px;
			padding:0;
		}
</style>
</head>
<body>
	<?php // echo '<pre>';print_r($bill_details["0"])?>
    <div class="receipt">
        <div class="receipt-header">
					<p class="receipt-title"><?php echo $billDetails_array["invoice_title"]; ?></p>
					<p><?php echo $billDetails_array["invoice_address"]; ?></p>
					<p>Mobile: <?php echo $billDetails_array["invoice_contact_number"]; ?></p>
					<p>GST: <?php echo $billDetails_array["gst_number"]; ?></p>
					<p>FSSAI: 11517005000179</p>
        </div>
        <div class="receipt-body">
            <div class="item">
							<span>Bill No. <?php echo $billDetails_array["invoice_prefix"]; ?><?php echo $bill_details["0"]["invoice_number"]; ?></span>
							<span>Date <?php echo date("d/m/Y", strtotime($bill_details["0"]["invoice_date"])); ?></span>
            </div>
						<?php if ($bill_details["0"]['print_details'] == 1){ ?>
							<div class="company-details">
								<p class="txt-left">M/S. <?php echo ($bill_details["0"]["coporate_id"] != 1 ? $bill_details["0"]["company_name"] : $bill_details["0"]["customer_name"]) ; ?></p>
								<?php if ($bill_details["0"]["coporate_id"] != 1) { ?>
									<p class="txt-left"><?php echo $bill_details["0"]["company_address"]; ?></p>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="invoice-items-container">
							<table>
                <tr>
									<th class="txt-left">Description</th>
									<th class="txt-right">Qty</th>
									<th class="txt-right">Rate</th>
									<?php if($has_special_rate == "yes"){ ?>
										<th class="txt-right">Sp.Rt</th>
									<?php } ?>
									<th class="txt-right">Amt</th>
                </tr>
                <!-- Repeat this row for each item -->
								<?php $total_qty = 0; $net_amount = 0; $special_amount = 0; ?>
								<?php if(!empty($bill_details)){ foreach($bill_details as $keys=>$values){ ?>
									<tr>
										<td class="txt-left"><?php echo $values['item_name']; ?></td>
										<td class="txt-right"><?php $total_qty += $values['qty']; echo $values['qty']; ?></td>
										<td class="txt-right"><?php echo convert_indian_currency($values['mrp']); ?></td>
										<?php if($has_special_rate == "yes"){ ?>
											<td class="txt-right"><?php if ($values['special_rate'] != 0) { $special_amount += ($values['mrp']-$values['special_rate'])*$values['qty']; echo convert_indian_currency($values['special_rate']); }else { echo '-';} ?></td>
										<?php } ?>
										<td class="txt-right"><?php $net_amount += $values['final_amount']; echo convert_indian_currency($values['final_amount']); ?></td>
									</tr>
								<?php }} ?>
                <!-- End of item rows -->
            </table>
        </div>
        <div class="total">
					<span>QTY <?php echo $total_qty; ?></span>
					<span>TOTAL <?php echo convert_indian_currency($net_amount); ?></span>
        </div>
				<div class="total">
						<?php if($has_special_rate == "yes"){ ?>
							<span>YOU SAVE &#8377;<?php echo convert_indian_currency($special_amount); ?></span>
						<?php } ?>
					</div>
        <div class="footer">
					<p>Assuring best practices in the industry</p>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
  window.print();
</script>
