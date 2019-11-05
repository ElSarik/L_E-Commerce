<?php include('functions.php') ?>

<?php

$db = mysqli_connect('localhost', 'root', '', 'my_shop');

if(isset($_POST["desktops"]))
{
	$query = "
		SELECT * FROM computers WHERE category='Desktops'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["cpu"]))
	{
		$processor_filter = implode("','", $_POST["cpu"]);
		$query .= "
		 AND cpu IN('".$processor_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND storage IN('".$storage_filter."')
		";
	}
	if(isset($_POST["gpu"]))
	{
		$gpu_filter = implode("','", $_POST["gpu"]);
		$query .= "
		 AND gpu IN('".$gpu_filter."')
		";
	}
	if(isset($_POST["screen"]))
	{
		$screen_filter = implode("','", $_POST["screen"]);
		$query .= "
		 AND screen IN('".$screen_filter."')
		";
	}
	if(isset($_POST["os"]))
	{
		$os_filter = implode("','", $_POST["os"]);
		$query .= "
		 AND os IN('".$os_filter."')
		";
	}
	if(isset($_POST["under500"]))
	{
		$under500_filter = implode("','", $_POST["under500"]);
		$query .= "
		 AND price < 500
		";
	}
	if(isset($_POST["between5001000"]))
	{
		$between5001000_filter = implode("','", $_POST["between5001000"]);
		$query .= "
		 AND price > 500 AND price < 1000
		";
	}
	if(isset($_POST["over1000"]))
	{
		$over1000_filter = implode("','", $_POST["over1000"]);
		$query .= "
		 AND price > 1000
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
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
								<a href="desktops.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="desktops.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="desktops.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="desktops.php?category=computers&sub_category=Desktops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
	}
	echo $output;
}

if(isset($_POST["aiod"]))
{
	$query = "
		SELECT * FROM computers WHERE category='aiod'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["cpu"]))
	{
		$processor_filter = implode("','", $_POST["cpu"]);
		$query .= "
		 AND cpu IN('".$processor_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND storage IN('".$storage_filter."')
		";
	}
	if(isset($_POST["gpu"]))
	{
		$gpu_filter = implode("','", $_POST["gpu"]);
		$query .= "
		 AND gpu IN('".$gpu_filter."')
		";
	}
	if(isset($_POST["screen"]))
	{
		$screen_filter = implode("','", $_POST["screen"]);
		$query .= "
		 AND screen IN('".$screen_filter."')
		";
	}
	if(isset($_POST["os"]))
	{
		$os_filter = implode("','", $_POST["os"]);
		$query .= "
		 AND os IN('".$os_filter."')
		";
	}
	if(isset($_POST["under500"]))
	{
		$under500_filter = implode("','", $_POST["under500"]);
		$query .= "
		 AND price < 500
		";
	}
	if(isset($_POST["between5001000"]))
	{
		$between5001000_filter = implode("','", $_POST["between5001000"]);
		$query .= "
		 AND price > 500 AND price < 1000
		";
	}
	if(isset($_POST["over1000"]))
	{
		$over1000_filter = implode("','", $_POST["over1000"]);
		$query .= "
		 AND price > 1000
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
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
								<a href="all_in_one_desktops.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="all_in_one_desktops.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="all_in_one_desktops.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="all_in_one_desktops.php?category=computers&sub_category=aiod&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
	}
	echo $output;
}

