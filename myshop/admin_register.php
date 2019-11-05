<?php include('functions.php') ?>

<?php
#if (isLoggedIn()) {
	#$_SESSION['msg'] = "You must log in first";
#	header('location: index.php');
#}
?>

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
<div class="sub"></div>
</div>
<div class="MainDisplay" align = "center"> 
	<div class="RegisterForm">
	
		<img src="Images/admin_register.png">
		
		<form action="admin_register.php" method = "POST">	<!-- CHANGE HERE -->
			<?php echo display_error(); ?> <!-- FIX THAT THING -->
			
			<div class="inputgroup">
				<label>Username</label>
				<input type="text" id="username" name="username" value="<?php echo $username; ?>">
			</div>
			<div class="inputgroup">
				<label>Email</label>
				<input type="email" id="email" name="email" value="<?php echo $username; ?>">
			</div>
			<div class="inputgroup">
				<label>Password</label>
				<input type="password" id="password_1" name="password_1">
			</div>
			<div class="inputgroup">
				<label>Confirm password</label>
				<input type="password" id="password_2" name="password_2">
			</div>
			<div class="inputgroup">
				<label>Name</label>
				<input type="text" id="name" name="name">
			</div>
			<div class="inputgroup">
				<label>Surname</label>
				<input type="text" id="surname" name="surname">
			</div>
			<div class="inputgroup">
				<label>Telephone</label>
				<input type="text" id="telephone" name="telephone">
			</div>
			<br>
			<div class="inputgroup">
				<input type="submit" id="btn" value="Register Admin" name="AdminRegister_btn" style="height:40px;color:#ffcc00;border:0;background-color:#4a4a4a;font-family:tahoma;font-size:20px;">
			</div>
			
			<p>
				Already a member? <a href="login.php"> Sign in</a>
		</form> 
		
	</div>
</div>
<div class="sales"> </div>
</body>
</html>









