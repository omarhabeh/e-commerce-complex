<?php  
$host = "ec2-79-125-2-142.eu-west-1.compute.amazonaws.com";
$username = "ixpbvdzakdhcrm";
$password = "5bd7efa38326e79f34cd08ffca8bdf5ac17f7dd5c0ea5670b144873ef4ca2dfd";
$db = "d6kg1bsc34mrv4"; 
$port="5432";
$conn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password ");
if ( ! empty( $_POST ) ) {
	/*$query = "CREATE TABLE IF NOT EXISTS  USERS_table (
              ID SERIAL,
              firstName varchar(255),
			  lastName varchar(255),
			  EMAIL varchar(255) ,
			  PASSWORD varchar(255) ,
			  PERMISSION_LEVEL int
			  )";
	$res = pg_query($query);
*/
$stmt = pg_prepare($conn,"","SELECT * FROM USERS_table WHERE email = $1 ");
$stmt = pg_execute($conn, '', array($_POST['email']));
$user = pg_fetch_object($stmt);
    $fname=$_POST['fname'] ;
    $lname=$_POST['lname'] ;
    $email=$_POST['email'] ;
    $pass=$_POST['pass'] ;
    $pass2=$_POST['re_pass'];
    if ($pass == $pass2 ){
        if ($user == null ){
            session_start();
            $_SESSION['fname'] = $_POST['fname'];
            $query="INSERT INTO USERS_table (ID,firstName ,lastName ,EMAIL,PASSWORD,PERMISSION_LEVEL) value (0,'$fname','$lname','$email','$pass',1) ";
        }
        else {
            
            $error ="the email is already used ";
            
        }
    }
    else {
       
        $error ="the password doesnt match ";
      
    }

if (pg_query($query) && empty($error)) {
	$stmt = pg_prepare($conn,"","SELECT * FROM USERS_table WHERE email = $1 ");
	$stmt = pg_execute($conn, '', array($_POST['email']));
    $user = pg_fetch_object($stmt);
    $_SESSION['email']=$_POST['EMAIL'];
    $_SESSION['prl']=$user->PERMISSION_LEVEL;
    $_SESSION['id']=$user->ID;
    header('Location: index.php');
} else {
   echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up </title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/flexslider/flexslider.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/product_responsive.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
				<a href="index.php">
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
				<div class="cart"><a href="cart.php"><div><img class="svg" src="images/cart.svg" ><div><?php if(!empty($_SESSION['s'])){echo $_SESSION['s'];}?></div></div></a></div>
				
				
				<!-- Phone -->
				<div class="header_phone d-flex flex-row align-items-center justify-content-start">
					<div><div><img src="images/phone.svg" ></div></div>
					<div>+1 912-252-7350</div>
				</div>
			</div>
		</div>
	</header>
    <div class="main">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <?php  if(!empty($error)){ echo "<p style='color:red;' > $error </p>";}?>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="fname" id="name" placeholder="First Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="lname" id="name" placeholder="Last Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signin.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>


       

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
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
	<script src="js/main.js"></script>
	<script> //for the signin and sign up buttons to show when the icon is clicked 
					    $(document).ready(function() {
        $('#as').click(function() {
			
				$('#asda').slideToggle();
				$('#asda').css("display","visible");
			        });
	});


					</script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>