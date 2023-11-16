<?php require "config.php"; ?>
<html>
	<head>
		<title>Create Printable PDF invoice using PHP MySQL</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
		<script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
		
	</head>
	<body>
		<div class='container pt-5'>
			<h1 class='text-center text-primary'>Add Sale</h1><hr>
			<?php
				if(isset($_POST["submit"])){
					$invoice_no=$_POST["invoice_no"];
					$invoice_date=date("Y-m-d",strtotime($_POST["invoice_date"]));
					$cname=mysqli_real_escape_string($con,$_POST["cname"]);
					$caddress=mysqli_real_escape_string($con,$_POST["caddress"]);
					$ccity=mysqli_real_escape_string($con,$_POST["ccity"]);
					$total_qty=mysqli_real_escape_string($con,$_POST["total_qty"]);
					$grand_total=mysqli_real_escape_string($con,$_POST["grand_total"]);

					
					$sql="insert into invoice (INVOICE_NO,INVOICE_DATE,CNAME,CADDRESS,CCITY,TQty,GRAND_TOTAL) values ('{$invoice_no}','{$invoice_date}','{$cname}','{$caddress}','{$ccity}','{$total_qty}','{$grand_total}') ";
					if($con->query($sql)){
						$sid=$con->insert_id;
						
						$sql2="insert into invoice_products (SID,PNAME,PRICE,QTY,TOTAL) values ";
						$rows=[];
						for($i=0;$i<count($_POST["services"]);$i++)
						{
							$pname=mysqli_real_escape_string($con,$_POST["services"][$i]);
							$price=mysqli_real_escape_string($con,$_POST["uprice"][$i]);
							$qty=mysqli_real_escape_string($con,$_POST["qty"][$i]);
							$total=mysqli_real_escape_string($con,$_POST["total"][$i]);
							$rows[]="('{$sid}','{$pname}','{$price}','{$qty}','{$total}')";
						}
						$sql2.=implode(",",$rows);
						if($con->query($sql2)){
							echo "<div class='alert alert-success'>Invoice Added. <a href='print.php?id={$sid}' target='_BLANK'>Click</a> here to Print Invoice</div>";
							// echo "<a href='Invoice.php?id={$sid}' target='_BLANK'></a>";
						}else{
							echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
						}
					}else{
						echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
					}
				}
				
			?>
			<form method='post' action='index.php' autocomplete='off'>
				<div class='row'>
					<div class='col-lg-4'>
						<h5 class='text-success'>Invoice Details</h5>
						<div class='form-group'>
							<label>Invoice No</label>
							<input type='text' name='invoice_no' required class='form-control'>
						</div>
						<div class='form-group'>
							<label>Invoice Date</label>
							<input type='text' name='invoice_date' id='date' required class='form-control'>
						</div>
					</div>
					<div class='col-lg-8'>
						<h5 class='text-success'>Customer Details</h5>
						<div class='form-group'>
							<label>Customer*</label>
							<input type='text' name='cname' required class='form-control'>
						</div>
						<div class='form-group'>
							<label>Company*</label>
							<input type='text' name='caddress' required class='form-control'>
						</div>
						<div class='form-group'>
							<label>Biller*</label>
							<input type='text' name='ccity' required class='form-control'>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-lg-12'>
						<h5 class='text-success'>Services Details</h5>
						<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Services</th>
									<th>Unit Price</th>
									<th>Quantity</th>
									<th>Currency</th>
									<th>R.O.E</th>
									<th>Total</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id='product_tbody'>
								<!-- <tr>
									<td><input type='text' required name='services[]' class='form-control'></td>
									<td><input type='text' required name='uprice[]' class='form-control price'></td>
									<td><input type='text' required name='qty[]' class='form-control qty'></td>
									<td><select type='text' required name='currency[]' class='form-control currency'>
										<option selected>USD</option>
										<option>Pkr</option>
									</td>
									<td><input type='text' required name='RoE[]' class='form-control RoE'></td>
									<td><input type='text' required name='total[]' class='form-control total'></td>
									<td><input type='button' value='Delete' class='btn btn-danger btn-sm btn-row-remove'> </td>
								</tr> -->
							</tbody>
							<tfoot>
								<tr>
									<td><input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'></td>
									<td colspan='1' class='text-right'>Total</td>
									<td><input type='number' name='total_qty' id='total_qty' class='form-control' required></td>
									<td colspan='2'></td>
									<td><input type='text' name='grand_total' id='grand_total' class='form-control' required></td>
									<td></td>
								</tr>
							</tfoot>
						</table>
						<input type='submit' name='submit' value='Save Invoice' class='btn btn-success float-right'>
					</div>
				</div>
			</form>
		</div>
		<script>
			$(document).ready(function(){
				$("#date").datepicker({
					dateFormat:"dd-mm-yy"
				});
				
				$("#btn-add-row").click(function(){
					var row="<tr><td><input type='text' required name='services[]' class='form-control'></td><td><input type='number' required name='uprice[]' class='form-control price'></td><td><input type='number' required name='qty[]' class='form-control qty'></td><td><select type='text' required name='currency' class='form-control currency'><option selected>USD</option><option>Pkr</option></td><td><input type='number' required name='RoE[]' class='form-control RoE'></td><td><input type='number' required name='total[]' class='form-control total'></td><td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'></td></tr>";
					$("#product_tbody").append(row);
				});
				
				$("body").on("click",".btn-row-remove",function(){
					if(confirm("Are You Sure?")){
						$(this).closest("tr").remove();
						grand_total();
					}
				});
				
				$("body").on("keyup", ".price, .qty, .RoE", function () {
    			var price = Number($(this).closest("tr").find(".price").val());
				var qty = Number($(this).closest("tr").find(".qty").val());
				var Roe = Number($(this).closest("tr").find(".RoE").val());
				$(this).closest("tr").find(".total").val(price * qty * Roe);
				total_qty();
				grand_total();
	
				function grand_total(){
					var tot=0;
					$(".total").each(function(){
						tot+=Number($(this).val());
					});
					$("#grand_total").val(tot);
					}

				function total_qty(){
					var totq=0;
					$(".qty").each(function(){
					totq+=Number($(this).val());
					});
				$("#total_qty").val(totq);
				}
				});
			});
		</script>
	</body>
</html>