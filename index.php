<?php

session_start();
$_SESSION;

include("Config.php");


if(isset($_SESSION["user_name"]))
{
  header("Location: single-comp-search.php");
}

if ($_SERVER['REQUEST_METHOD'] === "POST")
{

  $username = $_POST['uname'];
  $userpass = $_POST['upassword'];

  try
    {

    $select_stmt=$pdo->prepare("SELECT * FROM user_data WHERE user_name=:uname");
		$select_stmt->execute(array(':uname'=>$username));
    $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

    if($select_stmt->rowCount() > 0)	//check condition database record greater zero after continue
			{
				if($username==$row["user_name"])
				{
					if(password_verify($userpass, $row["user_password"]))
					{
						$_SESSION["user_name"] = $row["user_name"];	//session name is "user_login"
						$loginMsg = "Successfully Logged In...";		//user login success message
						header("location: single-comp-search.php");			//refresh 2 second after redirect to "welcome.php" page
					}
					else
					{
						$errorMsg[]="Wrong Password";
					}
				}
				else
				{
					$errorMsg[]="Wrong Username or Email";
				}
			}
			else
			{
				$errorMsg[]="Wrong Username or Email";
			}
    }
    catch(PDOException $e)
		{
			$e->getMessage();
		}


}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>HANKZARIHS Associates</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/logo/Favicon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo/Favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/logo/Favicon.png" />
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link type="text/css" href="css/volt.css" rel="stylesheet" />
  </head>

  <body>
    <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

    <main>
      <!-- Section -->
      <section class="vh-lg-100 vh-100 mt-lg-0 bg-soft d-flex align-items-center" id="signinbg">
        <div class="container">
          <div class="row justify-content-center form-bg-image" data-background-lg="../../assets/img/illustrations/signin.svg">
            <div class="col-12 d-flex align-items-center justify-content-center">
              <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                <div class="text-center text-md-center mb-4 mt-md-0">
                  <!--<h1 class="mb-0 h3">Sign in to our platform</h1>-->
                  <a href="single-comp-search.php">
              <img src="assets/img/logo/LOGO.png" alt="Volt Logo">

              <!-- <span class="mt-1 ms-1 sidebar-text">Volt Overview</span> -->
            </a>
                </div>

                <?php
                  if (isset($errorMsg))
                  {
                    foreach ($errorMsg as $error)
                    {
                ?>
				          <div class="alert alert-danger text-center py-1 my-2">
					        <strong><?php echo $error; ?></strong>
				          </div>
                <?php
                    }
                  }
                  ?>

                <form method="post" class="mt-4">
                  <!-- Form -->
                  <div class="form-group mb-4">
                    <label for="email">Your Username</label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon1">
                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                      </span>
                      <input type="text" class="form-control" placeholder="Username" id="name" name = "uname" autofocus required />
                    </div>
                  </div>
                  <!-- End of Form -->
                  <div class="form-group">
                    <!-- Form -->
                    <div class="form-group mb-4">
                      <label for="password">Your Password</label>
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">
                          <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        </span>
                        <input type="password" placeholder="Password" class="form-control" id="password" name = "upassword" required />
                      </div>
                    </div>
                    <!-- End of Form -->
                    <div class="d-flex justify-content-between align-items-top mb-4">
                      <!-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember" />
                        <label class="form-check-label mb-0" for="remember"> Remember me </label>
                      </div> -->
                      <div class="ms-auto"><a href="forgot-password.php" class="small text-right">Lost password?</a></div>
                    </div>
                  </div>
                  <div class="d-grid">
                    <button type="submit" class="btn btn-gray-800">Sign in</a>
                  </div>
                </form>

                <div class="d-flex justify-content-center align-items-center mt-4">
                  <span class="fw-normal">
                    Not registered?
                    <a href="sign-up.php" class="fw-bold">Create account</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
<!-- js files -->
    <script src="../../vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
