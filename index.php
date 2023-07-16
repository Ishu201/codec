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
        margin-top:-370px;
      }
      .alert-logindanger{
        background-color: rgb(230, 0, 0,.8);
        color:white
      }

      .alert-loginsuccess{
        background-color: #39ac73;
        color:white
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
              <h3>Login to <strong style="color:#009999">Codec</strong></h3>
              <p style="color:red;" id="error"></p>
              <?php
              //If there is an error
              if (isset($_REQUEST['msg'])) {
                $msg = base64_decode($_REQUEST['msg']);
                if ($msg == 'Wait Until Your Account is Activated') {
                  echo '<div class="alert alert-loginsuccess" role="alert" id="alertError">';
                    echo $msg;
                  echo '</div>';
                } else {
                  echo '<div class="alert alert-logindanger" role="alert" id="alertError">';
                    echo $msg;
                  echo '</div>';
                }
              }
              ?>
              </div>
              <form action="view/controller/logincontroller.php" method="post">
                <div class="form-group first">
                  <label for="username">Username <span>*</span> </label>
                  <input type="text" class="form-control" placeholder="your Usermail" id="username" name="username" required>
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Password <span>*</span> </label>
                  <input type="password" class="form-control" placeholder="Your Password" id="password" name="password" required>
                </div>

                <div class="d-sm-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">Remember me</span>
                    <input type="checkbox" checked="checked"/>
                    <div class="control__indicator"></div>
                  </label>
                  <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                </div>

                <input type="submit" value="Log In" class="btn btn-block btn-info" style="background-color:#009999">
              </form><br>
              <center> Dont have an Account ..? <a href="register.php">Register Here</a></center>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcPZYciAAAAAO8FAEnnh_5MklHnSeOcyUD-wCI8"></script>
  <script>
  grecaptcha.enterprise.ready(function() {
      grecaptcha.enterprise.execute('6LcPZYciAAAAAO8FAEnnh_5MklHnSeOcyUD-wCI8', {action: 'login'}).then(function(token) {
         ...
      });
  });
  </script>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('form').submit(function () {
                var username = $('#username').val();
                var pass = $('#password').val();
                var errorMessage = $('#error');
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

            });

            $("#alertError").show().delay(4000).fadeOut();
        });
    </script>

    <script src="vendor/asset/js/jquery-3.3.1.min.js"></script>
    <script src="vendor/asset/js/popper.min.js"></script>
    <script src="vendor/asset/js/bootstrap.min.js"></script>
    <script src="vendor/asset/js/main.js"></script>
  </body>
</html>
