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
	<!--<?php #if (isAdmin()) : ?>
		<strong>WELCOME ADMIN!!!!!!</strong><br>
		<a href="admin_register.php"> ADMIN REGISTER</a>
	<?php #elseif (isLoggedin()) : ?>
		welcome user!
	<?php #endif ?>
	-->
	
	<div> 
		<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'desktops.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM computers WHERE category = 'Desktops'");
					while($row = mysqli_fetch_array($result))
					{
						echo $row['category']."<br>";
					}
				?>
			</button>
		</div>
		<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'all_in_one_desktops.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM computers WHERE category = 'aiod'");
					while($row = mysqli_fetch_array($result))
					{
						if($row['category'] == 'aiod')
						{
							echo 'All in one desktops';
						}
					}
				?>
				<br>
			</button>
		</div>
		<div>
			<button type="button" class="sub_categories" onclick="window.location.href = 'laptops.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM computers WHERE category = 'Laptops'");
					while($row = mysqli_fetch_array($result))
					{
						echo $row['category']."<br>";
					}
				?>
			</button>
		</div>
		<div> 
			<button type="button" class="sub_categories" onclick="window.location.href = 'tablets.php';">
				<?php   
					$result = mysqli_query($db,"SELECT DISTINCT category FROM computers WHERE category = 'Tablets'");
					while($row = mysqli_fetch_array($result))
					{
						echo $row['category']."<br>";
					}
				?>
			</button>
		</div>
	</div>
</div>

<div class="FilterLayout">
	<div class="FiltersLeft">
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Manufacturer: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(manufacturer) FROM computers WHERE category = 'aiod' AND manufacturer !=''");
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
				<li class="FilterText">Processor: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(cpu) FROM computers WHERE category = 'aiod' AND cpu !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector cpu" value="<?php echo $row['cpu']; ?>"  > <?php echo $row['cpu']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
		<br>
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">RAM: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(ram) FROM computers WHERE category = 'aiod' AND ram !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector ram" value="<?php echo $row['ram']; ?>"  > <?php echo $row['ram']; ?> GB </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
		<br>
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Storage: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(storage) FROM computers WHERE category = 'aiod' AND storage !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector storage" value="<?php echo $row['storage']; ?>"  > <?php echo $row['storage']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
		<br>
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">GPU: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(gpu) FROM computers WHERE category = 'aiod' AND gpu !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector gpu" value="<?php echo $row['gpu']; ?>"  > <?php echo $row['gpu']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
	</div>
	<div class="FiltersRight">
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Screen: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(screen) FROM computers WHERE category = 'aiod' AND screen !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector screen" value="<?php echo $row['screen']; ?>"  > <?php echo $row['screen']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
		<br>
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">OS: </li>
				<?php
					$result = mysqli_query($db,"SELECT DISTINCT(os) FROM computers WHERE category = 'aiod' AND os !=''");
                    foreach($result as $row)
                    {
                    ?>
                        <label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector os" value="<?php echo $row['os']; ?>"  > <?php echo $row['os']; ?> </li></label>
                    <?php
                    }
                ?>
			</ul>
		</div>
		<br>
		<div>
			<ul class="FilterOrder">
				<li class="FilterText">Price: </li>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector under500" value="under500"> Under 500€</li></label>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector between5001000" value="between5001000"> 500€ - 1000€</li></label>
				<label> <li class="Filter"> <input type="checkbox" onclick="change_color(this);" class="common_selector over1000" value="over1000"> Over 1000€</li></label>
			</ul>
		</div>
	</div>
</div>
<div class="ProductDisplay">
	
</div>
<div class="sales">  </div>

<script>

$(document).ready(function(){

    ProductDisplay();

    function ProductDisplay()
    {
        $('.ProductDisplay').html('');
        var aiod = 'fetch_data';
        var manufacturer = get_filter('manufacturer');
				var cpu = get_filter('cpu');
				var ram = get_filter('ram');
				var storage = get_filter('storage');
				var gpu = get_filter('gpu');
				var screen = get_filter('screen');
				var os = get_filter('os');
				var under500 = get_filter('under500');
				var between5001000 = get_filter('between5001000');
				var over1000 = get_filter('over1000');
		
        $.ajax({
            url:"filters.php",
            method:"POST",
            data:{aiod:aiod, manufacturer:manufacturer, cpu:cpu, ram:ram, storage:storage, gpu:gpu, screen:screen, os:os, under500:under500, between5001000:between5001000, over1000:over1000},
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