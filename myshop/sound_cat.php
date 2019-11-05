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
			<button type="button" class="sub_categories" onclick="window.location.href = 'speakers.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM sound WHERE category = 'Speakers'");
					while($row = mysqli_fetch_array($result))
					{
						if($row['category'] == 'Speakers')
						{
							echo 'Speakers';
						}
					}
				?>
			</button>
	</div>
	<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'amplifiers.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM sound WHERE category = 'Amplifier'");
					while($row = mysqli_fetch_array($result))
					{
						if($row['category'] == 'Amplifier')
						{
							echo 'Amplifiers';
						}
					}
				?>
			</button>
	</div>
	
</div>

<div class="MainDisplay" style="background: #0087e8;">

<?php

	$query = "SELECT * FROM sound 
					WHERE quantity > 0
					ORDER BY RAND() 
					LIMIT 6;";
	$result = mysqli_query($db, $query);
	$output = '';
	foreach($result as $row)
		{	
			if(isAdmin())
			{
				if($row['category'] == "sound")
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductInStock">
									In Stock
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['screen'].' Screen </li>
									<li class="ProductTags">• '.$row['os'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' GPU </li>
									<li class="ProductTags">• '.$row['screen'].' Screen </li>
									<li class="ProductTags">• '.$row['os'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductOutOfStock">
									Out of Stock!
								</div>
								<div>
									<img src="Images/AddToCart.jpeg">
								</div>
								<div> <a href="modify.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
				}
				else
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductInStock">
									In Stock
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductOutOfStock">
									Out of Stock!
								</div>
								<div>
									<img src="Images/AddToCart.jpeg">
								</div>
								<div> <a href="modify.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
				}
			}
			else
			{
				if($row['category'] == "sound")
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' GPU </li>
									<li class="ProductTags">• '.$row['screen'].' Screen </li>
									<li class="ProductTags">• '.$row['os'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductInStock">
									In Stock
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' GPU </li>
									<li class="ProductTags">• '.$row['screen'].' Screen </li>
									<li class="ProductTags">• '.$row['os'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>		
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' GPU </li>
									<li class="ProductTags">• '.$row['screen'].' Screen </li>
									<li class="ProductTags">• '.$row['os'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductOutOfStock">
									Out of Stock!
								</div>
								<div>
									<img src="Images/AddToCart.jpeg">
								</div>				
							</div>
							
						</div>';
					}
				}
				else
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductInStock">
									In Stock
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
												
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="sound_cat.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
												
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category='.$row['category'].'&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductOutOfStock">
									Out of Stock!
								</div>
								<div>
									<img src="Images/AddToCart.jpeg">
								</div>
								>				
							</div>
							
						</div>';
					}
				}
			}
		}
		echo $output;
?>
 
</div>
<div class="sales">  </div>

<?php
		
		if(isset($_GET["AddToCart"]) == true)
		{
			$category = $_GET["category"];
			$sub_category = $_GET["sub_category"];
			$id = $_GET["id"];
			InsertIntoCart($category, $sub_category, $id);
		}
		
	?>


</body>
</html>