if(isset($_POST["laptops"]))
{
	$query = "
		SELECT * FROM computers WHERE category='laptops'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["cpu"]))
	{
		$processor_filter = implode("','", $_POST["cpu"]);
		$query .= "
		 AND cpu IN('".$processor_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND storage IN('".$storage_filter."')
		";
	}
	if(isset($_POST["gpu"]))
	{
		$gpu_filter = implode("','", $_POST["gpu"]);
		$query .= "
		 AND gpu IN('".$gpu_filter."')
		";
	}
	if(isset($_POST["screen"]))
	{
		$screen_filter = implode("','", $_POST["screen"]);
		$query .= "
		 AND screen IN('".$screen_filter."')
		";
	}
	if(isset($_POST["os"]))
	{
		$os_filter = implode("','", $_POST["os"]);
		$query .= "
		 AND os IN('".$os_filter."')
		";
	}
	if(isset($_POST["under500"]))
	{
		$under500_filter = implode("','", $_POST["under500"]);
		$query .= "
		 AND price < 500
		";
	}
	if(isset($_POST["between5001000"]))
	{
		$between5001000_filter = implode("','", $_POST["between5001000"]);
		$query .= "
		 AND price > 500 AND price < 1000
		";
	}
	if(isset($_POST["over1000"]))
	{
		$over1000_filter = implode("','", $_POST["over1000"]);
		$query .= "
		 AND price > 1000
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
		{	
			if(isAdmin())
			{
				if($row['quantity'] > 5)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="laptops.php?category=computers&sub_category=laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=computers&sub_category=laptops&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] <= 5 && $row['quantity'] > 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="laptops.php?category=computers&sub_category=laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=computers&sub_category=laptops&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] == 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
							<div> <a href="modify.php?category=computers&sub_category=laptops&id='.$row['id'].'">Modify Product </a> </div>				
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="laptops.php?category=computers&sub_category=laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="laptops.php?category=computers&sub_category=laptops&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=laptops&id='.$row['id'].'">'.$row['title'].'</a></div>
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
	}
	echo $output;
}

if(isset($_POST["tablets"]))
{
	$query = "
		SELECT * FROM computers WHERE category='tablets'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["cpu"]))
	{
		$processor_filter = implode("','", $_POST["cpu"]);
		$query .= "
		 AND cpu IN('".$processor_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND storage IN('".$storage_filter."')
		";
	}
	if(isset($_POST["gpu"]))
	{
		$gpu_filter = implode("','", $_POST["gpu"]);
		$query .= "
		 AND gpu IN('".$gpu_filter."')
		";
	}
	if(isset($_POST["screen"]))
	{
		$screen_filter = implode("','", $_POST["screen"]);
		$query .= "
		 AND screen IN('".$screen_filter."')
		";
	}
	if(isset($_POST["os"]))
	{
		$os_filter = implode("','", $_POST["os"]);
		$query .= "
		 AND os IN('".$os_filter."')
		";
	}
	if(isset($_POST["under500"]))
	{
		$under500_filter = implode("','", $_POST["under500"]);
		$query .= "
		 AND price < 100
		";
	}
	if(isset($_POST["between5001000"]))
	{
		$between5001000_filter = implode("','", $_POST["between5001000"]);
		$query .= "
		 AND price > 100 AND price < 300
		";
	}
	if(isset($_POST["over1000"]))
	{
		$over1000_filter = implode("','", $_POST["over1000"]);
		$query .= "
		 AND price > 300
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
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
								<a href="tablets.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="tablets.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="tablets.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="tablets.php?category=computers&sub_category=tablets&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
	}
	echo $output;
}

