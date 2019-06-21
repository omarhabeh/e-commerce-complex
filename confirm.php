<?php  session_start(); 
$servername = "ec2-79-125-2-142.eu-west-1.compute.amazonaws.com:5432";
$username = "ixpbvdzakdhcrm";
$password = "5bd7efa38326e79f34cd08ffca8bdf5ac17f7dd5c0ea5670b144873ef4ca2dfd";
$db = "d6kg1bsc34mrv4"; 
$conn = pg_connect($servername, $username, $password , $db);
$query="SELECT * FROM newspaperEmails";
$res=pg_query($conn,$query);
if(empty($res)) {
	$query = "CREATE TABLE newspaperEmails (
		email varchar(255) )";
	$res = pg_query($conn, $query);
}
if(!empty($_SESSION['email'])){
	$sss=$_SESSION['email'];
	}
$query="insert into newspaperEmails(email) value ($sss)" ;
$res=pg_query($conn,$query);
require 'PHPMailerAutoload.php';
require 'phpmailer/class.phpmailer.php';
$mail = new PHPMailer;

$mail->SMTPDebug = 4;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'easybuyinemail@gmail.com';                 // SMTP username
$mail->Password = 'Jusuf1221';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
/*$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);*/

$mail->setFrom('easybuyinemail@gmail.com', 'EasyBuyin');
$mail->addAddress("l6h2010@hotmail.com");     // Add a recipient          // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');
$mail->SMTPAuth = true;
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'your EasyBuyin reciept';
$mail->Body =  '
<table>
<tbody>
<h3 class="display-2">Thank You for Your Purchase '.$_SESSION['fname'].' !</h3>
<tr>
 <td><h3> <Strong> Total amount paid:</Strong></h3></td>
 <td></td>
     <td></td>
     <td> <h3>$'.$_SESSION['total'].' </h3></td>
</tr>
</tbody>
</table> ';

/*$mail->Body    =  '

<div class="jumbotron" stlye=" display: block;overflow: auto;">
<h1 class="display-2">Thank You for Your Purchase!</h1>
<h1 style="text-transform: uppercase;" ><?php'. $_SESSION['fname']  .'?></h1>
<p id="date"></p>
<hr class="my-4" >
<table class="table" >
       
       <tbody style="height: auto !important ;overflow:hidden !important;"> 
        <tr >
            '. if(!empty($_POST['CCNO'])){.'
        <h3 style="text-transform: uppercase;">The Payment was done with the card ending with  '. substr($_POST['CCNO'], -4) .'</h3>
        '.;}.'
       '. if(empty($_POST['CCNO'])){.'
        <h3 style="text-transform: uppercase;">The payment will be paid in cash when the dilevery is made  </h3>
      '.;}.'
       
        </tr>
        
     			'.if(!empty($_SESSION['id'])){
                $userId=$_SESSION['id'];
                $query="SELECT * from cart left join products on cart.CartId = products.prodID where userId=$userId";
                $result=pg_query($conn,$query);
                $count=1;
                while($row=mysqli_fetch_array($result) ){
                .'
                <tr height: auto;overflow:hidden;>
                        <td><div class="product_number">'.$count++.'</div></td>
                        <td ><img src="data:image/jpeg;base64,'. base64_encode($row['prodPic']).'" style="width:100px;height:100px;" /></td>
                        <td class="product_name_container">
                            <p>'.$row['prodname'].'</p>
                        </td>
                    <td class="product_price product_text sa"id="" ><span>Price: </span>$'.$row['price'].'</td>
                    
                    <tr>'
                '.'} }.  ';?>
                <tr>
                    <td><h3> <Strong> Total :</Strong></h3></td>
                    <td></td>
                        <td></td>
                        <td> <h3> <?php  if(isset($_SESSION['total']) ){
                        
                        echo "$ ".$_SESSION['total'];
                    } else { echo "$0";}?> </h3></td>
                </tr>
                
        </tbody>
       
      </table>
      <table >
      <tr>
                <h3>The Reciept was sent to your email </h3>
                </tr>
                    <tr>
                <h3><a href="new.php">Return To Main Page</h3>
                </tr>
                </table>
</div>
</div>

';*/
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			
?>	
<!DOCTYPE html>
<html lang="en">
<head>
<title>Checkout</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="EasyBuyin template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/checkout.css">
<link rel="stylesheet" type="text/css" href="styles/checkout_responsive.css">
<link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
<style>
    body , html{
 height: 100%;
}
    </style>
