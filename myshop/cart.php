<?php include('functions.php') ?>

<?php
if (isLoggedIn()==false) {
	header('location: index.php');
}
?>

<?php

$status = "";
$item_status = "";
$counter = 0;
$url = "checkout.php?";

	if (isset($_POST['product_to_remove']))
	{
		$order_id = $_POST['order_id'];
		$product_code = $_POST['product_to_remove'];
		$product_category = $_POST['category'];
		#$status = "".$product_code."".$product_category."";
		
		$query = "DELETE FROM item WHERE order_id ='$order_id' && category ='$product_category' && item_id='$product_code'";
		#$status = $query;
		mysqli_query($db, $query);
		$status = "<div class='box' style='color:red;'> Product is removed from your cart!</div>";
	}
	
	if (isset($_POST['product_to_change']))
	{
		$main_category = $_POST['main_category'];
		$order_id = $_POST['order_id'];
		$product_code = $_POST['product_to_change'];
		$product_category = $_POST['category'];
		$quantity = $_POST['quantity'];
		$product_name = $_POST['product_name'];
		
		// echo $order_id;
		// echo $product_code;
		// echo $product_category;
		// echo $quantity;
		
		if (!preg_match('/[^0-9]/', $quantity))
		{
			$query = "SELECT * FROM $main_category WHERE id='$product_code'";
			$result = mysqli_query($db, $query);
			foreach($result as $product)
			{
				$product_quantity = $product['quantity'];
			}
			if ($product_quantity < $quantity)
			{
				$status = "<div class='box' style='color:red;'>only ".$product_quantity." items left for ".$product_name."</div>";
			}
			elseif ($quantity == "0")
			{
				$status = "<div class='box' style='color:red;'>Invalid quantity for ".$product_name."</div>";
			}
			else
			{
				$query = "UPDATE item
						SET quantity='$quantity'
						WHERE order_id ='$order_id' && category ='$product_category' && item_id ='$product_code'";
						
				mysqli_query($db, $query);
				
				$status = "<div class='box' style='color:red;'> Quantity updated!</div>";
				
				#$status = "<div class='box' style='color:red;'> NUMBER ONLY!</div>";
			}
		}
		else
		{
			
		}
	}
	
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> Supershop</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="logo" align = "center"> <a href="index.php"> <img src="Images/Logo.png" width = "180" height = "80"> </a> </div>
<div class="categories" align = "center"> 
	<div>
		<button type="button" class="category" onclick="window.location.href = 'Computers_cat.php';">
			Computers
		</button>
	</div>
	<div>
		<button type="button" class="category" onclick="window.location.href = 'Smartphones_cat.php';">
			Smartphones
		</button>
	</div>
	<div>
		<button type="button" class="category" onclick="window.location.href = 'Sound_cat.php';">
			Sound
		</button>
	</div>
	<div>
		<button type="button" class="category" onclick="window.location.href = 'Vision_cat.php';">
			Vision
		</button>
	</div>
	<div>
		<button type="button" class="category" onclick="window.location.href = 'Appliances_cat.php';">
			Appliances
		</button>
	</div>
	<div>
		<button type="button" class="category" onclick="window.location.href = 'Books_cat.php';">
			Books
		</button>
	</div>
</div>

<div class="credentials">
	<div class="cart" align = "center"> 
		<?php
			$item_count = 0;
			$user_id = GetUserID();
			if($user_id == 0)
			{
			?>
				<img src="Images/cart.png" width = "30" height = "30"> <a href="cart.php">CART</a> /
				<a href="login.php"> LOGIN</a> / <a href="register.php">REGISTER</a></div>
			<?php
			}
			else
			{
				$query = "SELECT * FROM orders WHERE client_id = '$user_id' AND status ='Open'";
				$result = mysqli_query($db, $query);
				
				$count = mysqli_num_rows($result);
				if ($count === 0)
				{
					?>
						<img src="Images/cart.png" width = "30" height = "30"> <a href="cart.php">CART</a> /
						<a href="user_orders.php"><strong><?php echo $_SESSION['user']['username']; ?></strong></a>
						<a href="index.php?logout='1'"> / LOGOUT</a>
					<?php
				}
				else
				{
					foreach ($result as $order)
					{
						$order_id = $order['id'];
					}
					$query = "SELECT * FROM item WHERE order_id ='$order_id'";
					$result = mysqli_query($db, $query);
					foreach($result as $item)
					{
						$item_count = $item_count + 1;
					}
					if ($item_count == 0)
					{
					?>
						<img src="Images/cart.png" width = "30" height = "30"> <a href="cart.php">CART</a> /
						<a href="user_orders.php"><strong><?php echo $_SESSION['user']['username']; ?></strong></a>
						<a href="index.php?logout='1'"> / LOGOUT</a>
					<?php
					}
					else 
					{
					?>	
						<div class="cart_div">
							<a href="cart.php">
							<img src="Images/cart.png" width = "30" height = "30"/> CART
							<span><?php echo $item_count; ?></span></a> /
						</div>
						<a href="user_orders.php"><strong><?php echo $_SESSION['user']['username']; ?></strong></a>
						<a href="index.php?logout='1'"> / LOGOUT</a>
					<?php
						$item_count = 0;
					}
				}
			}
				?>
	</div>