if(isset($_POST["AM"]))
{
	$query = "
		SELECT * FROM computers WHERE category='AM'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["cpu"]))
	{
		$processor_filter = implode("','", $_POST["cpu"]);
		$query .= "
		 AND cpu IN('".$processor_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND storage IN('".$storage_filter."')
		";
	}
	if(isset($_POST["gpu"]))
	{
		$gpu_filter = implode("','", $_POST["gpu"]);
		$query .= "
		 AND gpu IN('".$gpu_filter."')
		";
	}
	if(isset($_POST["screen"]))
	{
		$screen_filter = implode("','", $_POST["screen"]);
		$query .= "
		 AND screen IN('".$screen_filter."')
		";
	}
	if(isset($_POST["os"]))
	{
		$os_filter = implode("','", $_POST["os"]);
		$query .= "
		 AND os IN('".$os_filter."')
		";
	}
	if(isset($_POST["under500"]))
	{
		$under500_filter = implode("','", $_POST["under500"]);
		$query .= "
		 AND price < 500
		";
	}
	if(isset($_POST["between5001000"]))
	{
		$between5001000_filter = implode("','", $_POST["between5001000"]);
		$query .= "
		 AND price > 500 AND price < 1000
		";
	}
	if(isset($_POST["over1000"]))
	{
		$over1000_filter = implode("','", $_POST["over1000"]);
		$query .= "
		 AND price > 1000
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
		{	
			if(isAdmin())
			{
				if($row['quantity'] > 5)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=AM&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="apple_mac.php?category=computers&sub_category=AM&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=computers&sub_category=AM&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] <= 5 && $row['quantity'] > 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=AM&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="apple_mac.php?category=computers&sub_category=AM&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=computers&sub_category=AM&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] == 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=AM&id='.$row['id'].'">'.$row['title'].'</a></div>
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
							<div> <a href="modify.php?category=computers&sub_category=AM&id='.$row['id'].'">Modify Product </a> </div>				
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=AM&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="apple_mac.php?category=computers&sub_category=AM&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=AM&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="apple_mac.php?category=computers&sub_category=AM&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=AM&id='.$row['id'].'">'.$row['title'].'</a></div>
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
	}
	echo $output;
}

if(isset($_POST["servers"]))
{
	$query = "
		SELECT * FROM computers WHERE category='servers'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["cpu"]))
	{
		$processor_filter = implode("','", $_POST["cpu"]);
		$query .= "
		 AND cpu IN('".$processor_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND storage IN('".$storage_filter."')
		";
	}
	if(isset($_POST["gpu"]))
	{
		$gpu_filter = implode("','", $_POST["gpu"]);
		$query .= "
		 AND gpu IN('".$gpu_filter."')
		";
	}
	if(isset($_POST["screen"]))
	{
		$screen_filter = implode("','", $_POST["screen"]);
		$query .= "
		 AND screen IN('".$screen_filter."')
		";
	}
	if(isset($_POST["os"]))
	{
		$os_filter = implode("','", $_POST["os"]);
		$query .= "
		 AND os IN('".$os_filter."')
		";
	}
	if(isset($_POST["under500"]))
	{
		$under500_filter = implode("','", $_POST["under500"]);
		$query .= "
		 AND price < 500
		";
	}
	if(isset($_POST["between5001000"]))
	{
		$between5001000_filter = implode("','", $_POST["between5001000"]);
		$query .= "
		 AND price > 500 AND price < 1000
		";
	}
	if(isset($_POST["over1000"]))
	{
		$over1000_filter = implode("','", $_POST["over1000"]);
		$query .= "
		 AND price > 1000
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
		{	
			if(isAdmin())
			{
				if($row['quantity'] > 5)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=servers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="servers.php?category=computers&sub_category=servers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=computers&sub_category=servers&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] <= 5 && $row['quantity'] > 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=servers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="servers.php?category=computers&sub_category=servers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=computers&sub_category=servers&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] == 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=servers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
							<div> <a href="modify.php?category=computers&sub_category=servers&id='.$row['id'].'">Modify Product </a> </div>				
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=servers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="servers.php?category=computers&sub_category=servers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=servers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="servers.php?category=computers&sub_category=servers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=computers&sub_category=servers&id='.$row['id'].'">'.$row['title'].'</a></div>
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
	}
	echo $output;
}

if(isset($_POST["smartphones"]))
{
	$query = "
		SELECT * FROM smartphones WHERE category='smartphone'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["cpu"]))
	{
		$processor_filter = implode("','", $_POST["cpu"]);
		$query .= "
		 AND cpu IN('".$processor_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND storage IN('".$storage_filter."')
		";
	}
	if(isset($_POST["screen"]))
	{
		$screen_filter = implode("','", $_POST["screen"]);
		$query .= "
		 AND screen IN('".$screen_filter."')
		";
	}
	if(isset($_POST["os"]))
	{
		$os_filter = implode("','", $_POST["os"]);
		$query .= "
		 AND os IN('".$os_filter."')
		";
	}
	if(isset($_POST["under500"]))
	{
		$under500_filter = implode("','", $_POST["under500"]);
		$query .= "
		 AND price < 500
		";
	}
	if(isset($_POST["between5001000"]))
	{
		$between5001000_filter = implode("','", $_POST["between5001000"]);
		$query .= "
		 AND price > 500 AND price < 1000
		";
	}
	if(isset($_POST["over1000"]))
	{
		$over1000_filter = implode("','", $_POST["over1000"]);
		$query .= "
		 AND price > 1000
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
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
								<li class="ProductTags">• '.$row['cpu'].' </li>
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
								<a href="smartphones.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="smartphones.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<li class="ProductTags">• '.$row['cpu'].' </li>
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
								<li class="ProductTags">• '.$row['cpu'].' </li>
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
								<a href="smartphones.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="smartphones.php?category=smartphones&sub_category=smartphone&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<li class="ProductTags">• '.$row['cpu'].' </li>
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
	}
	echo $output;
}

