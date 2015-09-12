<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Custom styles for this template -->
    <link href="assets/css/allStyle.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

        <div class="site-wrapper-inner">

          <div class="cover-container">

            <div class="masthead clearfix">
              <div class="inner">
                <h3 class="masthead-brand">My Site</h3>
                <nav>
                  <ul class="nav masthead-nav">
                    <li ><a href="/">Home</a></li>
                    <li class="active"><a href="/login.php">Login</a></li>
                    <li ><a href="/register.php">Register</a></li>
                  </ul>
                </nav>
              </div>
            </div>

            <div class="inner cover">


                <form class="form-signin" method="post" action='mylogin.php'>
                  <h2 class="form-signin-heading">Please Login</h2>
                  <label for="inputEmail" class="sr-only">Email address</label>
                  <input type="email" id="inputEmail" class="form-control"name='email' placeholder="Email address" required autofocus>
                  <label for="inputPassword" class="sr-only">Password</label>
                  <input type="password" id="inputPassword" class="form-control" name='password' placeholder="Password" required>
                  <button class="btn btn-lg btn-success btn-block" type="submit">Log in</button>
                </form>

            </div>

            <div class="mastfoot">
              <div class="inner">
                <p>Developer: Roop</p>
              </div>
            </div>

          </div>

        </div>

      </div>




    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  </body>
</html>
