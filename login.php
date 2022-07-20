<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.urbanui.com/melody/template/pages/samples/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Sep 2018 06:08:53 GMT -->

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>e-Saku Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="images/logo.svg" alt="logo">
              </div>
              <h4>Login disini !</h4>
              <h6 class="font-weight-light">Masukan Username dan Password</h6>
              <form class="pt-3" method="post" action="">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="user" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="pass" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="sukmasuk" type="submit">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Belum punya akun? <a href="#" class="text-primary">Buat akun</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>


<!-- Mirrored from www.urbanui.com/melody/template/pages/samples/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Sep 2018 06:08:53 GMT -->

</html>

<?php

include 'koneksi.php';
if (isset($_POST['sukmasuk'])) {

  $user = mysqli_real_escape_string($conn, $_POST['user']);
  $pass = mysqli_real_escape_string($conn, $_POST['pass']);

  $sql = mysqli_query($conn, "SELECT * FROM user WHERE username = '$user' ");

  if (mysqli_num_rows($sql) > 0) {
    $dt = mysqli_fetch_assoc($sql);
    if ($dt['aktif'] === 'Y') {
      if (password_verify($pass, $dt['password'])) {
        $_SESSION['qwertyuiop-esakau12038835883848854'] = true;
        $_SESSION['nama']  = $dt['nama'];
        $_SESSION['level']  = $dt['level'];

        echo "
                <script>
                window.location = 'index.php';
                </script>
                ";
      } else {
        echo "
                <script>
                alert('password tidak ditemukan');
                window.location = 'login.php';
                </script>
                ";
      }
    } else {
      echo "
                <script>
                alert('Maaf, Akun anda belum aktif');
                window.location = 'login.php';
                </script>
                ";
    }
  } else {
    echo "
            <script>
            alert('Usernase tidak ditemukan');
            window.location = 'login.php';
            </script>
            ";
  }
}

?>