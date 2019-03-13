<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/

$nomepagina="Welcome";

session_start();

include(__DIR__ ."/inc/cfg.php");

if(isset($_SESSION['logged'])&&$_SESSION['logged']=="in"){
	header ("Location: home.php");
}

echo $header;
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
  </head>
  <body>

    <div class="container" id="page">

			<?php echo $navbar; ?>

			<div class="row">
				<div class="col">
					<center>
						<h3>Welcome to CSV2Chart!</h3>
						<h5>Login to continue.</h5>
						<small>Use the same username and password you use to login to EEE elog.</small>
					</center>
				</div>
			</div>

			<div class="login row">
				<div class="login-form col">
          <form name=form1 method="POST" action="api/validate.php<?php if(isset($_GET['redirect'])){echo"?redirect=".$_GET['redirect'];} ?>" enctype="multipart/form-data">
						<?php if(isset($_GET['error'])) echo '<h5 style="color: #e74c3c;">Invalid username or password!</h5>'; ?>
  					<div class="form-group<?php if(isset($_GET['error'])) echo " has-error"; ?>">
  						<input type="text" class="form-control" value="" placeholder="Username" id="login-name" name="uname" />
  						<label class="login-field-icon fui-user" for="login-name"></label>
  					</div>

  					<div class="form-group<?php if(isset($_GET['error'])) echo " has-error"; ?>">
  						<input type="password" class="form-control" value="" placeholder="Password" id="login-pass" name="upassword"/>
  						<label class="login-field-icon fui-lock" for="login-pass"></label>
  					</div>
  					<button class="btn btn-primary btn-lg btn-block"><i class="fas fa-sign-in-alt"></i> Log in</button>
  					<!--a class="login-link" href="#">Lost your password?</a--> <!-- TODO -->
          </form>
				</div>
			</div>

    </div> <!-- /container -->

		<?php echo $footer; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="inc/scripts/flat-ui.js"></script>
		<script type="text/javascript">
			$("#homepage_nav").hide();
		</script>
  </body>
</html>
