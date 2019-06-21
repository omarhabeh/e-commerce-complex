<?php  
session_start();
$servername = "ec2-79-125-2-142.eu-west-1.compute.amazonaws.com:5432";
$username = "ixpbvdzakdhcrm";
$password = "5bd7efa38326e79f34cd08ffca8bdf5ac17f7dd5c0ea5670b144873ef4ca2dfd";
$db = "d6kg1bsc34mrv4"; 
$conn = pg_connect($servername, $username, $password , $db);
$query="SELECT * FROM PRODUCTS";
$res=pg_query($conn,$query);
if(empty($res)) {
	$query = "CREATE TABLE PRODUCTS (
		prodID int(11) AUTO_INCREMENT,
		prodPic LONGBLOB,
		prodname varchar(255),
		gender varchar(255),
		price varchar(255),
		PRIMARY KEY  (prodID)
		)";
	$res = pg_query($conn, $query);
}

$query="SELECT * FROM cart";
$res=pg_query($conn,$query);
if(empty($res)) {
	$query = "CREATE TABLE cart (
		id int(11) AUTO_INCREMENT,
		CartId int(11) ,
		userId int(11) ,
		PRIMARY KEY  (id) )";
	$res = pg_query($conn, $query);
}
if(isset($_GET['id'])){
	if(isset($_SESSION['fname'])){
	$userId=$_SESSION['id'];
	$id=$_GET['id'];
	$query="insert into cart(id,CartId,userId) value (0,$id,$userId)" ;
	$res=pg_query($conn,$query);
	$query="SELECT * FROM cart where userId=$userId ";
$res=pg_query($conn,$query);
	$s= pg_num_rows($res);
	$_SESSION['s']=$s;
}
else {
	echo "<script> alert ('sign in to add to cart ') ;</script>";
}
}
if (isset($_POST['submity'])){
	$file=addslashes(file_get_contents($_FILES['pic']['tmp_name']));
	$prodname = $_POST['nameofprod'];
	$gender=$_POST['gender'];
	$price = $_POST['price'];
	$query="INSERT INTO PRODUCTS(prodPic,prodname,gender,price) value ('$file','$prodname','$gender','$price')";
	pg_query($conn,$query);
}