if(isset($_POST["cases"]))
{
	$query = "
		SELECT * FROM smartphones WHERE category='case'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["under5"]))
	{
		$under5_filter = implode("','", $_POST["under5"]);
		$query .= "
		 AND price < 5
		";
	}
	if(isset($_POST["between510"]))
	{
		$between510_filter = implode("','", $_POST["between510"]);
		$query .= "
		 AND price > 5 AND price < 10
		";
	}
	if(isset($_POST["over10"]))
	{
		$over10_filter = implode("','", $_POST["over10"]);
		$query .= "
		 AND price > 10
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
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
								<a href="cases.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="cases.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="cases.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="cases.php?category=smartphones&sub_category=case&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
	}
	echo $output;
}

if(isset($_POST["accessories"]))
{
	$query = "
		SELECT * FROM smartphones WHERE category='accessory'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["under5"]))
	{
		$under5_filter = implode("','", $_POST["under5"]);
		$query .= "
		 AND price < 5
		";
	}
	if(isset($_POST["between510"]))
	{
		$between510_filter = implode("','", $_POST["between510"]);
		$query .= "
		 AND price > 5 AND price < 10
		";
	}
	if(isset($_POST["over10"]))
	{
		$over10_filter = implode("','", $_POST["over10"]);
		$query .= "
		 AND price > 10
		";
	}

	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
		{	
			if(isAdmin())
			{
				if($row['quantity'] > 5)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="accessories.php?category=smartphones&sub_category=accessory&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] <= 5 && $row['quantity'] > 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="accessories.php?category=smartphones&sub_category=accessory&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] == 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">'.$row['title'].'</a></div>
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
							<div> <a href="modify.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">Modify Product </a> </div>				
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="accessories.php?category=smartphones&sub_category=accessory&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="accessories.php?category=smartphones&sub_category=accessory&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=smartphones&sub_category=accessory&id='.$row['id'].'">'.$row['title'].'</a></div>
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
	}
	echo $output;
}

if(isset($_POST["speakers"]))
{
	$query = "
		SELECT * FROM sound WHERE category='speakers'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["power"]))
	{
		$power_filter = implode("','", $_POST["power"]);
		$query .= "
		 AND power IN('".$power_filter."')
		";
	}
	if(isset($_POST["type"]))
	{
		$type_filter = implode("','", $_POST["type"]);
		$query .= "
		 AND type IN('".$type_filter."')
		";
	}
	if(isset($_POST["under50"]))
	{
		$under50_filter = implode("','", $_POST["under50"]);
		$query .= "
		 AND price < 50
		";
	}
	if(isset($_POST["between50100"]))
	{
		$between50100_filter = implode("','", $_POST["between50100"]);
		$query .= "
		 AND price > 50 AND price < 100
		";
	}
	if(isset($_POST["over100"]))
	{
		$over100_filter = implode("','", $_POST["over100"]);
		$query .= "
		 AND price > 100
		";
	}
	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
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
								<a href="speakers.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="speakers.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="speakers.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="speakers.php?category=sound&sub_category=speakers&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
	}
	echo $output;
}

