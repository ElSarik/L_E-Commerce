<?php

session_start();

$db = mysqli_connect('localhost', 'root', '', 'my_shop');

$username = "";
$email = "";
$errors = array();

$flag = 0;

if (isset($_POST['register_btn']))
{
	register();
}

if (isset($_POST['AdminRegister_btn']))
{
	AdminRegister();
}

if (isset($_POST['login_btn']))
{
	login();
}

if (isset($_POST['AddProduct_btn']))
{
	AddProduct();
}

if (isset($_POST['ModidfyProduct_btn']))
{
	ModifyProduct();
}

if (isset($_POST['Remove_btn']))
{
	RemoveProduct();
}

if (isset($_GET['logout'])) 
{
	session_destroy();
	unset($_SESSION['user']);
	unset($_SESSION['user_id']);
	header("location: index.php");
}

function register()
{
	
	global $db, $errors, $username, $email;
	
	$username   = e($_POST['username']);
	$email 	    = e($_POST['email']);
	$password_1 = e($_POST['password_1']);
	$password_2 = e($_POST['password_2']);
	$name		= e($_POST['name']);
	$surname	= e($_POST['surname']);
	$telephone	= e($_POST['telephone']);
	$address	= e($_POST['address']);
	
	if (empty($username))
	{
		array_push($errors, "Username is required");
	}
	if (empty($email))
	{
		array_push($errors, "Email is required");
	}
	if (empty($password_1))
	{
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2)
	{
		array_push($errors, "The two passwords do not match");
	}
	
	if (count($errors) == 0)
	{
		$password = md5($password_1);
	
		$query = "INSERT INTO client (username, email, name, surname, telephone, address, password) 
				  VALUES('$username', '$email', '$name', '$surname', '$telephone', '$address', '$password')";
		mysqli_query($db, $query);
		header('location: login.php?msg');
		#array_push($errors, "REGISTRATION SUCCESSFUL, YOU MAY NOW LOGIN");		

		// get id of the created user
		#$logged_in_user_id = mysqli_insert_id($db);

		#$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
		#$_SESSION['success']  = "You are now logged in";
		#header('location: index.php');				
		
	}
}

function AdminRegister()
{
	
	global $db, $errors, $username, $email;
	
	$username   = e($_POST['username']);
	$email 	    = e($_POST['email']);
	$password_1 = e($_POST['password_1']);
	$password_2 = e($_POST['password_2']);
	$name		= e($_POST['name']);
	$surname	= e($_POST['surname']);
	$telephone	= e($_POST['telephone']);
	
	if (empty($username))
	{
		array_push($errors, "Username is required");
	}
	if (empty($email))
	{
		array_push($errors, "Email is required");
	}
	if (empty($password_1))
	{
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2)
	{
		array_push($errors, "The two passwords do not match");
	}
	
	if (count($errors) == 0)
	{
		$password = md5($password_1);
	
		$query = "INSERT INTO admin (username, email, name, surname, telephone, password) 
				  VALUES('$username', '$email', '$name', '$surname', '$telephone', '$password')";
		mysqli_query($db, $query);
		header('location: login.php?msg');

		// get id of the created user
		#$logged_in_user_id = mysqli_insert_id($db);

		#$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
		#$_SESSION['success']  = "You are now logged in";
		#header('location: index.php');				
		
	}
}

#function getUserById($id){
#	global $db;
#	$query = "SELECT * FROM client WHERE id=" . $id;
#	$result = mysqli_query($db, $query);

#	$user = mysqli_fetch_assoc($result);
#	return $user;
#}

function login()
{
	
	global $db, $username, $errors;
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if (empty($username))
	{
		array_push($errors, "Username is required");
	}
	if (empty($password))
	{
		array_push($errors, "Password is required");
	}
	
	if (count($errors) == 0)
	{
	
		$password = md5($password);
	
		$login_status = 0;
	
		$result = mysqli_query($db,"SELECT id, username, password, flag FROM client UNION SELECT id, username , password, flag FROM admin")
			or die("Failed to reach database ".mysqli_error($db));
		
		while($row = mysqli_fetch_assoc($result))
		{
			$logged_in_user = $row;
		
			if ($row['username'] == $username && $row['password'] == $password && $logged_in_user ['flag'] == 1)
			{
				session_start();
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}
			if ($row['username'] == $username && $row['password'] == $password && $logged_in_user ['flag'] == 0)
			{
				session_start();
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}
		}
		array_push($errors, "Wrong username/password combination");
	}
}

