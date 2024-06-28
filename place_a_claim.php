<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PDF instance
$pdf = new TCPDF();
// add a page
$pdf->AddPage();


function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = validateInput($_POST['firstName']);
    $lastName = validateInput($_POST['lastName']);
    $company = validateInput($_POST['company']);
    $address = validateInput($_POST['address']);
    $address2 = validateInput($_POST['address2']);
    $city = validateInput($_POST['city']);
    $state = validateInput($_POST['state']);
    $zip = validateInput($_POST['zip']);
    $email = validateInput($_POST['email']);
    $phone = validateInput($_POST['phone']);
    $terms = isset($_POST['terms']);
    $signature = validateInput($_POST['signature']);

    $error = '';
    if (empty($firstName) || empty($lastName) || empty($address) || empty($city) || empty($state) || empty($zip) || empty($email) || empty($phone) || !$terms || empty($signature)) {
        $error = 'Please fill in all required fields and agree to the terms.';
    } else {
          // create some HTML content
          $date = date('m/d/Y', time());
          $mail = new PHPMailer(true);
          $html = '<style>
            .card { width: 70%; left: 15%; }
            .contract-container {
              width: 100%;
              max-width: 600px;
              height: 300px;
              border: 1px solid #ccc;
              margin: 20px auto;
            }
            .contract-text {
              height: 100%;
              margin: 0;
              padding: 10px;
              overflow-y: auto;
              font-family: Trebuchet, Courier, monospace;
              font-size: 14px;
              line-height: 1.5;
              white-space: pre-wrap;
              word-wrap: break-word;
              color: #000;
            }
          </style>
          <h2>Terms of Service Agreement</h2>
          <p>THIS AGREEMENT IS MADE BETWEEN DEBT COLLECTORS WORLDWIDE, LLC. HEREIN REFERRED TO AS DCW and "SIGNER", HEREIN REFERRED TO AS CLIENT.</p>
          <ol>
            <li>Upon placement of a claim(s) DCW will use its best efforts to collect the claim on behalf of CLIENT.</li>
            <li>CLIENT warrants the validity, amount and authenticity of all claims placed with DCW for collection. Upon request, CLIENT agrees to forward documentation to DCW to prove the amount, and authenticity of the claim.</li>
            <li>CLIENT may withdraw a claim placed with DCW only where a) there has been no activity on the claim in the preceding sixty (60) days and b) the claim has not been forwarded to an affiliated attorney. All withdrawals must be done via facsimile to (561)910-4717 by CLIENT, and any commission then due and payable to DCW must be paid before a claim is deemed withdrawn. Any claim canceled by CLIENT while payments are being made will be billed by DCW for the full anticipated commission due on the entire amount of the original claim assigned to DCW. There is a fee of 10% of the principal balance of the claim for administrative, initiation and clerical expenses on any claim withdrawn by CLIENT not in accordance with the provisions of paragraph 3a and 3b.</li>
            <li>CLIENT shall report all direct payments made on a claim within three (3) business days of receipt of payment, and the commission due on the direct payment shall be remitted to DCW within (3) days. Once a claim is placed with DCW for collection, CLIENT shall not instruct debtors to make payments directly to CLIENT. CLIENT agrees to forward all communication with the debtor to DCW.</li>
            <li>All claims placed with DCW by CLIENT that are under one (1) year in age from the delinquency date shall be billed at a rate of 30% of all funds collected. All claims placed that are over one (1) year in age from the delinquency date shall be billed at a rate of 40% of all funds collected. Any claim, regardless of age, with a balance owed under $1,000.00 shall be billed at a rate of 50% of all funds collected. Any and all fees incurred during the collections process shall be passed to the client. Any claim that is forwarded to an affiliated attorney of DCW shall be billed at a rate of 50%. DCW is entitled to their full commission due on any payment(s) received, regardless of payer or whether paid to DCW or CLIENT once the claim is submitted.</li>
            <li>Any merchandise returned to CLIENT by Debtor shall entitle DCW to a commission equal to 10% of the actual invoiced amount.</li>
            <li>Any claim placed with DCW by CLIENT that is discovered to have been previously paid or placed by CLIENT in error will be billed by DCW to Client at a rate of 10% of the placed amount as an administrative, clerical and initiation fee.</li>
            <li>CLIENT understands that DCW may, at their discretion, forward a case or a claim to an outside law firm or collection network to assist in the recovery of said claim, and hereby grants DCW permission to do so. It is further understood that CLIENT must give approval if such a transfer will result in additional charges.</li>
            <li>DCW shall account to CLIENT monthly, all funds collected by DCW on CLIENT\'S behalf and all remittances and/or invoices will be sent at this time.</li>
            <li>CLIENT grants to DCW and to any affiliated attorney or collection firm that may be forwarded CLIENT claim(s) the express authority to endorse and negotiate any check, draft or other negotiable instrument made payable to CLIENT for deposit in trust for distribution to CLIENT after deducting the commission and fees due DCW under this agreement.</li>
            <li>In no event shall DCW be liable in any respect for the inability to collect any claim placed by CLIENT for collection. It is understood and agreed that DCW is not a guarantor of any specific result on accounts placed by CLIENT.</li>
            <li>DCW agrees and shall hold harmless CLIENT from any claim, demand, action, or judgment, including all reasonable legal fees arising out of any action done by DCW in connection with the collection of any claim(s) placed by CLIENT, which is not a result of a violation by CLIENT of any portion of provision 2.</li>
            <li>This agreement shall be construed in accordance with the laws of the State of Florida. If any provision hereof is found to be invalid or unenforceable, then that provision shall be deemed to be severed and removed and the remaining provisions shall remain valid and in full effect.</li>
          </ol>
          <p>Signature:</p>
          <img src="' . $signature . '" alt="Signature" class="signature"><br>
          ' . $firstName . ' ' . $lastName . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $date;

          // output the HTML content
          $pdf->writeHTML($html, true, 0, true, 0);

          // reset pointer to the last page
          $pdf->lastPage();

          // ---------------------------------------------------------
          // ---------------------------------------------------------
          if ($_SERVER['HTTP_HOST'] === 'debtcww.com') {
              $agreementsDir = '/var/www/vhosts/debtcw.com/httpdocs/pdfs';
              $pdfPath = '/var/www/vhosts/debtcw.com/httpdocs/pdfs/agreement_' . time() . '.pdf';
          } else {
              $agreementsDir = 'c:\\xampp-new\\htdocs\\debtcww\\pdfs';
              $pdfPath = 'c:\\xampp-new\\htdocs\\debtcww\\pdfs\\agreement_' . time() . '.pdf';
          }

          if (!file_exists($agreementsDir)) {
              mkdir($agreementsDir, 0755, true);
          }
          // ---------------------------------------------------------
          // ---------------------------------------------------------

		      $pdf->Output($pdfPath, 'F');


          $mail = new PHPMailer(true);
          $mail->isSMTP();
          $mail->Host = 'smtppro.zoho.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'contact@debtcw.com';
          $mail->Password = '#Howiedoit0321';
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          
          // First email
          $mail->setFrom('contact@debtcw.com', 'DebtCW Website Contact');
          $mail->addAddress('paul@debtcw.com');
          $mail->addAddress('intake@debtcw.com');
          
          $mail->isHTML(true);
          $mail->addAttachment($pdfPath);
          $mail->Subject = 'New Collection Claim Submission';
          $mail->Body = "
              <h3>New Collection Claim Submission</h3>
              <p><strong>Name:</strong> $firstName $lastName</p>
              <p><strong>Company:</strong> $company</p>
              <p><strong>Address:</strong> $address $address2, $city, $state, $zip</p>
              <p><strong>Email:</strong> $email</p>
              <p><strong>Phone:</strong> $phone</p>
              <p><strong>Signature:</strong> $signature</p>
              <p><strong>Terms:</strong> $terms</p>
          ";

          $mail->send();

          // Second email for thank you
          $fmail = new PHPMailer(true);
          $fmail->isSMTP();
          $fmail->Host = 'smtppro.zoho.com';
          $fmail->SMTPAuth = true;
          $fmail->Username = 'contact@debtcw.com';
          $fmail->Password = '#Howiedoit0321';
          $fmail->SMTPSecure = 'tls';
          $fmail->Port = 587;
          $fmail->setFrom('contact@debtcw.com', 'DebtCW | Debt Collectors Worldwide');
          $fmail->addAddress($email);

          $fmail->isHTML(true);
          $fmail->Subject = 'Thank you for submitting your claim with Debt Collectors Worldwide.';
          $fmail->Body = "
              <h3>New Collection Claim Submission</h3>
              <p>We are pleased to welcome you and appreciate the trust you have placed in our team to handle your collection needs. Our goal is to make the claims process as smooth and efficient as possible.</p>
              <p>We understand that every case is unique, and we are committed to providing you with personalized service and attention.</p>
              <p>To get started, Simply Reply To This Email With All Documentation That Validates The Debts (Invoices, Contracts, Emails, Etc..) And We Will Begin Working On Your Files Immediately.</p>
              <p>Have A Great Day, And We Look Forward To Helping Resolve Your Situation.</p>
              <p>-The DCW Team</p>
          ";

          $fmail->send();

          $success = 'Your claim has been submitted successfully.';
          header("Location: thank_you?name=$firstName&email=$email");
        
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
        }
      .contract-container {
        width: 100%;
        max-width: 600px; /* adjust as needed */
        height: 300px; /* adjust to show approximately 6 lines */
        border: 1px solid #ccc;
        margin: 20px auto;
      }

      .contract-text {
        height: 100%;
        margin: 0;
        padding: 10px;
        overflow-y: auto;
        font-family: 'Courier New', Courier, monospace;
        font-size: 14px;
        line-height: 1.5;
        white-space: pre-wrap;
        word-wrap: break-word;
        color: #000;
      }

      #agreeButton {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      #agreeButton:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
      }

      /* Custom scrollbar styles */
      .contract-text::-webkit-scrollbar {
        width: 6px;
      }

      .contract-text::-webkit-scrollbar-track {
        background: #f1f1f1;
      }

      .contract-text::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
      }

      .contract-text::-webkit-scrollbar-thumb:hover {
        background: #555;
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
            <h1 class="mb-0 bread">Debt Collection Services</h1>
          </div>
        </div>
      </div>
    </section>



      <div class="container mt-5">
          <div class="card placecard">
              <div class="card-body">
                  <h3 class="card-title text-center">Get Started Now</h3>
                  <p class="card-text text-center">
                      Please complete the form below so we can start handling your claims. By completing the form you are agreeing to allow Debt Collectors Worldwide to handle the collection claims placed with us.
                  </p>
                  <?php if (!empty($error)): ?>
                      <div class="alert alert-danger"><?php echo $error; ?></div>
                  <?php endif; ?>
                  <?php if (!empty($success)): ?>
                      <div class="alert alert-success"><?php echo $success; ?></div>
                  <?php endif; ?>
                  <form action="place_a_claim.php" method="POST">
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
                          <div class="form-group col-md-12">
                              <label for="company">Company</label>
                              <input type="text" class="form-control" id="company" name="company" placeholder="Type in N/A if you are not a company">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address" name="address" placeholder="Street Address">
                      </div>
                      <div class="form-group">
                          <input type="text" class="form-control" id="address2" name="address2" placeholder="Street Address Line 2">
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="city">City</label>
                              <input type="text" class="form-control" id="city" name="city">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="state">State / Province</label>
                              <input type="text" class="form-control" id="state" name="state">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="zip">Postal / Zip Code</label>
                              <input type="text" class="form-control" id="zip" name="zip">
                          </div>
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
                      <div class="form-group form-check">
                          <input type="checkbox" class="form-check-input" id="terms" name="terms">
                          <label class="form-check-label" for="terms">
                              BY CLICKING THIS CHECKBOX YOU AGREE TO THE TERMS AND CONDITIONS BELOW.
                          </label>
                      </div>
                      <div class="contract-container">
                    <pre id="contractText" class="contract-text">
                    Terms of Service Agreement

THIS AGREEMENT IS MADE BETWEEN DEBT COLLECTORS WORLDWIDE, LLC. HEREIN REFERRED TO AS DCW and "SIGNER", HEREIN REFERRED TO AS CLIENT.

 

1. Upon placement of a claim(s) DCW will use its best efforts to collect the claim on behalf of CLIENT.

2. CLIENT warrants the validity, amount and authenticity of all claims placed with DCW for collection. Upon request, CLIENT agrees to forward documentation to DCW to prove the amount, and authenticity of the claim.

3. CLIENT may withdraw a claim placed with DCW only where a) there has been no activity on the claim in the preceding sixty (60) days and b) the claim has not been forwarded to an affiliated attorney. All withdrawals must be done via facsimile to (561)910-4717 by CLIENT, and any commission then due and payable to DCW must be paid before a claim is deemed withdrawn. Any claim canceled by CLIENT while payments are being made will be billed by DCW for the full anticipated commission due on the entire amount of the original claim assigned to DCW. There is a fee of 10% of the principal balance of the claim for administrative, initiation and clerical expenses on any claim withdrawn by CLIENT not in accordance with the provisions of paragraph 3a and 3b.