if(isset($_POST["amplifier"]))
{
	$query = "
		SELECT * FROM sound WHERE category='amplifier'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["power"]))
	{
		$power_filter = implode("','", $_POST["power"]);
		$query .= "
		 AND power IN('".$power_filter."')
		";
	}
	if(isset($_POST["type"]))
	{
		$type_filter = implode("','", $_POST["type"]);
		$query .= "
		 AND type IN('".$type_filter."')
		";
	}
	if(isset($_POST["under50"]))
	{
		$under50_filter = implode("','", $_POST["under50"]);
		$query .= "
		 AND price < 500
		";
	}
	if(isset($_POST["between50100"]))
	{
		$between50100_filter = implode("','", $_POST["between50100"]);
		$query .= "
		 AND price > 500 AND price < 1000
		";
	}
	if(isset($_POST["over100"]))
	{
		$over100_filter = implode("','", $_POST["over100"]);
		$query .= "
		 AND price > 1000
		";
	}
	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
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
								<a href="amplifiers.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="amplifiers.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="amplifiers.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
								<a href="amplifiers.php?category=sound&sub_category=amplifier&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
	}
	echo $output;
}

if(isset($_POST["headphones"]))
{
	$query = "
		SELECT * FROM sound WHERE category='headphones'
	";
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer IN('".$manufacturer_filter."')
		";
	}
	if(isset($_POST["power"]))
	{
		$power_filter = implode("','", $_POST["power"]);
		$query .= "
		 AND power IN('".$power_filter."')
		";
	}
	if(isset($_POST["type"]))
	{
		$type_filter = implode("','", $_POST["type"]);
		$query .= "
		 AND type IN('".$type_filter."')
		";
	}
	if(isset($_POST["under50"]))
	{
		$under50_filter = implode("','", $_POST["under50"]);
		$query .= "
		 AND price < 50
		";
	}
	if(isset($_POST["between50100"]))
	{
		$between50100_filter = implode("','", $_POST["between50100"]);
		$query .= "
		 AND price > 50 AND price < 100
		";
	}
	if(isset($_POST["over100"]))
	{
		$over100_filter = implode("','", $_POST["over100"]);
		$query .= "
		 AND price > 100
		";
	}
	$result = mysqli_query($db,$query);
	$output = '';
	if ($result -> num_rows == 0)
	{
		$output = '<b><font size="6"> <font color="red">No products were found with the above filters!</font></b>';
	}
	else
	{
		foreach($result as $row)
		{	
			if(isAdmin())
			{
				if($row['quantity'] > 5)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=headphones&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="headphones.php?category=sound&sub_category=headphones&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=sound&sub_category=headphones&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] <= 5 && $row['quantity'] > 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=headphones&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="headphones.php?category=sound&sub_category=headphones&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
							</div>
							<div> <a href="modify.php?category=sound&sub_category=headphones&id='.$row['id'].'">Modify Product </a> </div>				
						</div>
						
					</div>';
				}
				if($row['quantity'] == 0)
				{
					$output .=
						#<div class="ProductImage"> <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" /></div>
					'<div class="Product" id='.$row['id'].'> 
						
						<div class="ProductImage"> <a href="'.$row['url'].'"> <img src="'.$row['image'].'"/> </a></div>
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=headphones&id='.$row['id'].'">'.$row['title'].'</a></div>
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
							<div> <a href="modify.php?category=sound&sub_category=headphones&id='.$row['id'].'">Modify Product </a> </div>				
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=headphones&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="headphones.php?category=sound&sub_category=headphones&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=headphones&id='.$row['id'].'">'.$row['title'].'</a></div>
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
								<a href="headphones.php?category=sound&sub_category=headphones&id='.$row['id'].'&AddToCart=true"><img src="Images/AddToCart.jpeg"></a>
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
						<div class="ProductName"> <a class="LinkFix" href="product.php?category=sound&sub_category=headphones&id='.$row['id'].'">'.$row['title'].'</a></div>
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
	}
	echo $output;
}
?>