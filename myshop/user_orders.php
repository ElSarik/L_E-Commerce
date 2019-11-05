<?php include('functions.php') ?>

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
<div class="sub">
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'user_orders.php';">
			All Orders
		</button>
	</div>
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'user_orders.php?filter=Sent';">
			Pending
		</button>
	</div>
	<div>
		<button type="button" class="sub_categories" onclick="window.location.href = 'user_orders.php?filter=Completed';">
			Completed
		</button>
	</div>
</div>

<div class="OrdersMainDisplay" style="background: #014b80;">

<?php

$user_id = GetUserID();

	if (isset($_POST['order_id']))
	{
		$order_id = $_POST['order_id'];
		if (isset($_POST['status_change']))
		{
			$new_status = $_POST['status_change'];
			// echo $new_status;
			
			$query = "UPDATE orders 
					SET status='$new_status'
					WHERE id='$order_id'";
					
			mysqli_query($db, $query);
			
			header("orders.php");
		}
	}
	
	if(isset($_GET["filter"]))
	{
		$filter = $_GET["filter"];
		
		if($filter == "Completed")
		{
			$output = "";
			
			$query1 = "SELECT * FROM orders WHERE status !='Open' AND status ='Completed' AND client_id='$user_id'";
			$result1 = mysqli_query($db, $query1);
			foreach($result1 as $order)
			{
				$output .= 
					"
						<div class='OrdersWindow'>
						<div class='OrdersDetails'>".$order['id']." | ".$order['status']." | ".$order['address']." | ".$order['name']." ".$order['surname']." | ".$order['cost']."
						</div>
					";
					
					
				
				
				$order_id = $order['id'];
				$query2 = "SELECT * FROM item WHERE order_id='$order_id'";
				$result2 = mysqli_query($db, $query2);
				foreach($result2 as $item)
				{
					$main_category = $item['main_category'];
					$item_id = $item['item_id'];
					
					$query3 = "SELECT * FROM ".$main_category." WHERE id='".$item_id."'";
					
					$result3 = mysqli_query($db, $query3);
					foreach($result3 as $product)
					{
						$output .= '
						<div class="OrdersProduct">
						"'.$product['id'].'" | "<a class="OrdersLinkFix" href="product.php?category='.$main_category.'&sub_category='.$product['category'].'&id='.$product['id'].'">'.$product['title'].'</a>" | "'.$item['quantity'].'"
						</div>
						';
						
					}
				}
				
				$output .="</div>";
			}
			echo $output;
			
		}
		elseif($filter == "Sent")
		{		
			$output = "";
			
			$query1 = "SELECT * FROM orders WHERE status !='Open' AND status ='$filter' AND client_id='$user_id' OR status ='Received' AND client_id='$user_id'";
			$result1 = mysqli_query($db, $query1);
			foreach($result1 as $order)
			{
				$output .= 
					"
						<div class='OrdersWindow'>
						<div class='OrdersDetails'>".$order['id']." | ".$order['status']." | ".$order['address']." | ".$order['name']." ".$order['surname']." | ".$order['cost']."
						</div>
					";
					
					
				
				
				$order_id = $order['id'];
				$query2 = "SELECT * FROM item WHERE order_id='$order_id'";
				$result2 = mysqli_query($db, $query2);
				foreach($result2 as $item)
				{
					$main_category = $item['main_category'];
					$item_id = $item['item_id'];
					
					$query3 = "SELECT * FROM ".$main_category." WHERE id='".$item_id."'";
					
					$result3 = mysqli_query($db, $query3);
					foreach($result3 as $product)
					{
						$output .= '
						<div class="OrdersProduct">
						"'.$product['id'].'" | "<a class="OrdersLinkFix" href="product.php?category='.$main_category.'&sub_category='.$product['category'].'&id='.$product['id'].'">'.$product['title'].'</a>" | "'.$item['quantity'].'"
						</div>
						';
						
					}
				}
				
				$output .="</div>";
			}
			echo $output;
		}
	}
	else
	{
		$output = "";
		
		$query1 = "SELECT * FROM orders WHERE status !='Open' AND client_id='$user_id'";
		$result1 = mysqli_query($db, $query1);
		foreach($result1 as $order)
		{
			$output .= 
				"
					<div class='OrdersWindow'>
					<div class='OrdersDetails'>".$order['id']." | ".$order['status']." | ".$order['address']." | ".$order['name']." ".$order['surname']." | ".$order['cost']."
					</div>
				";
			
			
			$order_id = $order['id'];
			$query2 = "SELECT * FROM item WHERE order_id='$order_id'";
			$result2 = mysqli_query($db, $query2);
			foreach($result2 as $item)
			{
				$main_category = $item['main_category'];
				$item_id = $item['item_id'];
				
				$query3 = "SELECT * FROM ".$main_category." WHERE id='".$item_id."'";
				
				$result3 = mysqli_query($db, $query3);
				foreach($result3 as $product)
				{
					$output .= '
					<div class="OrdersProduct">
					"'.$product['id'].'" | "<a class="OrdersLinkFix" href="product.php?category='.$main_category.'&sub_category='.$product['category'].'&id='.$product['id'].'">'.$product['title'].'</a>" | "'.$item['quantity'].'"
					</div>
					';
					
				}
			}
			
			$output .="</div>";
		}
		echo $output;
	}
?>

</div>

<div class="sales">

</div>
</body>
</html>