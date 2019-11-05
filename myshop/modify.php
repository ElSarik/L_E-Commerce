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
<title> Supershop</title>
<link rel="stylesheet" href="style.css">
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
</div>
<div class="MainDisplay">
	<?php
		
		if(isset($_GET["category"]) && isset($_GET["sub_category"]) && isset($_GET["id"]))
		{
			$category = $_GET["category"];
			$sub_category = $_GET["sub_category"];
			$id = $_GET["id"];
		}
		
		
		
		$query = "SELECT * FROM $category WHERE category='$sub_category' AND id='$id'";
		
		$result = mysqli_query($db,$query);
		$output = '';
		foreach($result as $row)
		{	
			if($category == "computers")
			{
				$output .=
				
				'<div class="RegisterForm">
		
					<img src="Images/reg.jpg">
			
					<form method = "POST" enctype="multipart/form-data" id="computers">
						<div class="ModifyProductImage"> <img src="'.$row['image'].'"/></div>
				
						<div class="inputgroup">
							<input type="hidden" id="Main_Category" name="Main_Category" value="computers">
						</div>
						<div class="inputgroup">
							<input type="hidden" id="id" name="id" value="'.$id.'">
						</div>
						<div class="inputgroup">
							<label>Manufacturer</label>
							<input type="text" id="manufacturer" name="manufacturer" value="'.$row['manufacturer'].'">
						</div>
						<div class="inputgroup">
							<label>Title</label>
							<input type="text" id="title" name="title" value="'.$row['title'].'">
						</div>
						<div class="inputgroup">
							<label>CPU</label>
							<input type="text" id="cpu" name="cpu" value="'.$row['cpu'].'">
						</div>
						<div class="inputgroup">
							<label>RAM</label>
							<input type="text" id="ram" name="ram" value="'.$row['ram'].'">
						</div>
						<div class="inputgroup">
							<label>Storage</label>
							<input type="text" id="storage" name="storage" value="'.$row['storage'].'">
						</div>
						<div class="inputgroup">
							<label>GPU</label>
							<input type="text" id="gpu" name="gpu" value="'.$row['gpu'].'">
						</div>
						<div class="inputgroup">
							<label>Screen</label>
							<input type="text" id="screen" name="screen" value="'.$row['screen'].'">
						</div>
						<div class="inputgroup">
							<label>OS</label>
							<input type="text" id="os" name="os" value="'.$row['os'].'">
						</div>
						<div class="inputgroup">
							<label>Price</label>
							<input type="text" id="price" name="price" value="'.$row['price'].'">
						</div>
						<div class="inputgroup">
							<label>Quantity</label>
							<input type="number" id="quantity" name="quantity" value="'.$row['quantity'].'">
						</div>
						<div class="inputgroup">
							<label>Description</label>
							<textarea rows="8" cols="73" id="description" name="description"> '.$row['description'].'</textarea>
						</div>
						<div class="inputgroup">
							<label>Url</label>
							<input type="text" id="url" name="url" value="'.$row['url'].'">
						</div>
						<div class="inputgroup">
							<label>Image</label>
							<input type="file" id="image" name="image">
						</div>
						<br>
						<div class="inputgroup">
							<input type="submit" id="btn" value="Modify Product" name="ModidfyProduct_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
						</div>
					</form>
					<br>
					<form method="post">
						<div class="inputgroup">
							<input type="hidden" id="Main_Category" name="Main_Category" value="computers">
						</div>
						<div class="inputgroup">
							<input type="hidden" id="id" name="id" value="'.$id.'">
						</div>
						
						<input type="submit" id="remove" value="Remove Product" name="Remove_btn">
					</form>
				</div>';
			}
			
			if($category == "smartphones")
			{
				$output .=
				
				'<div class="RegisterForm">
		
					<img src="Images/reg.jpg">
			
					<form method = "POST" enctype="multipart/form-data" id="smartphones">
						<div class="ModifyProductImage"> <img src="'.$row['image'].'"/></div>
				
						<div class="inputgroup">
							<input type="hidden" id="Main_Category" name="Main_Category" value="smartphones">
						</div>
						<div class="inputgroup">
							<input type="hidden" id="id" name="id" value="'.$id.'">
						</div>
						<div class="inputgroup">
							<label>Manufacturer</label>
							<input type="text" id="manufacturer" name="manufacturer" value="'.$row['manufacturer'].'">
						</div>
						<div class="inputgroup">
							<label>Title</label>
							<input type="text" id="title" name="title" value="'.$row['title'].'">
						</div>
						<div class="inputgroup">
							<label>CPU</label>
							<input type="text" id="cpu" name="cpu" value="'.$row['cpu'].'">
						</div>
						<div class="inputgroup">
							<label>RAM</label>
							<input type="text" id="ram" name="ram" value="'.$row['ram'].'">
						</div>
						<div class="inputgroup">
							<label>Storage</label>
							<input type="text" id="storage" name="storage" value="'.$row['storage'].'">
						</div>
						<div class="inputgroup">
							<label>Screen</label>
							<input type="text" id="screen" name="screen" value="'.$row['screen'].'">
						</div>
						<div class="inputgroup">
							<label>OS</label>
							<input type="text" id="os" name="os" value="'.$row['os'].'">
						</div>
						<div class="inputgroup">
							<label>Price</label>
							<input type="text" id="price" name="price" value="'.$row['price'].'">
						</div>
						<div class="inputgroup">
							<label>Quantity</label>
							<input type="number" id="quantity" name="quantity" value="'.$row['quantity'].'">
						</div>
						<div class="inputgroup">
							<label>Description</label>
							<textarea rows="8" cols="73" id="description" name="description"> '.$row['description'].'</textarea>
						</div>
						<div class="inputgroup">
							<label>Url</label>
							<input type="text" id="url" name="url" value="'.$row['url'].'">
						</div>
						<div class="inputgroup">
							<label>Image</label>
							<input type="file" id="image" name="image">
						</div>
						<br>
						<div class="inputgroup">
							<input type="submit" id="btn" value="Modify Product" name="ModidfyProduct_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
						</div>
					</form>
					<br>
					<form method="post">
						<div class="inputgroup">
							<input type="hidden" id="Main_Category" name="Main_Category" value="smartphones">
						</div>
						<div class="inputgroup">
							<input type="hidden" id="id" name="id" value="'.$id.'">
						</div>
						
						<input type="submit" id="remove" value="Remove Product" name="Remove_btn">
					</form>
				</div>';
			}
			
			if($category == "sound")
			{
				$output .=
				
				'<div class="RegisterForm">
		
					<img src="Images/reg.jpg">
			
					<form method = "POST" enctype="multipart/form-data" id="sound">
						<div class="ModifyProductImage"> <img src="'.$row['image'].'"/></div>
				
						<div class="inputgroup">
							<input type="hidden" id="Main_Category" name="Main_Category" value="sound">
						</div>
						<div class="inputgroup">
							<input type="hidden" id="id" name="id" value="'.$id.'">
						</div>
						<div class="inputgroup">
							<label>Manufacturer</label>
							<input type="text" id="manufacturer" name="manufacturer" value="'.$row['manufacturer'].'">
						</div>
						<div class="inputgroup">
							<label>Title</label>
							<input type="text" id="title" name="title" value="'.$row['title'].'">
						</div>
						<div class="inputgroup">
							<label>Power</label>
							<input type="text" id="power" name="power" value="'.$row['power'].'">
						</div>
						<div class="inputgroup">
							<label>Type</label>
							<input type="text" id="type" name="type" value="'.$row['type'].'">
						</div>
						<div class="inputgroup">
							<label>Price</label>
							<input type="text" id="price" name="price" value="'.$row['price'].'">
						</div>
						<div class="inputgroup">
							<label>Quantity</label>
							<input type="number" id="quantity" name="quantity" value="'.$row['quantity'].'">
						</div>
						<div class="inputgroup">
							<label>Description</label>
							<textarea rows="8" cols="73" id="description" name="description"> '.$row['description'].'</textarea>
						</div>
						<div class="inputgroup">
							<label>Url</label>
							<input type="text" id="url" name="url" value="'.$row['url'].'">
						</div>
						<div class="inputgroup">
							<label>Image</label>
							<input type="file" id="image" name="image">
						</div>
						<br>
						<div class="inputgroup">
							<input type="submit" id="btn" value="Modify Product" name="ModidfyProduct_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
						</div>
					</form>
					<br>
					<form method="post">
						<div class="inputgroup">
							<input type="hidden" id="Main_Category" name="Main_Category" value="sound">
						</div>
						<div class="inputgroup">
							<input type="hidden" id="id" name="id" value="'.$id.'">
						</div>
						
						<input type="submit" id="remove" value="Remove Product" name="Remove_btn">
					</form>
				</div>';
			}
		}
		echo $output;
	?>
	 <br>
	 <br>
</div>
<div class="sales"> TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST  </div>

</body>
</html>


