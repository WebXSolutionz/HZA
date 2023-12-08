<?php

session_start();
$_SESSION;

include("Config.php");


if(isset($_SESSION["user_name"]))
{
  header("Location: single-comp-search.php");
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

$username = $_POST['uname'];
$useremail = $_POST['uemail'];
$userpass = $_POST['upassword'];
$userconpass = $_POST['uconpass'];


if (!empty($username) && !empty($useremail) && !empty($userpass) && !empty($userconpass)) {

  if($userpass == $userconpass)
  {

    $hashPass = password_hash($userpass, PASSWORD_DEFAULT);

    try {
      $select_stmt = $pdo->prepare("SELECT user_name, user_email FROM user_data 
										WHERE user_name=:uname OR user_email=:uemail"); // sql select query
      $select_stmt->execute(array(
        ':uname' => $username,
        ':uemail' => $useremail
      )); //execute query

      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($select_stmt->rowCount() > 0) {
      
        if ($row["user_name"] == $username) {
          $errorMsg[] = "The username already exists"; //check condition username already exists
        } else if ($row["user_email"] == $useremail) {
          $errorMsg[] = "This email is already registered"; //check condition email already exists
        }

      }

      else
      {

          $insert_stmt = $pdo->prepare("INSERT INTO user_data(user_name, user_email, user_password) VALUES (?,?,?)"); //sql insert query
          if ($insert_stmt->execute([$username,$useremail,$hashPass])) {
    
            //$registerMsg = "Registered Successfully..."; //execute query success message
            header("Location: index.php");

        }
      }
      
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
       
  }
  else
  {
    $errors = "Password don't match";
  }

}
else
{
  $errors = "Please fill out all fields.";
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
    <main>
      <!-- Section -->
      <section class="vh-lg-100 vh-100 mt-lg-0 bg-soft d-flex align-items-center" id="signinbg">
        <div class="container">
          <div class="row justify-content-center form-bg-image" data-background-lg="../../assets/img/illustrations/signin.svg">
            <div class="col-12 d-flex align-items-center justify-content-center">
              <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                <div class="text-center text-md-center mb-4 mt-md-0">
                  <h1 class="mb-0 h3">Create Account</h1>
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

<?php if (isset($errors))
                {
                ?>
			            <div class="alert alert-danger text-center py-1 my-2">
				          <strong><?php echo $errors; ?></strong>
			            </div>
                  <?php
                }
                ?>

                <form class="mt-4" method = "post">
                  <!-- Form -->
                  <div class="form-group mb-4">
                    <label for="name">Your Username</label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon1">
                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                      </span>
                      <input type="text" class="form-control" placeholder="Username" id="name" name="uname" autofocus required />
                    </div>
                  </div>
                  <!-- End of Form -->
                   <!-- Form -->
                   <div class="form-group mb-4">
                    <label for="email">Your Email</label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon1">
                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                      </span>
                      <input type="email" class="form-control" placeholder="example@company.com" id="email" name="uemail" required />
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
                        <input type="password" placeholder="Password" class="form-control" id="password" name="upassword" required />
                      </div>
                    </div>
                    <!-- End of Form -->
                    <!-- Form -->
                    <div class="form-group mb-4">
                      <label for="confirm_password">Confirm Password</label>
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">
                          <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        </span>
                        <input type="password" placeholder="Confirm Password" class="form-control" id="confirm_password" name="uconpass" required />
                      </div>
                    </div>
                    <!-- End of Form -->
                    <div class="mb-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember" required/>
                        <label class="form-check-label fw-normal mb-0" for="remember"> I agree to the <a href="#" class="fw-bold">terms and conditions</a> </label>
                      </div>
                    </div>
                  </div>
                  <div class="d-grid">
                    <button type="submit" class="btn btn-gray-800">Sign up</button>
                  </div>
                </form>

                <div class="d-flex justify-content-center align-items-center mt-4">
                  <span class="fw-normal">
                    Already have an account?
                    <a
                      href="index.php
                    "
                      class="fw-bold"
                      >Login here</a
                    >
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