</head>
<body>

<!-- Menu -->

<div class="menu">

	<!-- Search -->
	<div class="menu_search">
		<form action="#" id="menu_search_form" class="menu_search_form">
			<input type="text" class="search_input" placeholder="Search Item" required>
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
			<div><div><img src="images/phone.svg" alt="https://www.flaticon.com/authors/freepik"></div></div>
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
					<li><a href="#">Women</a></li>
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


        <div class="wrapper" style="  min-height: 100%;margin-top:100px!important;"> 
	<div class="super_container_inner">

        <div class="container-fluid text-center" >
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
            </div>
            <div class="col-md-auto">
                <div class="jumbotron" stlye=" display: block;overflow: auto;">
                    <h1 class="display-2">Thank You for Your Purchase!</h1>
                    <h1 style="text-transform: uppercase;" ><?php echo $_SESSION['fname']  ?></h1>
                    <p id="date"></p>
                    <hr class="my-4" >
                    <table class="table" >
                           
                           <tbody style="height: auto !important ;overflow:hidden !important;"> 
                            <tr >
                                <?php if(!empty($_POST['CCNO'])){
                                    echo '
                            <h3 style="text-transform: uppercase;">The Payment was done with the card ending with  '. substr($_POST['CCNO'], -4) .'</h3>
                            ';}?>
                           <?php if(empty($_POST['CCNO'])){
                            echo '<h3 style="text-transform: uppercase;">The payment will be paid in cash when the dilevery is made  </h3>'
                           ;}?>
                           
                            </tr>
                            
                            <?php								if(!empty($_SESSION['id'])){
									$userId=$_SESSION['id'];
										
									$query="SELECT * from cart left join products on cart.CartId = products.prodID where userId=$userId";
									$result=pg_query($conn,$query);
									$count=1;
									while($row=pg_fetch_array($result) ){
                                    echo '
                                    <tr height: auto;overflow:hidden;>
											<td><div class="product_number">'.$count++.'</div></td>
											<td ><img src="data:image/jpeg;base64,'. base64_encode($row['prodPic']).'" style="width:100px;height:100px;" /></td>
											<td class="product_name_container">
												<p>'.$row['prodname'].'</p>
											</td>
										<td class="product_price product_text sa"id="" ><span>Price: </span>$'.$row['price'].'</td>
										
                                        <tr>'
                                    ;} }?>
                                    <tr>
                                        <td><h3> <Strong> Total :</Strong></h3></td>
                                        <td></td>
                                            <td></td>
                                            <td> <h3> <?php  if(isset($_SESSION['total']) ){
											
											echo "$ ".$_SESSION['total'];
										} else { echo "$0";}?> </h3></td>
                                    </tr>
                                    
                            </tbody>
                           
                          </table>
                          <table >
                          <tr>
                                    <h3>The Reciept was sent to your email </h3>
                                    </tr>
                                        <tr>
                                    <h3><a href="new.php">Return To Main Page</h3>
                                    </tr>
                                    </table>
                  </div>
            </div>
            <div class="col-md-auto">
            </div>
        </div>
        
    </div>
	

		<div class="checkout">
			<div class="container">
				<div class="row">
					<div class="d-flex justify-content-center">
                        <div  class="well" style="margin:100px!important;">
</div >
                

                    </div>
					<!-- Billing -->
                    

</div>
				

</div>
		<footer class="footer" style="margin-top:-200px!important;">
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
									<!--<form action="#" id="newsletter_form" class="newsletter_form"> </form>-->
										<input type="email" class="newsletter_input" placeholder="Subscribe to our Newsletter" required>
										<button class="newsletter_button">+</button>
									
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
<script src="plugins/easing/easing.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="js/checkout.js"></script>
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