function sub_computers() #ALAKSE TO
{
	global $db;
	#$i = 0;
	$computers_categories = array();
	
	$result = mysqli_query($db,"SELECT DISTINCT category FROM computers");
	while($row = mysqli_fetch_array($result))
	{
		echo $row['category']."<br>";
	}
}

function InsertIntoCart($category, $sub_category, $id)
{
	global $db;
	
	$query = "SELECT * FROM $category WHERE category='$sub_category' AND id='$id'";
		
	$result = mysqli_query($db,$query);
	$row = mysqli_fetch_assoc($result);
	$main_category = $category;
	$category = $row['category'];
	$title = $row['title'];
	$code = $row['id'];
	$price = $row ['price'];
	$image = $row ['image'];
	$StockQuantity = $row ['quantity'];
	
	
	
	 $user_id = GetUserID();
	
	 $query = "SELECT * FROM client WHERE id ='$user_id'";

	 $result = mysqli_query($db, $query);
	 $client = mysqli_fetch_assoc($result);
	 $address = $client['address'];
	 $name = $client['name'];
	 $surname = $client['surname'];
	 
	 $query = "SELECT DISTINCT status FROM orders WHERE client_id ='$user_id'";
	 $result = mysqli_query($db, $query);
	 
	 //if ($result != "")
	 //{
		  foreach($result as $order)
		{	
			echo print_r($order);
			$flag = "deny";
			if($order['status'] != "Open" || $order == "") //received sent completed open
			{
				$flag = "allow";
			}			 
		}
	 //}
	 //else
	 //{
		 $flag = "allow";
	 //}
	 foreach($result as $order)
	 {
		 $flag = "deny";
		 if($order['status'] != "Open" || $order == "") //received sent completed open
		 {
			 $flag = "allow";
		 }			 
	 }
	 
	 if($flag == "allow")
	 {
		 $query = "INSERT INTO orders (client_id, status, address, name, surname)
				 VALUES('".$user_id."', 'Open', '".$address."', '".$name."', '".$surname."')";
		$result = mysqli_query($db, $query);
	
		$query = "SELECT * FROM orders WHERE client_id ='$user_id' AND status ='Open'";
		
		$result = mysqli_query($db, $query);
	 
		foreach($result as $order)
		{
			$order_id = $order['id'];
		 
		}
	
		$query = "INSERT INTO item (order_id, main_category, category, item_id, quantity)
			 VALUES('".$order_id."', '".$main_category."', '".$category."', '".$code."', '1')";
			
		echo $query;
	
		$result = mysqli_query($db, $query);
	
	 }
	 if($flag == "deny")
	 {
		 $query = "SELECT * FROM orders WHERE client_id ='$user_id' AND status ='Open'";
		 
		 $result = mysqli_query($db, $query);
	 
		foreach($result as $order)
		{
			$order_id = $order['id'];
		 
		}
		
		$query = "SELECT * FROM item WHERE order_id ='$order_id'";
		$result = mysqli_query($db, $query);
		echo $code;
		$item_exists = false;
		foreach($result as $item)
		{
			if ($item['item_id'] == $code)
			{
				$item_exists = true;
			}
		}
		
		if($item_exists == false)
		{
			$query = "INSERT INTO item (order_id, main_category, category, item_id, quantity)
			 VALUES('".$order_id."', '".$main_category."', '".$category."', '".$code."', '1')";
			 $result = mysqli_query($db, $query);
		}
		else
		{
			
		}
	}
	 
	
/*	
	
	$cart = array
	(
		$code=>array
		(
			'main_category'=>$main_category,
			'category'=>$category,
			'title'=>$title,
			 'code'=>$code,
			 'price'=>$price,
			 'quantity'=>1,
			 'image'=>$image,
			 'StockQuantity'=>$StockQuantity
		 )
	 );


	 if(empty($_SESSION["shopping_cart"])) 
	 {
		 $_SESSION["shopping_cart"] = $cart;
		 $status = "Product is added to your cart!";
	 }
	 else
	 {
		 $array_keys = array_keys($_SESSION["shopping_cart"]);
		 if(in_array($code,$array_keys))
		 {
			 $status = "Product is already added to your cart!";	
		 } 
		 else 
		 {
		 $_SESSION["shopping_cart"] = $_SESSION["shopping_cart"] + $cart;
		 $status = "Product is added to your cart!";
		 }

	 }
	
	//print_r($_SESSION["shopping_cart"]); //DEBUG
	echo $status;
	//	unset($_SESSION["shopping_cart"]); //DEBUG
	
*/	
}