4. CLIENT shall report all direct payments made on a claim within three (3) business days of receipt of payment, and the commission due on the direct payment shall be remitted to DCW within (3) days. Once a claim is placed with DCW for collection, CLIENT shall not instruct debtors to make payments directly to CLIENT. CLIENT agrees to forward all communication with the debtor to DCW.

5. All claims placed with DCW by CLIENT that are under one (1) year in age from the delinquency date shall be billed at a rate of 30% of all funds collected. All claims placed that are over one (1) year in age from the delinquency date shall be billed at a rate of 40% of all funds collected. Any claim, regardless of age, with a balance owed under $1,000.00 shall be billed at a rate of 50% of all funds collected. Any and all fees incurred during the collections process shall be passed to the client. Any claim that is forwarded to an affiliated attorney of DCW shall be billed at a rate of 50%. DCW is entitled to their full commission due on any payment(s) received, regardless of payer or whether paid to DCW or CLIENT once the claim is submitted.

6. Any merchandise returned to CLIENT by Debtor shall entitle DCW to a commission equal to 10% of the actual invoiced amount.

7. Any claim placed with DCW by CLIENT that is discovered to have been previously paid or placed by CLIENT in error will be billed by DCW to Client at a rate of 10% of the placed amount as an administrative, clerical and initiation fee.

