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

<div class="FilterLayout">
	<div class="FiltersLeft">
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Manufacturer: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(manufacturer) FROM sound WHERE category = 'speakers' AND manufacturer !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector manufacturer" value="<?php echo $row['manufacturer']; ?>"  > <?php echo $row['manufacturer']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
		<br>
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Power: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(power) FROM sound WHERE category = 'speakers' AND power !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector power" value="<?php echo $row['power']; ?>"  > <?php echo $row['power']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
		<br>
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Type: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(type) FROM sound WHERE category = 'speakers' AND type !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector type" value="<?php echo $row['type']; ?>"  > <?php echo $row['type']; ?> </li></label>
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
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector under50" value="under50"> Under 50€</li></label>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector between50100" value="between50100"> 50€ - 100€</li></label>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector over100" value="over100"> Over 100€</li></label>
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
        var speakers = 'fetch_data';
        var manufacturer = get_filter('manufacturer');
		var power = get_filter('power');
		var type = get_filter('type');
				var under50 = get_filter('under50');
				var between50100 = get_filter('between50100');
				var over100 = get_filter('over100');
		
        $.ajax({
            url:"filters.php",
            method:"POST",
            data:{speakers:speakers, manufacturer:manufacturer, power:power, type:type, under50:under50, between50100:between50100, over100:over100},
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