function AddProduct()
{
	global $db;
	
	$Main_Category   = e($_POST['Main_Category']);
	
	if($Main_Category == "computers")
	{
		$category = e($_POST['category']);
		$manufacturer = e($_POST['manufacturer']);
		$title = e($_POST['title']);
		$cpu = e($_POST['cpu']);
		$ram = e($_POST['ram']);
		$storage = e($_POST['storage']);
		$gpu = e($_POST['gpu']);
		$screen = e($_POST['screen']);
		$os = e($_POST['os']);
		$price = e($_POST['price']);
		$quantity = e($_POST['quantity']);
		$description = e($_POST['description']);
		$url = e($_POST['url']);
		$image = $_FILES['image'];

		$file_get = $_FILES['image']['name'];
		$temp = $_FILES['image']['tmp_name'];

		$file_to_saved = "Images/Products/".$file_get;
		move_uploaded_file($temp, $file_to_saved);

		$query = "INSERT INTO computers (category, manufacturer, title, cpu, ram, storage, gpu, screen, os, price, quantity, description, url, image) 
				  VALUES('".$category."', '".$manufacturer."', '".$title."', '".$cpu."', '".$ram."', '".$storage."', '".$gpu."', '".$screen."', '".$os."', '".$price."', '".$quantity."', '".$description."', '".$url."', '".$file_to_saved."')";
		mysqli_query($db, $query);
		
	}
	
	if($Main_Category == "smartphones")
	{
		$category = e($_POST['category']);
		$manufacturer = e($_POST['manufacturer']);
		$title = e($_POST['title']);
		$cpu = e($_POST['cpu']);
		$ram = e($_POST['ram']);
		$storage = e($_POST['storage']);
		$screen = e($_POST['screen']);
		$os = e($_POST['os']);
		$price = e($_POST['price']);
		$quantity = e($_POST['quantity']);
		$description = e($_POST['description']);
		$url = e($_POST['url']);
		$image = $_FILES['image'];

		$file_get = $_FILES['image']['name'];
		$temp = $_FILES['image']['tmp_name'];

		$file_to_saved = "Images/Products/".$file_get;
		move_uploaded_file($temp, $file_to_saved);

		$query = "INSERT INTO smartphones (category, manufacturer, title, cpu, ram, storage, screen, os, price, quantity, description, url, image) 
				  VALUES('".$category."', '".$manufacturer."', '".$title."', '".$cpu."', '".$ram."', '".$storage."', '".$screen."', '".$os."', '".$price."', '".$quantity."', '".$description."', '".$url."', '".$file_to_saved."')";
		mysqli_query($db, $query);
		
	}
	
	if($Main_Category == "sound")
	{
		$category = e($_POST['category']);
		$manufacturer = e($_POST['manufacturer']);
		$title = e($_POST['title']);
		$power = e($_POST['power']);
		$type = e($_POST['type']);
		$price = e($_POST['price']);
		$quantity = e($_POST['quantity']);
		$description = e($_POST['description']);
		$url = e($_POST['url']);
		$image = $_FILES['image'];

		$file_get = $_FILES['image']['name'];
		$temp = $_FILES['image']['tmp_name'];

		$file_to_saved = "Images/Products/".$file_get;
		move_uploaded_file($temp, $file_to_saved);

		$query = "INSERT INTO sound (category, manufacturer, title, power, type, price, quantity, description, url, image) 
				  VALUES('".$category."', '".$manufacturer."', '".$title."', '".$power."', '".$type."', '".$price."', '".$quantity."', '".$description."', '".$url."', '".$file_to_saved."')";
		mysqli_query($db, $query);
		
	}
}