8. CLIENT understands that DCW may, at their discretion, forward a case or a claim to an outside law firm or collection network to assist in the recovery of said claim, and hereby grants DCW permission to do so. It is further understood that CLIENT must give approval if such a transfer will result in additional charges.

9. DCW shall account to CLIENT monthly, all funds collected by DCW on CLIENT’S behalf and all remittances and/or invoices will be sent at this time.

10. CLIENT grants to DCW and to any affiliated attorney or collection firm that may be forwarded CLIENT claim(s) the express authority to endorse and negotiate any check, draft or other negotiable instrument made payable to CLIENT for deposit in trust for distribution to CLIENT after deducting the commission and fees due DCW under this agreement.

11. In no event shall DCW be liable in any respect for the inability to collect any claim placed by CLIENT for collection. It is understood and agreed that DCW is not a guarantor of any specific result on accounts placed by CLIENT.

12. DCW agrees and shall hold harmless CLIENT from any claim, demand, action, or judgment, including all reasonable legal fees arising out of any action done by DCW in connection with the collection of any claim(s) placed by CLIENT, which is not a result of a violation by CLIENT of any portion of provision 2.

13. This agreement shall be construed in accordance with the laws of the State of Florida. If any provision hereof is found to be invalid or unenforceable, then that provision shall be deemed to be severed and removed and the remaining provisions shall remain valid and in full effect.

                    </pre>
                  </div>
                  <div class="form-group">
                      <label>Signature</label>
                      <div class="signature-pad" id="signature-pad">
                          <canvas></canvas>
                          <button type="button" class="btn btn-secondary btn-sm" id="clear">Clear</button>
                      </div>
                      <input type="hidden" name="signature" id="signature-input">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
                  
                  <p class="mt-3" style="font-size: xx-small;">
                    BY EXECUTING THIS AGREEMENT CLIENT UNDERSTANDS THAT THE FILE IS BEING PLACED FOR COLLECTIONS. CLIENT UNDERSTANDS THAT DCW WILL USE THEIR BEST EFFORTS TO SECURE PAYMENT ON THEIR BEHALF AND WILL DIRECT ALL COMMUNICATIONS TO DCW.
                </p>
            </div>
          </div>
        </div>
      <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
      <script src="js/start-script.js"></script>


  <footer class="ftco-footer img" style="background-image: url(images/bg_1.jpg);">
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
    function toggleMenu() {
        var menu = document.querySelector('.nav-menu');
        menu.classList.toggle('open');
    }
  </script>


    
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/tiny-slider.js"></script>
      <script src="js/glightbox.min.js"></script>
      <script src="js/aos.js"></script>
      <script src="js/datepicker.min.js"></script>
      <script src="js/main.js"></script>
    
  </body>
</html>
