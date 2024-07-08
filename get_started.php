<?php

require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = validateInput($_POST['firstName']);
    $lastName = validateInput($_POST['lastName']);
    $email = validateInput($_POST['email']);
    $phone = validateInput($_POST['phone']);

    $error = '';
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        $error = 'Please fill in all required fields.';
    } else {
        try {
        	$mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtppro.zoho.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contact@debtcw.com';
            $mail->Password = '#Howiedoit0321';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

          // First email
          $mail = new PHPMailer(true);
          $mail->setFrom('contact@debtcw.com', 'DebtCW Website Contact');
          $mail->addAddress('paul@debtcw.com');
          $mail->addCC('intake@debtcw.com');
          $mail->addBCC('usamtg@hotmail.com');

          $mail->isHTML(true);
          $mail->Subject = 'New Get Started Submission';
          $mail->Body = "
              <h3>New Collection Claim Submission</h3>
              <p><strong>Name:</strong> $firstName $lastName</p>
              <p><strong>Email:</strong> $email</p>
              <p><strong>Phone:</strong> $phone</p>
          ";

          $mail->send();

          // Second email for thank you
          $mail = new PHPMailer(true); // Create a new instance for the thank-you email
          $mail->setFrom('contact@debtcw.com', 'DebtCW | Debt Collectors Worldwide');
          $mail->addAddress($email);

          $mail->isHTML(true);
          $mail->Subject = 'Thank you for submitting your information with Debt Collectors Worldwide.';
          $mail->Body = "
              <h3>New Get Started Submission</h3>
              <p>We are pleased to welcome you and appreciate the trust you have placed in our team to handle your collection needs. Our goal is to make the claims process as smooth and efficient as possible.</p>
              <p>We understand that every case is unique, and we are committed to providing you with personalized service and attention.</p>
              <p>We will contact you soon and will begin Working On Your Files Immediately.</p>
              <p>Have A Great Day, And We Look Forward To Helping Resolve Your Situation.</p>
              <p>-The DCW Team</p>
          ";

          $mail->send();


            $success = 'Your claim has been submitted successfully.';
            header("Location: thank_you.html?name=$firstName&email=$email");

        } catch (Exception $e) {
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>DebtCW - Debt Collectors Worldwide</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="site_favicon.ico">
	<meta name="keywords" content="best price debt collection agency, no fee debt collection service">
    <meta name="description" content="With Debt Collectors Worldwide there is no fee unless we recover your money. We are committed to efficiently resolving outstanding debts for both consumers and businesses in the US and Canada.">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/tiny-slider.css">
    <link rel="stylesheet" href="css/glightbox.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/datepicker.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
      .tns-nav {
      display: none !important;
    }
    @media (max-width: 900px) {
      .main-content {
        display: inline-block;
        left: 13%;
      }
    }
    .card {
        width: 70%;
        left: 15%;
        margin-bottom: 30px;
      }
    </style>
  </head>
  <body>

    <div id="top-wrap" class="top-wrap">
      <div class="container">
        <div class="row">
          
            <!-- <div class="con">
              <a href="tel:800-783-5744"><p class="mb-0"><span class="fa fa-phone"></span> Call Us: +1 800 783 5744</p></tel>
            </div> -->
          

          <div class="col-md d-flex justify-content-start justify-content-md-end align-items-center">
            <p class="ftco-social d-flex">
              <a href="#" class="d-flex align-items-center justify-content-center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
              </svg></a>
              <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
              <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-google"></span></a>
              <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"></span></a>
            </p>
          </div>
        </div>
      </div>
    </div>
    <nav id="main-navbar" class="navbar navbar-expand-lg ftco-navbar-light">
		  <div class="container-xl">
      <a class="navbar-brand" href="/">
            <!-- Debt<small>cw</small> --><img src="images/logo.webp.png" height="50px">
            <!-- <span>Debt Collection Services</span> -->
        </a>
        <div class="con phone-1">
          <a href="tel:800-783-5744"><p class="mb-0"><span class="fa fa-phone"></span> Call Us: +1 800 783 5744</p></a>
        </div>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="fa fa-bars"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
		        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
		        <li class="nav-item"><a class="nav-link" href="index.html#about">About</a></li>
            <li class="nav-item"><a class="nav-link active" href="place_a_claim.php">Place a Claim</a></li>

            <li class="nav-item"><a class="nav-link" href="pricing.html">Pricing</a></li>
		        <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
		        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 text-center mb-5">
            <p class="breadcrumbs"><span class="me-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Get Started <i class="fa fa-chevron-right"></i></span></p>
            <h1 class="mb-0 bread">Guaranteed Debt Collection Services</h1>
          </div>
        </div>
      </div>
    </section>



    <div class="container mt-5">
        <div class="card placecard">
            <div class="card-body">
                <h3 class="card-title text-center">Get Started Now</h3>
                <p class="card-text text-center">
                    Take the first step to allow Debt Collectors Worldwide to handle collecting your old debt.
                </p>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <form action="get_started.php" method="POST">
                    <!-- Form fields -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstName">Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">&nbsp;</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                        </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="(000) 000-0000">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div></div>


    <footer class="ftco-footer img" style="background-image: url(images/bg_1.jpg); width:100%;">
      <div class="overlay"></div>
      <div class="container-xl">
        <div class="row mb-5 justify-content-between">
          <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4">

              <img src="images/logo.webp-white.png" width="200px" alt="DebtCW Logo White">
              <ul class="ftco-footer-social mt-4">
                <li>
                  <a href="#">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                      <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                    </svg></span>
                  </a>
                </li>
                <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                <li><a href="#"><span class="fa fa-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Navigation</h2>
              <div class="d-md-flex">
                <ul class="list-unstyled w-100">
                  <li><a href="/"><span class="ion ion-ios-arrow-round-forward me-2"></span>Home</a></li>
                  <li><a href="index.html#about" title="Debt Collectors Worldwide about page."><span class="ion ion-ios-arrow-round-forward me-2"></span>About</a></li>
                  <li><a href="place_a_claim.php"title="Debt Collectors Worldwide place a claim page."><span class="ion ion-ios-arrow-round-forward me-2"></span>Place a Claim</a></li>

                </ul>
                <ul class="list-unstyled w-100">
                  
                  <li><a href="https://app.simplicitycollect.com/ClientPortalLogin.aspx" target="_blank" title="Debt Collectors Worldwide client login page."><span class="ion ion-ios-arrow-round-forward me-2"></span>Login Client</a></li>
                  <li><a href="pricing" title="Debt Collectors Worldwide pricing page."><span class="ion ion-ios-arrow-round-forward me-2"></span>Pricing</a></li>
                  <li><a href="contact.php" title="Debt Collectors Worldwide contact page."><span class="ion ion-ios-arrow-round-forward me-2"></span>Contact</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Recent Posts</h2>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img img rounded" style="background-image: url(images/image_1.jpg);"></a>
                <div class="text">
                  <div class="meta">
                    <div><a href="#"><span class="fa fa-calendar"></span> Jan. 27, 2024</a></div>
                    <div><a href="#"><span class="fa fa-user"></span> Admin</a></div>
                  </div>
                  <h3 class="heading"><a href="blog-single">Debt recovery is a big challenge for business</a></h3>
                </div>
              </div>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img img rounded" style="background-image: url(images/image_2.jpg);"></a>
                <div class="text">
                  <div class="meta">
                    <div><a href="#"><span class="fa fa-calendar"></span> Jan. 27, 2024</a></div>
                    <div><a href="#"><span class="fa fa-user"></span> Admin</a></div>
                  </div>
                  <h3 class="heading"><a href="blog-single2">Ready for Regulation F and successful collections</a></h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Have a Question?</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon fa fa-map marker"></span><span class="text">Windermere, Florida, USA</span></li>
                  <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+1 800 783 5744</span></a></li>
                  <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">contact@debtcw.com</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid px-0 py-5 bg-darken">
          <div class="container-xl">
              <div class="row">
              <div class="col-md-12 text-center">
                <p class="mb-0" style="font-size: 14px;">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Debt Collectors Worldwide, LLC</p>
              </div>
            </div>
          </div>
      </div>
    </footer>

    <script>
      function toggleMenu() {
          var menu = document.querySelector('.nav-menu');
          menu.classList.toggle('open');
      }

      window.addEventListener('scroll', function() {
      var topWrap = document.getElementById('top-wrap');
      var navbar = document.getElementById('main-navbar');
      var body = document.body;

      if (window.scrollY > 150) {
        topWrap.style.display = 'none';
        navbar.classList.add('fixed-top');
        body.classList.add('navbar-fixed');
      } else {
        topWrap.style.display = 'block';
        navbar.classList.remove('fixed-top');
        body.classList.remove('navbar-fixed');
      }
    });

    </script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>
    <script src="js/glightbox.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/datepicker.min.js"></script>
    <script src="js/main.js"></script>
   
  </body>
</html>