function ModifyProduct()
{
	global $db;
	
	$Main_Category   = e($_POST['Main_Category']);
	$id = e($_POST['id']);
	
	if($Main_Category == "computers")
	{
		$manufacturer = e($_POST['manufacturer']);
		$title = e($_POST['title']);
		$cpu = e($_POST['cpu']);
		$ram = e($_POST['ram']);
		$storage = e($_POST['storage']);
		$gpu = e($_POST['gpu']);
		$screen = e($_POST['screen']);
		$os = e($_POST['os']);
		$price = e($_POST['price']);
		$quantity = e($_POST['quantity']);
		$description = e($_POST['description']);
		$url = e($_POST['url']);
		$image = $_FILES['image'];

		$file_get = $_FILES['image']['name'];
		$temp = $_FILES['image']['tmp_name'];

		$file_to_saved = "Images/Products/".$file_get;
		move_uploaded_file($temp, $file_to_saved);

		if($file_get == '')
		{
			$query = "UPDATE ".$Main_Category."
				SET manufacturer ='".$manufacturer."', title ='".$title."', cpu='".$cpu."', ram ='".$ram."', storage ='".$storage."', gpu ='".$gpu."', screen ='".$screen."', os ='".$os."', price ='".$price."', quantity ='".$quantity."', description ='".$description."', url ='".$url."'
				WHERE id ='".$id."'";
		}
		else
		{
			$query = "UPDATE ".$Main_Category."
				SET manufacturer ='".$manufacturer."', title ='".$title."', cpu='".$cpu."', ram ='".$ram."', storage ='".$storage."', gpu ='".$gpu."', screen ='".$screen."', os ='".$os."', price ='".$price."', quantity ='".$quantity."', description ='".$description."', image ='".$file_to_saved."', url ='".$url."'
				WHERE id ='".$id."'";
		}		
		mysqli_query($db, $query);
	}
	elseif($Main_Category == "smartphones")
	{
		$manufacturer = e($_POST['manufacturer']);
		$title = e($_POST['title']);
		$cpu = e($_POST['cpu']);
		$ram = e($_POST['ram']);
		$storage = e($_POST['storage']);
		$screen = e($_POST['screen']);
		$os = e($_POST['os']);
		$price = e($_POST['price']);
		$quantity = e($_POST['quantity']);
		$description = e($_POST['description']);
		$url = e($_POST['url']);
		$image = $_FILES['image'];

		$file_get = $_FILES['image']['name'];
		$temp = $_FILES['image']['tmp_name'];

		$file_to_saved = "Images/Products/".$file_get;
		move_uploaded_file($temp, $file_to_saved);

		if($file_get == '')
		{
			$query = "UPDATE ".$Main_Category."
				SET manufacturer ='".$manufacturer."', title ='".$title."', cpu='".$cpu."', ram ='".$ram."', storage ='".$storage."', screen ='".$screen."', os ='".$os."', price ='".$price."', quantity ='".$quantity."', description ='".$description."', url ='".$url."'
				WHERE id ='".$id."'";
		}
		else
		{
			$query = "UPDATE ".$Main_Category."
				SET manufacturer ='".$manufacturer."', title ='".$title."', cpu='".$cpu."', ram ='".$ram."', storage ='".$storage."', screen ='".$screen."', os ='".$os."', price ='".$price."', quantity ='".$quantity."', description ='".$description."', image ='".$file_to_saved."', url ='".$url."'
				WHERE id ='".$id."'";
		}		
		mysqli_query($db, $query);
	}
	elseif($Main_Category == "sound")
	{
		$manufacturer = e($_POST['manufacturer']);
		$title = e($_POST['title']);
		$power = e($_POST['power']);
		$type = e($_POST['type']);
		$price = e($_POST['price']);
		$quantity = e($_POST['quantity']);
		$description = e($_POST['description']);
		$url = e($_POST['url']);
		$image = $_FILES['image'];

		$file_get = $_FILES['image']['name'];
		$temp = $_FILES['image']['tmp_name'];

		$file_to_saved = "Images/Products/".$file_get;
		move_uploaded_file($temp, $file_to_saved);

		if($file_get == '')
		{
			$query = "UPDATE ".$Main_Category."
				SET manufacturer ='".$manufacturer."', title ='".$title."', power='".$power."', type ='".$type."', price ='".$price."', quantity ='".$quantity."', description ='".$description."', url ='".$url."'
				WHERE id ='".$id."'";
		}
		else
		{
			$query = "UPDATE ".$Main_Category."
				SET manufacturer ='".$manufacturer."', title ='".$title."', power='".$power."', type ='".$type."', price ='".$price."', quantity ='".$quantity."', description ='".$description."', image ='".$file_to_saved."', url ='".$url."'
				WHERE id ='".$id."'";
		}		
		mysqli_query($db, $query);
	}
}

function RemoveProduct()
{	
	global $db;
	
	$Main_Category   = e($_POST['Main_Category']);
	$id = e($_POST['id']);
	
	$query = "DELETE FROM ".$Main_Category."
			WHERE id ='".$id."'";
			
	mysqli_query($db, $query);
	
	header('location: index.php');
}


function e($val)
{
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error()
{
	global $errors;
	
	if (count($errors) > 0)
	{
		echo '<div class="error">';
			foreach ($errors as $error)
			{
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user']))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['flag'] == 1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function GetUserID()
{
	if (isset($_SESSION['user_id']))
	{
		return $_SESSION['user_id'];
	}
}

?>