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
	<?php if (isAdmin()) : ?>
		<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'admin_register.php';">
				Admin Register
			</button>
		</div>
		<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'product_creation.php?category=computers';">
				Create Product
			</button>
		</div>
		<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'orders.php';">
				Orders
			</button>
		</div>
	<?php endif ?>
</div>
<div class="MainDisplay" style="background: #0087e8;">
<?php
	
	$query =  "SELECT * FROM
			(
					SELECT 'computers' AS MCat, id, category, quantity FROM computers
					WHERE quantity > 0 
				UNION ALL
					SELECT 'smartphones' AS MCat, id, category, quantity FROM smartphones
					WHERE quantity > 0 
				UNION ALL
					SELECT 'sound' AS MCat, id, category, quantity FROM sound
					WHERE quantity > 0 
				ORDER BY RAND()
				LIMIT 8
			) T1
			ORDER BY quantity DESC;";
	$result = mysqli_query($db, $query);
	$output = '';
	foreach($result as $r)
	{
		$query2 = "SELECT * FROM ".$r['MCat']." WHERE id = '".$r['id']."' AND category = '".$r['category']."'";
		$result2 = mysqli_query($db, $query2);
		foreach($result2 as $row)
		{
			if($row['category'] == 'Desktops')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Desktops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=Desktops&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Desktops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=Desktops&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Desktops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<div> <a href="modify.php?category=computers&sub_category=Desktops&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Desktops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Desktops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Desktops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
			}
// END OF DESKTOPS
			if($row['category']== 'aiod')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=aiod&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=aiod&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=aiod&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=aiod&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=aiod&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<div> <a href="modify.php?category=computers&sub_category=aiod&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=aiod&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=aiod&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=aiod&id='.$row['id'].'">'.$row['title'].'</a></div>
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
			}
// END OF AIOD
			if($row['category']=='Laptops')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=Laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=Laptops&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=Laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=Laptops&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
								<div> <a href="modify.php?category=computers&sub_category=Laptops&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=Laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=Laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=Laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
			}
// END OF LAPTOPS
			if($row['category'] == 'Tablets')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=tablets&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=tablets&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=tablets&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=computers&sub_category=tablets&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=tablets&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
								<div> <a href="modify.php?category=computers&sub_category=tablets&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=tablets&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=tablets&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
									<a href="index.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=tablets&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									<li class="ProductTags">• '.$row['gpu'].' </li>
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
			}
// END OF TABLETS			
			if($row['category'] == 'Smartphone')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' Processor </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
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
									<a href="index.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' Processor </li>
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
									<a href="index.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' Processor </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									
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
								<div> <a href="modify.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' Processor </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									
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
									<a href="index.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' Processor </li>
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
									<a href="index.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['cpu'].' Processor </li>
									<li class="ProductTags">• '.$row['ram'].' GB RAM </li>
									<li class="ProductTags">• '.$row['storage'].' Storage </li>
									
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
			}
// END OF SMARTPHONES
			if($row['category'] == 'Case')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=case&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=smartphones&sub_category=case&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=case&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=smartphones&sub_category=case&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=case&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<div> <a href="modify.php?category=smartphones&sub_category=case&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=case&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=case&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=case&id='.$row['id'].'">'.$row['title'].'</a></div>
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
							</div>
							
						</div>';
					}
				}
			}
// END OF CASES			
			if($row['category'] == 'Speakers')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=speakers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category=speakers&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=speakers&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="index.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category=speakers&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=speakers&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
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
								<div> <a href="modify.php?category=sound&sub_category=speakers&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=speakers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=speakers&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="index.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=speakers&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
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
			}
// END OF SPEAKERS
			if($row['category'] == 'Amplifier')
			{
				if(isAdmin())
				{
					if($row['quantity'] > 5)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=amplifier&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category=amplifier&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] <= 5 && $row['quantity'] > 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=amplifier&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="index.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
								</div>
								<div> <a href="modify.php?category=sound&sub_category=amplifier&id='.$row['id'].'">Modify Product </a> </div>				
							</div>
							
						</div>';
					}
					if($row['quantity'] == 0)
					{
						$output .=
							#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
						'<div class="Product" id='.$row['id'].'> 
							
							<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=amplifier&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
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
								<div> <a href="modify.php?category=sound&sub_category=amplifier&id='.$row['id'].'">Modify Product </a> </div>				
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=amplifier&id='.$row['id'].'">'.$row['title'].'</a></div>
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
									<a href="index.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=amplifier&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
								</ul>
							</div>
							<div class="ProductPrice"> '.$row['price']. " €" .'</div>
							<div class="ProductCart">
								<div class="ProductLimitedStock">
									Limited Availability
								</div>
								<div>
									<a href="index.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
							<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=amplifier&id='.$row['id'].'">'.$row['title'].'</a></div>
							<div class="ProductDescription"> 
								<ul>
									<li class="ProductTags">• '.$row['manufacturer'].' </li>
									<li class="ProductTags">• '.$row['power'].' </li>
									<li class="ProductTags">• '.$row['type'].' </li>
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
			}
// END OF AMPLIFIERS
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