if(isset($_SESSION['prl'])&&$_SESSION['prl']==2){
	$_SESSION['admin']="admin";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>EasyBuyin</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="EasyBuyin template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>

</head>
<body>

<!-- Menu -->



<div class="menu">
	<!-- Search -->
	<div class="menu_search">
		<form action="#" id="menu_search_form" class="menu_search_form">
			<input type="text" class="search_input" placeholder="Search Item" required="required">
			<button class="menu_search_button"><img src="images/search.png" alt=""></button>
		</form>
	</div>
	<!-- Navigation -->
	<div class="menu_nav">
		<ul>
			<li><a href="#">Women</a></li>
			<li><a href="#">Men</a></li>
			<li><a href="#">Kids</a></li>
			<li><a href="#">Home Deco</a></li>
			<li><a href="#">Contact</a></li>
		</ul>
	</div>
	<!-- Contact Info -->
	<div class="menu_contact">
		<div class="menu_phone d-flex flex-row align-items-center justify-content-start">
			<div><div><img src="images/phone.svg" ></div></div>
			<div>+1 912-252-7350</div>
		</div>
		<div class="menu_social">
			<ul class="menu_social_list d-flex flex-row align-items-start justify-content-start">
				<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</div>
</div>

<div class="super_container">

	<!-- Header -->

	<header class="header">
		<div class="header_overlay"></div>
		<div class="header_content d-flex flex-row align-items-center justify-content-start">
			<div class="logo">
				<a href="#">
					<div class="d-flex flex-row align-items-center justify-content-start">
						<div><img src="images/logo_1.png" alt=""></div>
						<div>EasyBuyin</div>
					</div>
				</a>	
			</div>
			<div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
			<nav class="main_nav">
				<ul class="d-flex flex-row align-items-start justify-content-start">
					<li class="active"><a href="#">Women</a></li>
					<li><a href="#">Men</a></li>
					<li><a href="#">Kids</a></li>
					<li><a href="#">Home Deco</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</nav>
			<div class="header_right d-flex flex-row align-items-center justify-content-start ml-auto">
				<!-- Search -->
<?php if(isset($_SESSION['admin'])){?>
<div class="dropdown">
  <button type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown">
    Add A Product 
  </button>
  <div class="dropdown-menu">
	  <form method="post" enctype='multipart/form-data'>
	<input type=file placeholder='pic' name="pic" accept="image/*" required>
	<input type ="text" placeholder="name of prod " name="nameofprod" required>
	<select placeholer="for whom" name="gender" required>
	<option>boys</option>
	<option>girls</option>
	<option>baby</option>
	<option>home decore</option>
</select>
	<input type ="text" name="price" placeholder="price" required>
	<br>
	<input type="submit"  class="btn " name="submity">
</form>
  </div>
</div>
<?php }?>
				<div class="header_search">
					<form action="#" id="header_search_form">
						<input type="text" class="search_input" placeholder="Search Item" required="required">
						<button class="header_search_button"><img src="images/search.png" alt=""></button>
					</form>
				</div>
<?php  if (!empty($_SESSION['fname'])){
				echo ' '.strtoupper($_SESSION['fname']).'
				<div  style="display: none;" id="asda"; > 
				<ul class="showin"style="padding:20px; "><li><a href="signup.php">Profile</a></li><li><a href="tst.php" id="sessionout"> Sign out</a></li></ul>
				</div>
				';}?>
<?php  if (empty($_SESSION['fname'])){  
				echo '<div  style="display: none;" id="asda";>
				<ul class="showin"style="padding:20px; "><li><a href="signup.php">Sign up</a></li><li><a href="signin.php">Sign in</a></li></ul>
				</div>
				';}?>
				<div class="user" id="as"><a href="#"><div><img src="images/user.svg" ></div></a></div>
				
				<!-- Cart -->
				<div class="cart"><a href="cart.php"><div><img class="svg" src="images/cart.svg" ><div><?php if(!empty($s)){echo $s;}?></div></div></a></div>
				
				
				<!-- Phone -->
				<div class="header_phone d-flex flex-row align-items-center justify-content-start">
					<div><div><img src="images/phone.svg" ></div></div>
					<div>+1 912-252-7350</div>
				</div>
			</div>
		</div>
	</header>

	<div class="super_container_inner">
		<div class="super_overlay"></div>

		<!-- Home -->

		<div class="home">
			<!-- Home Slider -->
			<div class="home_slider_container">
				<div class="owl-carousel owl-theme home_slider">
					
					<!-- Slide -->
					<div class="owl-item">
						<div class="background_image" style="background-image:url(images/home_3.jpg)"></div>
						<div class="container fill_height">
							<div class="row fill_height">
								<div class="col fill_height">
									<div class="home_container d-flex flex-column align-items-center justify-content-start">
										<div class="home_content">
											<div class="home_title">New Arrivals</div>
											<div class="home_subtitle">Summer Wear</div>
											<div class="home_items">
												<div class="row">
													<div class="col-sm-3 offset-lg-1">
														<div class="home_item_side"><a href="product.php"><img src="images/home_1.jpg" alt=""></a></div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-8 offset-sm-2 offset-md-0">
														<div class="product home_item_large">
															<div class="product_tag d-flex flex-column align-items-center justify-content-center">
																<div>
																	<div>from</div>
																	<div>$3<span>.99</span></div>
																</div>
															</div>
															<div class="product_image"><img src="images/home_3.jpg" alt=""></div>
															<div class="product_content">
																<div class="product_info d-flex flex-row align-items-start justify-content-start">
																	<div>
																		<div>
																			<div class="product_name"><a href="product.php">Cool Clothing with Brown Stripes</a></div>
																			<div class="product_category">In <a href="category.php">Category</a></div>
																		</div>
																	</div>
																	<div class="ml-auto text-right">
																		<div class="rating_r rating_r_4 home_item_rating"><i></i><i></i><i></i><i></i><i></i></div>
																		<div class="product_price text-right">$5<span>.99</span></div>
																	</div>
																</div>
																<div class="product_buttons">
																	<div class="text-right d-flex flex-row align-items-start justify-content-start">
																		<div class="product_button product_fav text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/heart.svg" alt=""><div>+</div></div></div>
																		</div>
																		<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/cart_2.svg" alt=""><div>+</div></div></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="home_item_side"><a href="product.php"><img src="images/product_1.jpg" alt=""></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>

					<!-- Slide -->
					<div class="owl-item">
						<div class="background_image" style="background-image:url(images/product_1.jpg)"></div>
						<div class="container fill_height">
							<div class="row fill_height">
								<div class="col fill_height">
									<div class="home_container d-flex flex-column align-items-center justify-content-start">
										<div class="home_content">
											<div class="home_title">Popular</div>
											<div class="home_subtitle">Summer Wear</div>
											<div class="home_items">
												<div class="row">
													<div class="col-sm-3 offset-lg-1">
														<div class="home_item_side"><a href="product.php"><img src="images/home_3.jpg" alt=""></a></div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-8 offset-sm-2 offset-md-0">
														<div class="product home_item_large">
															<div class="product_tag d-flex flex-column align-items-center justify-content-center">
																<div>
																	<div>from</div>
																	<div>$7<span>.99</span></div>
																</div>
															</div>
															<div class="product_image"><img src="images/product_1.jpg" alt=""></div>
															<div class="product_content">
																<div class="product_info d-flex flex-row align-items-start justify-content-start">
																	<div>
																		<div>
																			<div class="product_name"><a href="product.php">Cool Clothing with Brown Stripes</a></div>
																			<div class="product_category">In <a href="category.php">Category</a></div>
																		</div>
																	</div>
																	<div class="ml-auto text-right">
																		<div class="rating_r rating_r_4 home_item_rating"><i></i><i></i><i></i><i></i><i></i></div>
																		<div class="product_price text-right">$7<span>.99</span></div>
																	</div>
																</div>
																<div class="product_buttons">
																	<div class="text-right d-flex flex-row align-items-start justify-content-start">
																		<div class="product_button product_fav text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/heart.svg" alt=""><div>+</div></div></div>
																		</div>
																		<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/cart_2.svg" alt=""><div>+</div></div></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="home_item_side"><a href="product.php"><img src="images/product_3.jpg" alt=""></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>

					<!-- Slide -->
					<div class="owl-item">
						<div class="background_image" style="background-image:url(images/product_3.jpg)"></div>
						<div class="container fill_height">
							<div class="row fill_height">
								<div class="col fill_height">
									<div class="home_container d-flex flex-column align-items-center justify-content-start">
										<div class="home_content">
											<div class="home_title">Trendsetters</div>
											<div class="home_subtitle">Summer Wear</div>
											<div class="home_items">
												<div class="row">
													<div class="col-sm-3 offset-lg-1">
														<div class="home_item_side"><a href="product.php"><img src="images/product_1.jpg" alt=""></a></div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-8 offset-sm-2 offset-md-0">
														<div class="product home_item_large">
															<div class="product_tag d-flex flex-column align-items-center justify-content-center">
																<div>
																	<div>from</div>
																	<div>$8<span>.99</span></div>
																</div>
															</div>
															<div class="product_image"><img src="images/product_3.jpg" alt=""></div>
															<div class="product_content">
																<div class="product_info d-flex flex-row align-items-start justify-content-start">
																	<div>
																		<div>
																			<div class="product_name"><a href="product.php">Cool Clothing with Brown Stripes</a></div>
																			<div class="product_category">In <a href="category.php">Category</a></div>
																		</div>
																	</div>
																	<div class="ml-auto text-right">
																		<div class="rating_r rating_r_4 home_item_rating"><i></i><i></i><i></i><i></i><i></i></div>
																		<div class="product_price text-right">$8<span>.99</span></div>
																	</div>
																</div>
																<div class="product_buttons">
																	<div class="text-right d-flex flex-row align-items-start justify-content-start">
																		<div class="product_button product_fav text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/heart.svg" alt=""><div>+</div></div></div>
																		</div>
																		<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/cart_2.svg" alt=""><div>+</div></div></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="home_item_side"><a href="product.php"><img src="images/home_1.jpg" alt=""></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>

					<!-- Slide -->
					<div class="owl-item">
						<div class="background_image" style="background-image:url(images/home_1.jpg)"></div>
						<div class="container fill_height">
							<div class="row fill_height">
								<div class="col fill_height">
									<div class="home_container d-flex flex-column align-items-center justify-content-start">
										<div class="home_content">
											<div class="home_title">Premium Items</div>
											<div class="home_subtitle">Summer Wear</div>
											<div class="home_items">
												<div class="row">
													<div class="col-sm-3 offset-lg-1">
														<div class="home_item_side"><a href="product.php"><img src="images/product_3.jpg" alt=""></a></div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-8 offset-sm-2 offset-md-0">
														<div class="product home_item_large">
															<div class="product_tag d-flex flex-column align-items-center justify-content-center">
																<div>
																	<div>from</div>
																	<div>$5<span>.99</span></div>
																</div>
															</div>
															<div class="product_image"><img src="images/home_1.jpg" alt=""></div>
															<div class="product_content">
																<div class="product_info d-flex flex-row align-items-start justify-content-start">
																	<div>
																		<div>
																			<div class="product_name"><a href="product.php">Cool Clothing with Brown Stripes</a></div>
																			<div class="product_category">In <a href="category.php">Category</a></div>
																		</div>
																	</div>
																	<div class="ml-auto text-right">
																		<div class="rating_r rating_r_4 home_item_rating"><i></i><i></i><i></i><i></i><i></i></div>
																		<div class="product_price text-right">$5<span>.99</span></div>
																	</div>
																</div>
																<div class="product_buttons">
																	<div class="text-right d-flex flex-row align-items-start justify-content-start">
																		<div class="product_button product_fav text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/heart.svg" alt=""><div>+</div></div></div>
																		</div>
																		<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
																			<div><div><img src="images/cart_2.svg" alt=""><div>+</div></div></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="home_item_side"><a href="product.php"><img src="images/home_3.jpg" alt=""></a></div>
													</div>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>

				</div>
				<div class="home_slider_nav home_slider_nav_prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
				<div class="home_slider_nav home_slider_nav_next"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>

				<!-- Home Slider Dots -->
				
				<div class="home_slider_dots_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_slider_dots">
									<ul id="home_slider_custom_dots" class="home_slider_custom_dots d-flex flex-row align-items-center justify-content-center">
										<li class="home_slider_custom_dot active">01</li>
										<li class="home_slider_custom_dot">02</li>
										<li class="home_slider_custom_dot">03</li>
										<li class="home_slider_custom_dot">04</li>
									</ul>
								</div>
							</div>
						</div>
					</div>	
				</div>

			</div>
		</div>
		
		<!-- Products -->
		<div class="products">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="section_title text-center">Popular on EasyBuyin</div>
					</div>
				</div>
				<div class="row page_nav_row">
					<div class="col">
						<div class="page_nav">
							<ul class="d-flex flex-row align-items-start justify-content-center">
								<li class="active"><a href="category.php">Women</a></li>
								<li><a href="category.php">Men</a></li>
								<li><a href="category.php">Kids</a></li>
								<li><a href="category.php">Home Deco</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row products_row">
<?php      
					$query="SELECT * from PRODUCTS ORDER BY prodId DESC";
					$result=pg_query($conn,$query);
					while($row=pg_fetch_array($result)){
						echo '
					
						<div class="col-xl-4 col-md-6">
						<div class="product">
							<div class="product_image"><img src="data:image/jpeg;base64,'. base64_encode($row['prodPic']).'"/></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.php">'.$row['prodname'].'</a></div>
											<div class="product_category">'.$row['gender'].'</div>
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="rating_r rating_r_4 home_item_rating"><i></i><i></i><i></i><i></i><i></i></div>
										<div class="product_price text-right">$'.$row['price'].'<span></span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">
										<div class="product_button product_fav text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="images/heart_2.svg" class="svg" alt=""><div>+</div></div></div>
										</div>
										<input type="hidden" value="'.$row['prodID'].'" >
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
										<a href ="index.php?id='.$row['prodID'].'"><div><div><img src="images/cart.svg" class="svg" alt=""><div> + </div></div></div></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
						';
					}
					
					?>
					<!-- Product -->
					

					<!-- Product -->
				

				</div>
				<div class="row load_more_row">
					<div class="col">
						<div class="button load_more ml-auto mr-auto"><a href="#">load more</a></div>
					</div>
				</div>
			</div>
		</div>

		<!-- Boxes -->

		<div class="boxes">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="boxes_container d-flex flex-row align-items-start justify-content-between flex-wrap">

							<!-- Box -->
							<div class="box">
								<div class="background_image" style="background-image:url(images/box_1.jpg)"></div>
								<div class="box_content d-flex flex-row align-items-center justify-content-start">
									<div class="box_left">
										<div class="box_image">
											<a href="category.php">
												<div class="background_image" style="background-image:url(images/box_1_img.jpg)"></div>
											</a>
										</div>
									</div>
									<div class="box_right text-center">
										<div class="box_title">Trendsetter Collection</div>
									</div>
								</div>
							</div>

							<!-- Box -->
							<div class="box">
								<div class="background_image" style="background-image:url(images/box_2.jpg)"></div>
								<div class="box_content d-flex flex-row align-items-center justify-content-start">
									<div class="box_left">
										<div class="box_image">
											<a href="category.php">
												<div class="background_image" style="background-image:url(images/box_2_img.jpg)"></div>
											</a>
										</div>
									</div>
									<div class="box_right text-center">
										<div class="box_title">Popular Choice</div>
									</div>
								</div>
							</div>

							<!-- Box -->
							<div class="box">
								<div class="background_image" style="background-image:url(images/box_3.jpg)"></div>
								<div class="box_content d-flex flex-row align-items-center justify-content-start">
									<div class="box_left">
										<div class="box_image">
											<a href="category.php">
												<div class="background_image" style="background-image:url(images/box_3_img.jpg)"></div>
											</a>
										</div>
									</div>
									<div class="box_right text-center">
										<div class="box_title">Popular Choice</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Features -->

		<div class="features">
			<div class="container">
				<div class="row">
					
					<!-- Feature -->
					<div class="col-lg-4 feature_col">
						<div class="feature d-flex flex-row align-items-start justify-content-start">
							<div class="feature_left">
								<div class="feature_icon"><img src="images/icon_1.svg" alt=""></div>
							</div>
							<div class="feature_right d-flex flex-column align-items-start justify-content-center">
								<div class="feature_title">Fast Secure Payments</div>
							</div>
						</div>
					</div>

					<!-- Feature -->
					<div class="col-lg-4 feature_col">
						<div class="feature d-flex flex-row align-items-start justify-content-start">
							<div class="feature_left">
								<div class="feature_icon ml-auto mr-auto"><img src="images/icon_2.svg" alt=""></div>
							</div>
							<div class="feature_right d-flex flex-column align-items-start justify-content-center">
								<div class="feature_title">Premium Products</div>
							</div>
						</div>
					</div>

					<!-- Feature -->
					<div class="col-lg-4 feature_col">
						<div class="feature d-flex flex-row align-items-start justify-content-start">
							<div class="feature_left">
								<div class="feature_icon"><img src="images/icon_3.svg" alt=""></div>
							</div>
							<div class="feature_right d-flex flex-column align-items-start justify-content-center">
								<div class="feature_title">Free Delivery</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Footer -->

		<footer class="footer">
			<div class="footer_content">
				<div class="container">
					<div class="row">
						
						<!-- About -->
						<div class="col-lg-4 footer_col">
							<div class="footer_about">
								<div class="footer_logo">
									<a href="#">
										<div class="d-flex flex-row align-items-center justify-content-start">
											<div class="footer_logo_icon"><img src="images/logo_2.png" alt=""></div>
											<div>EasyBuyin</div>
										</div>
									</a>		
								</div>
								<div class="footer_about_text">
									<p>Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse potenti. Fusce venenatis vel velit vel euismod.</p>
								</div>
							</div>
						</div>

						<!-- Footer Links -->
						<div class="col-lg-4 footer_col">
							<div class="footer_menu">
								<div class="footer_title">Support</div>
								<ul class="footer_list">
									<li>
										<a href="#"><div>Customer Service<div class="footer_tag_1">online now</div></div></a>
									</li>
									<li>
										<a href="#"><div>Return Policy</div></a>
									</li>
									<li>
										<a href="#"><div>Size Guide<div class="footer_tag_2">recommended</div></div></a>
									</li>
									<li>
										<a href="#"><div>Terms and Conditions</div></a>
									</li>
									<li>
										<a href="#"><div>Contact</div></a>
									</li>
								</ul>
							</div>
						</div>

						<!-- Footer Contact -->
						<div class="col-lg-4 footer_col">
							<div class="footer_contact">
								<div class="footer_title">Stay in Touch</div>
								<div class="newsletter">
									<form action="#" id="newsletter_form" class="newsletter_form">
										<input type="email" class="newsletter_input" placeholder="Subscribe to our Newsletter" required="required">
										<button class="newsletter_button">+</button>
									</form>
								</div>
								<div class="footer_social">
									<div class="footer_title">Social</div>
									<ul class="footer_social_list d-flex flex-row align-items-start justify-content-start">
										<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer_bar">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="footer_bar_content d-flex flex-md-row flex-column align-items-center justify-content-start">
								<nav class="footer_nav ml-md-auto order-md-2 order-1">
									<ul class="d-flex flex-row align-items-center justify-content-start">
										<li><a href="category.php">Women</a></li>
										<li><a href="category.php">Men</a></li>
										<li><a href="category.php">Kids</a></li>
										<li><a href="category.php">Home Deco</a></li>
										<li><a href="#">Contact</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
		
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap-4.1.2/popper.js"></script>
<script src="styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/progressbar/progressbar.min.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="js/custom.js"></script>

<script> //for the signin and sign up buttons to show when the icon is clicked 
					    $(document).ready(function() {
        $('#as').click(function() {
			
				$('#asda').slideToggle();
				$('#asda').css("display","visible");
			        });
	});


					</script>
</body>
</html>