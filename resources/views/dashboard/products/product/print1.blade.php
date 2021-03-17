<html>
<head>
<style>
p.inline {display: inline-block;}
span { font-size: 13px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
</style>
</head>
<body onload="window.print();">
	<div style="margin-left: 5%">
		<?php
		include 'barcode128.php';
		//$product = $_POST['product'];
		//$product_id = $_POST['product_id'];
		//$rate = $_POST['rate'];

		foreach($products as $product)
        {
			echo "<p class='inline'><span ><b></b></span>".bar128(stripcslashes($product->prod_code))."<span ><span></p>&nbsp&nbsp&nbsp&nbsp";
		}

		?>
	</div>
</body>
</html>