<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title></title>
	<!-- CSS  -->
	<link href="<?php echo base_url('assets/css/print_bill.css'); ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
	<style>
		body{
				font-family: "Times New Roman", Times, serif;
		}
		@media print{
			body{
				display:block;height:100%;
				font-family: "Times New Roman", Times, serif;
			}
			table td, table th{font-size:18px !important;}
		}
	</style>
</head>
<body>
	<div class="container" style="padding:0px;margin:0px;">
        <?php //echo "<pre>";print_r($bill_details);exit;?>
		<div class="row" style="padding:0px;margin:0px;">
			<div class="col-sm-8 col-sm-push-2 invoiceborder" style="padding:0px;margin:0px;">
					<h5 class="text-center"><b style="font-size:40px;text-transform:uppercase;"><?php echo $billDetails_array["invoice_title"]; ?></b></h5>
					<p class="text-center" style="margin:0px;font-size:14px;"><b><?php echo $billDetails_array["invoice_address"]; ?></b></p>
					<p class="text-center" style="font-size:14px;"><b>Tel. No. <?php echo $billDetails_array["invoice_contact_number"]; ?>, email:<?php echo $billDetails_array["invoice_email_id"]; ?></b></p>
					<p class="text-center"><b style="font-size:20px;">BILL OF SUPPLY</b></p>
					<p style="font-weight:bold;font-size:13px;">Invoice No.: <?php echo $billDetails_array["invoice_prefix"]; ?><?php echo $bill_details["0"]["invoice_number"]; ?> &nbsp; <span style="text-align:right;float:right;">Date : <?php echo date("d/m/Y", strtotime($bill_details["0"]["invoice_date"])); ?></span></p>
					<p style="font-weight:bold;font-size:11px;">PAN No. <?php echo $billDetails_array["pancard_number"]; ?><span style="text-align:right;float:right;">GST : <?php echo $billDetails_array["gst_number"]; ?></span></p>
          <hr/>
					<table class="table table-bordered" style="margin-top:20px;">
						<thead>
							<tr>
								<th style="text-align: right;padding:3px;">Qty.</th>
								<th style="text-align: left;padding:3px;">Particulars</th>
								<th style="text-align: right;padding:3px;">MRP</th>
								<th style="text-align: right;padding:3px;">Net Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php $net_amount = 0;?>
							<?php if(!empty($bill_details)){ foreach($bill_details as $keys=>$values){ ?>
									<tr>
										<td style="text-align: right;padding:3px;"><?php echo $values['qty']; ?></td>
										<td style="text-align: left;padding:3px;"><?php echo $values['item_name']; ?></td>
										<td style="text-align: right;padding:3px;"><?php echo convert_indian_currency($values['mrp']); ?></td>
										<td style="text-align: right;padding:3px;"><?php $net_amount += $values['final_amount']; echo convert_indian_currency($values['final_amount']); ?></td>
									</tr>
							<?php }} ?>	
							<tr>
								<td style="padding:3px;"><b>Total</b></td>
								<td style="padding:3px;"></td>
								<td style="padding:3px;"></td>
								<td style="text-align: right;font-weight:bold;padding:3px;"><?php echo convert_indian_currency($net_amount); ?></td>
							</tr>
							<?php if($bill_details["0"]["bill_discount"] != 0){ ?>
								<tr>
									<td style="padding:3px;" colspan="3"><b>Discount <?php echo $bill_details["0"]["bill_discount"]; ?>%</b></td>
									<td style="text-align: right;font-weight:bold;padding:3px;"><?php echo convert_indian_currency(number_format($discount_amount,"2",".","")); ?></td>
								</tr>
								<tr>
									<td style="padding:3px;" colspan="3"><b>Grand Total</b></td>
									<td style="text-align: right;font-weight:bold;padding:3px;"><?php echo convert_indian_currency(number_format($net_amount-$discount_amount,"0",".","")); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					</div>
		    </div>
	    </div>
	</body>
</html>
<script type="text/javascript">
  window.print();
</script>