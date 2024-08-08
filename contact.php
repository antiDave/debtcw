<?php

require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validateInput($_POST['name']);
    $message = validateInput($_POST['message']);
    $email = validateInput($_POST['email']);
    $phone = validateInput($_POST['phone']);

    if (empty($name) || empty($phone) || empty($email)) {
        $error = 'Please fill in all required fields.';
    } else {
        $blockedPatterns = [
            '/Einscan H2/',
            '/\.ru>/',
            '/\Ñ ÑƒÑÑ/'
            // Add more patterns as needed
        ];

        $isBlocked = false;
        foreach ($blockedPatterns as $pattern) {
            if (preg_match($pattern, $message)) {
                $isBlocked = true;
                break;
            }
        }

        if ($isBlocked) {
            $error = 'Your message contains prohibited content.';
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

                $mail->setFrom('contact@debtcw.com', 'DebtCW Website Contact');
                $mail->addAddress('paul@debtcw.com');
                $mail->addCC('intake@debtcw.com');
                $mail->addBCC('usamtg@hotmail.com');

                $mail->isHTML(true);
                $mail->Subject = 'New Contact Form Submission';
                $mail->Body    = "
                    <h3>New Contact Form Submission</h3>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Message:</strong> $message</p>
                ";

                $mail->send();
                $success = 'Your message has been submitted successfully.';
                header("Location: thank_you.html");
                exit();

            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
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
            <li class="nav-item"><a class="nav-link" href="place_a_claim.php">Place a Claim</a></li>

            <li class="nav-item"><a class="nav-link" href="pricing.html">Pricing</a></li>
		        <li class="nav-item"><a class="nav-link" href="https://app.simplicitycollect.com/ClientPortalLogin.aspx">Login</a></li>
		        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_3.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 text-center mb-5">
            <p class="breadcrumbs"><span class="me-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Contact us <i class="fa fa-chevron-right"></i></span></p>
            <h1 class="mb-0 bread">Contact Us</h1>
          </div>
        </div>
      </div>
    </section>


    <section class="ftco-section bg-light">
      <div class="container-xl">
        <div class="row no-gutters justify-content-center">
          <div class="col-lg-10">
            <div class="wrapper">
              <div class="row g-5">
                <div class="col-md-6 order-md-last d-flex align-items-stretch">
                  <div class="contact-wrap w-100 p-md-5 p-4">
                    <h3 class="mb-4">Contact us</h3>
                    <form method="POST" id="contactForm" name="contactForm" class="contactForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="label" for="name">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                          </div>
                        </div>
                        <div class="col-md-6"> 
                          <div class="form-group">
                            <label class="label" for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="label" for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="label" for="website">Website</label>
                            <input type="text" class="form-control" name="website" id="website" placeholder="Website">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="label" for="#">Message</label>
                            <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Message" required></textarea>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary">
                            <div class="submitting"></div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($error)) { ?>
                          <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                        <?php } ?>
                        <?php if (!empty($success)) { ?>
                          <div class="alert alert-success mt-3"><?php echo $success; ?></div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 d-flex align-items-stretch">
                  <div id="map" class="map"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="footer">
      <div class="container-xl">
        <div class="row mb-5">
          <div class="col-md-4 mb-5">
            <div class="ftco-footer-widget">
              <h2 class="ftco-heading-2 logo d-flex"><a href="#"><span>DebtCW</span></a></h2>
              <p>With Debt Collectors Worldwide there is no fee unless we recover your money. We are committed to efficiently resolving outstanding debts for both consumers and businesses in the US and Canada.</p>
              <ul class="ftco-footer-social list-unstyled mt-2">
                <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                <li><a href="#"><span class="fa fa-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 mb-5">
            <div class="ftco-footer-widget">
              <h2 class="ftco-heading-2">Company</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>About</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>News</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Contact</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Careers</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-2 mb-5">
            <div class="ftco-footer-widget">
              <h2 class="ftco-heading-2">Services</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Marketing Strategy</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Web Development</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Market Research</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>SEO</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Pay Per Click</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Event Marketing</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 mb-5">
            <div class="ftco-footer-widget">
              <h2 class="ftco-heading-2">Resources</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Security</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Global</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Charts</a></li>
                <li><a href="#"><span class="fa fa-chevron-right me-2"></span>Privacy</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <p class="mb-0">Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved.</p>
          </div>
          <div class="col-md-6 text-md-end">
            <p class="mb-0">This template is made with <span class="fa fa-heart color-danger" aria-hidden="true"></span> by <a href="https://colorlib.com" target="_blank" rel="noopener noreferrer">Colorlib</a></p>
          </div>
        </div>
      </div>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>
    <script src="js/glightbox.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/datepicker.min.js"></script>
    <script src="js/datepicker.en.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/purecounter.js"></script>
    <script src="js/fancybox.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
