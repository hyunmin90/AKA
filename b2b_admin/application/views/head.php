<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">   

    <title>Administrator</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/jumbotron.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/signin.css" rel="stylesheet">
    <link href="/css/bootstrap-datepicker.css" rel="stylesheet">
    
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>
    <script src="/js/jquery-1.11.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-select.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/customize.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand font-white" href="/">Administrator</a><div id="logo"></div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <!-- Category -->
          <?php if($this->session->userdata('state')) {?>
          <form class="navbar-form navbar-right" role="form">
              <!--
              <img src="/images/logo_yonsei.png" style="width:35%; margin-right:10px;">
            -->
              <a href="/login/sign_out" class="btn btn-coupon-login">Logout</a>
            </form>
          <ul class="nav navbar-nav font-white">
              <li <?php if($page == 'coupon') echo ' class="active"';?>><a href="/coupon">Coupon</a></li>
              <li <?php if($page == 'user') echo ' class="active"';?>><a href="/user">Users</a></li>

            <?php if($this->session->userdata('user_name') == 'akaon') {?>
              <li <?php if($page == 'image') echo ' class="active"';?>><a href="/image">Image</a></li>
            <?php } ?>
          </ul>
            
            <?php }else { ?>
            <!-- Category end. -->
<!--
          <form class="navbar-form navbar-right" role="form">
            <div class="form-group">
              <input type="text" id="user_id" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" id="password" placeholder="Password" class="form-control">
            </div>
            <button id="sign_in" class="btn btn-coupon-login">Sign in</button>
            
          </form>
        -->
          <?php } ?>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
