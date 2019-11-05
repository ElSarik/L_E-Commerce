<?php include('functions.php') ?>

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
	<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'smartphones.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM smartphones WHERE category = 'Smartphone'");
					while($row = mysqli_fetch_array($result))
					{
						if($row['category'] == 'Smartphone')
						{
							echo 'Smartphones';
						}
					}
				?>
			</button>
	</div>
	<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'cases.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM smartphones WHERE category = 'Case'");
					while($row = mysqli_fetch_array($result))
					{
						if($row['category'] == 'Case')
						{
							echo 'Cases';
						}
					}
				?>
			</button>
	</div>
	<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'accessories.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM smartphones WHERE category = 'Accessory'");
					while($row = mysqli_fetch_array($result))
					{
						if($row['category'] == 'Accessory')
						{
							echo 'Accessories';
						}
					}
				?>
			</button>
	</div>
</div>

<div class="FilterLayout">
	<div class="FiltersLeft">
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Manufacturer: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(manufacturer) FROM smartphones WHERE category = 'accessory' AND manufacturer !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector manufacturer" value="<?php echo $row['manufacturer']; ?>"  > <?php echo $row['manufacturer']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
	</div>
	<div class="FiltersRight">
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Price: </li>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector under5" value="under500"> Under 5€</li></label>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector between510" value="between5001000"> 5€ - 10€</li></label>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector over10" value="over1000"> Over 10€</li></label>
			</ul>
		</div>
	</div>
</div>
<div class="ProductDisplay">
	
</div>
<div class="sales"> </div>

<script>

$(document).ready(function(){

    ProductDisplay();

    function ProductDisplay()
    {
        $('.ProductDisplay').html('');
        var accessories = 'fetch_data';
        var manufacturer = get_filter('manufacturer');
				var under5 = get_filter('under5');
				var between510 = get_filter('between510');
				var over10 = get_filter('over10');
		
        $.ajax({
            url:"filters.php",
            method:"POST",
            data:{accessories:accessories, manufacturer:manufacturer, under5:under5, between510:between510, over10:over10},
            success:function(data){
                $('.ProductDisplay').html(data);
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        ProductDisplay();
    });
});

function change_color(cb)
{
	cb.parentNode.style.backgroundColor = cb.checked ? 'red' : '';
}

</script>

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