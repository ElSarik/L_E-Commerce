<?php include('functions.php') ?>

<?php
if (isAdmin()==false) {
	header('location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> Supershop </title>
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

<div class="sub">
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'product_creation.php?category=computers';">
			New Computer
		</button>
	</div>
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'product_creation.php?category=smartphones';">
			New Smartphone
		</button>
	</div>
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'product_creation.php?category=sound';">
			New Sound
		</button>
	</div>
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'product_creation.php?category=vision';">
			New Vision
		</button>
	</div>
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'product_creation.php?category=appliances';">
			New Appliance
		</button>
	</div>
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'product_creation.php?category=books';">
			New Book
		</button>
	</div>
</div>

<div class="MainDisplay" align = "center"> 
	
	<?php
	
		$category = $_GET["category"];
	
		if($category == "computers"):	?>
			<div class="RegisterForm">
	
				<img src="Images/product_creation.png">
		
				<form action="product_creation.php?category=computers" method = "POST" enctype="multipart/form-data" id="computers">	<!-- CHANGE HERE -->
					<?php echo display_error(); ?> <!-- FIX THAT THING -->
			
					<div class="inputgroup">
						<input type="hidden" id="Main_Category" name="Main_Category" value="computers">
					</div>
					<div class="inputgroup">
						<label>Category</label>
						<select name="category" form="computers" style="position: relative;height: 42px;font-size: 16px; width: 96%;">
							<option value="Desktops">Desktops</option>
							<option value="aiod">All in one desktops</option>
							<option value="Laptops">Laptops</option>
							<option value="Tablets">Tablets</option>

						</select>
					</div>
					<div class="inputgroup">
						<label>Manufacturer</label>
						<input type="text" id="manufacturer" name="manufacturer">
					</div>
					<div class="inputgroup">
						<label>Title</label>
						<input type="text" id="title" name="title">
					</div>
					<div class="inputgroup">
						<label>CPU</label>
						<input type="cpu" id="cpu" name="cpu">
					</div>
					<div class="inputgroup">
						<label>RAM</label>
						<input type="text" id="ram" name="ram">
					</div>
					<div class="inputgroup">
						<label>Storage</label>
						<input type="text" id="storage" name="storage">
					</div>
					<div class="inputgroup">
						<label>GPU (Camera for Tablets)</label>
						<input type="text" id="gpu" name="gpu">
					</div>
					<div class="inputgroup">
						<label>Screen</label>
						<input type="text" id="screen" name="screen">
					</div>
					<div class="inputgroup">
						<label>OS</label>
						<input type="text" id="os" name="os">
					</div>
					<div class="inputgroup">
						<label>Price</label>
						<input type="text" id="price" name="price">
					</div>
					<div class="inputgroup">
						<label>Quantity</label>
						<input type="number" id="quantity" name="quantity">
					</div>
					<div class="inputgroup">
						<label>Description</label>
						<textarea rows="8" cols="73" id="description" name="description"></textarea>
					</div>
					<div class="inputgroup">
						<label>Url</label>
						<input type="text" id="url" name="url">
					</div>
					<div class="inputgroup">
						<label>Image</label>
						<input type="file" id="image" name="image">
					</div>
					<br>
					<div class="inputgroup">
						<input type="submit" id="btn" value="Add Product" name="AddProduct_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
					</div>
				</form> 
			</div>
			
	<?php elseif($category == "smartphones"):?>
		<div class="RegisterForm">
	
				<img src="Images/product_creation.png">
		
				<form action="product_creation.php?category=smartphones" method = "POST" enctype="multipart/form-data" id="smartphones">	<!-- CHANGE HERE -->
					<?php echo display_error(); ?> <!-- FIX THAT THING -->
			
					<div class="inputgroup">
						<input type="hidden" id="Main_Category" name="Main_Category" value="smartphones">
					</div>
					<div class="inputgroup">
						<label>Category</label>
						<select name="category" form="smartphones" style="position: relative;height: 42px;font-size: 16px; width: 96%;">
							<option value="Smartphone">Smartphone</option>
							<option value="Case">Case</option>
							
						</select>
					</div>
					<div class="inputgroup">
						<label>Manufacturer</label>
						<input type="text" id="manufacturer" name="manufacturer">
					</div>
					<div class="inputgroup">
						<label>Title</label>
						<input type="text" id="title" name="title">
					</div>
					<div class="inputgroup">
						<label>CPU</label>
						<input type="cpu" id="cpu" name="cpu">
					</div>
					<div class="inputgroup">
						<label>RAM</label>
						<input type="text" id="ram" name="ram">
					</div>
					<div class="inputgroup">
						<label>Storage</label>
						<input type="text" id="storage" name="storage">
					</div>
					<div class="inputgroup">
						<label>Screen</label>
						<input type="text" id="screen" name="screen">
					</div>
					<div class="inputgroup">
						<label>OS</label>
						<input type="text" id="os" name="os">
					</div>
					<div class="inputgroup">
						<label>Price</label>
						<input type="text" id="price" name="price">
					</div>
					<div class="inputgroup">
						<label>Quantity</label>
						<input type="number" id="quantity" name="quantity">
					</div>
					<div class="inputgroup">
						<label>Description</label>
						<textarea rows="8" cols="73" id="description" name="description"></textarea>
					</div>
					<div class="inputgroup">
						<label>Url</label>
						<input type="text" id="url" name="url">
					</div>
					<div class="inputgroup">
						<label>Image</label>
						<input type="file" id="image" name="image">
					</div>
					<br>
					<div class="inputgroup">
						<input type="submit" id="btn" value="Add Product" name="AddProduct_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
					</div>
				</form> 
		</div>
		
		
	<?php elseif($category == "sound"):?>
		<div class="RegisterForm">
	
				<img src="Images/product_creation.png">
		
				<form action="product_creation.php?category=sound" method = "POST" enctype="multipart/form-data" id="sound">	<!-- CHANGE HERE -->
					<?php echo display_error(); ?> <!-- FIX THAT THING -->
			
					<div class="inputgroup">
						<input type="hidden" id="Main_Category" name="Main_Category" value="sound">
					</div>
					<div class="inputgroup">
						<label>Category</label>
						<select name="category" form="sound" style="position: relative;height: 42px;font-size: 16px; width: 96%;">
							<option value="Speakers">Speakers</option>
							<option value="Amplifier">Amplifier</option>
							
						</select>
					</div>
					<div class="inputgroup">
						<label>Manufacturer</label>
						<input type="text" id="manufacturer" name="manufacturer">
					</div>
					<div class="inputgroup">
						<label>Title</label>
						<input type="text" id="title" name="title">
					</div>
					<div class="inputgroup">
						<label>Power</label>
						<input type="text" id="power" name="power">
					</div>
					<div class="inputgroup">
						<label>Type</label>
						<input type="text" id="type" name="type">
					</div>
					<div class="inputgroup">
						<label>Price</label>
						<input type="text" id="price" name="price">
					</div>
					<div class="inputgroup">
						<label>Quantity</label>
						<input type="number" id="quantity" name="quantity">
					</div>
					<div class="inputgroup">
						<label>Description</label>
						<textarea rows="8" cols="73" id="description" name="description"></textarea>
					</div>
					<div class="inputgroup">
						<label>Url</label>
						<input type="text" id="url" name="url">
					</div>
					<div class="inputgroup">
						<label>Image</label>
						<input type="file" id="image" name="image">
					</div>
					<br>
					<div class="inputgroup">
						<input type="submit" id="btn" value="Add Product" name="AddProduct_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
					</div>
				</form> 
		</div>		
	<?php else:?>
	
	<?php endif ?>
</div>

<div class="sales"> </div>

</body>
</html>