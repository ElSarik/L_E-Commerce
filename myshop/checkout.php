
<?php include('functions.php')?>

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

</div>

<div class="MainDisplay" align = "center"> 
	
	<?php
	
		$user_id = GetUserID();
		
		
		$query = "SELECT * FROM client WHERE id='$user_id'";
		
		$result = mysqli_query($db,$query);
		$output = '';
		foreach($result as $row)
		{
			$output .=
			
			'<div class="RegisterForm">
		
					<img src="Images/reg.jpg">
			
					<form method = "POST" id="cred_confirm">

						<div class="inputgroup">
							<label>Name</label>
							<input type="text" id="name" name="name" value="'.$row['name'].'">
						</div>
						<div class="inputgroup">
							<label>Surname</label>
							<input type="text" id="surname" name="surname" value="'.$row['surname'].'">
						</div>
						<div class="inputgroup">
							<label>Telephone</label>
							<input type="text" id="telephone" name="telephone" value="'.$row['telephone'].'">
						</div>
						<div class="inputgroup">
							<label>Email</label>
							<input type="email" id="email" name="email" value="'.$row['email'].'">
						</div>
						<div class="inputgroup">
							<label>Address</label>
							<input type="text" id="address" name="address" value="'.$row['address'].'">
						</div>
						
						<br>
						<div class="inputgroup">
							<input type="submit" id="confirm_credentials_btn" value="Confirm Credentials & Finalize Order" name="confirm_credentials_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
						</div>
					</form>
				</div>';
		}
		
		echo $output;
		
		if(isset($_POST['confirm_credentials_btn']))
		{
			$client_id = $user_id;
			$order_id = $_GET['order'];
			$cost = $_GET['cost'];
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$telephone = $_POST['telephone'];
			$email = $_POST['email'];
			$address = $_POST['address'];
			
			if($name == "" || $surname == "" || $telephone == "" || $email == "" || $address == "")
			{
				echo "Fields must not be empty!";
			}
			else
			{
				$query = "UPDATE orders
						SET status='Received', address='$address', name='$name', surname='$surname', cost='$cost'
						WHERE client_id ='$client_id' && id ='$order_id'";
				
				mysqli_query($db, $query);
				
				$total = $_GET['t'];
				for($i = 0 ; $i < $total ; $i++)
				{
					$category = $_GET['c'.$i.''];
					$id = $_GET['i'.$i.''];
					$quantity = $_GET['q'.$i.''];
					
					$query = "SELECT * FROM $category WHERE id='$id'";
					$result = mysqli_query($db, $query);
					foreach($result as $product)
					{
						$original_quantity = $product['quantity'];
					}
					
					$new_quantity = $original_quantity - $quantity;
					
					$query = "UPDATE $category
							SET quantity='$new_quantity'
							WHERE id='$id'";
					mysqli_query($db, $query);
				}
				header("Location: index.php");
			}
			
		}
	?>
</div>

<div class="sales"> </div>

</body>
</html>