</div>

<div class="MainDisplayCart">

	<div class="crt">
	<?php
		$user_id = GetUserID();
		if($user_id != 0)
		{
			$total_price = 0;
			
			$query = "SELECT * FROM orders WHERE client_id = '$user_id' AND status ='Open'";
			$result = mysqli_query($db, $query);
			foreach($result as $order)
			{
				$order_id = $order['id'];
			}
			$query = "SELECT * FROM item WHERE order_id = '$order_id'";
			$result = mysqli_query($db, $query);
			foreach($result as $item)
			{
				$item_count = $item_count + 1;
			}
		}
		if($item_count != 0)
		{
	?>	
			<table class="table">
			<tbody>
			<tr class="crtTR">
			<td></td>
			<td>ITEM NAME</td>
			<td>QUANTITY</td>
			<td>UNIT PRICE</td>
			<td>ITEMS TOTAL</td>
			</tr>
	<?php
			foreach($result as $item)
			{
				
				
				
				$main_category = $item['main_category'];
				$id = $item['item_id'];
				
				$query = "SELECT * FROM $main_category WHERE id='$id'";
				$result2 = mysqli_query($db, $query);
				foreach($result2 as $product)
				{
	?>
					<tr class="CartProductDisplay">
						<td class="CartProductFont">
				<?php
							echo "<img src='".$product["image"]."'/>";
				?>
						</td>
						<td class="CartProductFont">
				<?php
							echo $product["title"];
				?>
							<br />
							
							<form action="cart.php" method="post">
								<input name="order_id" id="order_id" type="hidden" value="<?php echo $item['order_id'];?>" />
								<input name="code" id="code" type="hidden" value="<?php echo $product['id'];?>" />
								<input name="category" id="category" type="hidden" value="<?php echo $product['category'];?>" />
					
								<input name="remove_btn" type="submit"  class="remove"value="Remove Item" />
					
								<input name="product_to_remove" type="hidden" value ="<?php echo $product['id'];?>" />
							</form>
						</td>
						<td class="CartProductFont">
							<form action="cart.php" method="post">
								<div class="ProductStatus">
								<?php echo $item_status; ?> <br>
								</div>
								<input name="order_id" id="order_id" type="hidden" value="<?php echo $item['order_id'];?>" />
								<input name="main_category" id="main_category" type="hidden" value="<?php echo $item['main_category'];?>" />
								<input name="code" id="code" type="hidden" value="<?php echo $product['id'];?>" />
								<input name="category" id="category" type="hidden" value="<?php echo $product['category'];?>" />
								<input name="quantity" type="text" value="<?php echo $item['quantity'];?>" size="1" maxlength="2" />
					
								<input name="adjust_btn<?php echo $product['id'];?>" type="submit" value="change" />
					
								<input name="product_to_change" type="hidden" value ="<?php echo $product['id'];?>" />
								<input name="product_name" type="hidden" value ="<?php echo $product['title'];?>" />
							</form>
						</td>
						<td class="CartProductFont">
				<?php
							echo $product["price"]." €";
				?>
						</td>
						<td class="CartProductFont">
				<?php
							echo $product["price"]*$item['quantity']." €";
				?>
						</td>
					</tr>
				<?php
					$total_price += ($product["price"]*$item['quantity']);
					$url .= "c".$counter."=".$main_category."&i".$counter."=".$product['id']."&q".$counter."=".$item['quantity']."&";
					$counter = $counter +1;
				}
				?>
			<?php
			}
			?>
			</tbody>
			</table>
	<?php
		}
		else
		{
			header("Location: index.php");
		}
		$order_id=$item['order_id'];
		$url .= "order=".$order_id."&cost=".$total_price."&t=".$counter."";
	?>
	</div>
</div>

<div class="CartTotalPriceLocation">
	<div>
		<?php echo $status; ?>
	</div>
	<div align="right" style="color:white;">
		<strong>TOTAL: <?php echo $total_price." €"; ?></strong>
	</div>
</div>

<div class="sub">
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href ='<?php echo $url ?>'">
			Checkout
		</button>
	</div>
</div>

<div class="sales"> TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST  </div>
</body>
</html>
	