<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="vendor/asset/fonts/icomoon/style.css">
    <link rel="stylesheet" href="vendor/asset/css/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/asset/css/style.css">


    <title>Welcome to CODEC</title>
    <link rel="icon" type="image/png" href="res/images/logoIcon.png">

    <style media="screen">
    body{
      overflow: hidden;
    }

    .control input:checked ~ .control__indicator {
      background: #00b3b3; }

    .control:hover input:not([disabled]):checked ~ .control__indicator,
    .control input:checked:focus ~ .control__indicator {
      background: #00b3b3; }

      .form-block{
        margin-top:-370px; codec-365804
      }
      .alert-logindanger{
        background-color: rgb(230, 0, 0,.8);
        color:white
      }

      .alert-loginsuccess{
        background-color: #39ac73;
        color:white
      }

      .alert-weak{
        color: #EB3333;
        padding:0px;
      }

      .alert-medium{
        color: #ffb366;
        padding:0px;
      }

      .alert-strong{
        color: #00cc99;
        padding:0px;
      }

    </style>

  </head>
  <body>


  <div class="half">
    <div class="bg order-1 order-md-2" style="height: 300px ;background-image: url('vendor/asset/images/ff.jpg');"></div>
    <div class="contents order-2 order-md-1"style="background-color:#e0ebeb !important">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6">
            <div class="form-block"style="margin-top:-460px">
              <div class="text-center mb-5">
                <h3>Register to <strong style="color:#2E6DBB">Codec</strong></h3>
                <p style="color:red;font-weight:bold" id="error"></p>
                <?php
                //If there is an error
                if (isset($_REQUEST['msg'])) {
                  $msg = base64_decode($_REQUEST['msg']);
                  if ($msg == 'Wait Until Your Account is Activated') {
                    $msg = base64_encode("Wait Until Your Account is Activated");
                    header("Location:index.php?msg='$msg'");
                  } else {
                    echo '<div class="alert alert-logindanger" role="alert" id="alertError">';
                      echo $msg;
                    echo '</div>';
                  }
                }
                ?>

                </div>
              <form action="view/controller/registercontroller.php" method="post">
                <div class="form-group first">
                  <label for="username">Username <span>*</span> </label>
                  <input type="email" class="form-control" placeholder="your Usermail" id="username" name="username" required>
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Password <span>*</span> </label>
                  <input type="password" class="form-control" placeholder="Your Password" id="password" name="password" required onkeyup="checkPasswordStrength();">
                </div>
                <div id="password-strength-status"></div>
                <input type="hidden" id="strength" value="not">

                <br><br>

                <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcPZYciAAAAAO8FAEnnh_5MklHnSeOcyUD-wCI8"></script>
                <script>
                grecaptcha.enterprise.ready(function() {
                    grecaptcha.enterprise.execute('6LcPZYciAAAAAO8FAEnnh_5MklHnSeOcyUD-wCI8', {action: 'login'}).then(function(token) {
                       ...
                    });
                });
                </script>

                <input type="submit" value="Register" class="btn btn-block btn-info" style="background-color:#2E6DBB;width:80%;margin:auto">
              </form> <br>
              <center> Already have an Account ..? <a href="index.php">Login Here</a></center>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('form').submit(function () {
                var username = $('#username').val();
                var pass = $('#password').val();
                var errorMessage = $('#error');
                var strength = $('#strength').val();
                if (strength == 'okay') {
                  //To check both email and password
                  if (username == "" && pass == "") {
                      errorMessage.show();
                      errorMessage.text("Please enter your email and password");
                      return false;
                  }
                  //To check empty email
                  if (username == "") {
                      errorMessage.show();
                      errorMessage.text("Please enter your Email address");
                      return false;
                  }
                  //To check empty password
                  if (pass == "") {
                      errorMessage.show();
                      errorMessage.text("Please enter your password");
                      return false;
                  }

                } else{
                  errorMessage.show();
                  errorMessage.text("Please enter a Strong Password");
                  return false;
                }

            });

            $("#alertError").show().delay(4000).fadeOut();
        });

        function checkPasswordStrength() {
	var number = /([0-9])/;
	var alphabets = /([a-zA-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	var password = $('#password').val().trim();
	if (password.length < 6) {
		$('#password-strength-status').removeClass();
		$('#password-strength-status').addClass('alert alert-weak');
		$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
    $('#strength').val("not");
	} else {
		if (password.match(number) && password.match(alphabets) && password.match(special_characters)) {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('alert alert-strong');
			$('#password-strength-status').html("Strong Password");
			$('#strength').val("okay");
		}
		else {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('alert alert-medium');
			$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
			$('#strength').val("okay");
		}
	}
}
    </script>

    <script src="vendor/asset/js/jquery-3.3.1.min.js"></script>
    <script src="vendor/asset/js/popper.min.js"></script>
    <script src="vendor/asset/js/bootstrap.min.js"></script>
    <script src="vendor/asset/js/main.js"></script>
  </body>
</html>
