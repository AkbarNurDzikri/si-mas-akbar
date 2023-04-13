<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Al-Akbar SysAdmin | Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= BASEURL . '/assets/images/icons/Foto-Masjid-Depan.ico' ?>" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Vendor Javascript Files -->
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="<?= BASEURL ?>/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.js"></script>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <main>
    <div class="container-fluid bg-success">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card border-white mb-3">
              <div class="card-header bg-success">
                <marquee class="text-white">
                  <h5>السَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ</h5>
                </marquee>
              </div>
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">SI MAS AKBAR</h5>
                    <p class="text-center small">Sistem Informasi Masjid Al-Akbar</p>
                  </div>

                  <form class="row g-3 needs-validation" id="myForm">
                    <div class="col-12">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="showPassword">
                        <label class="form-check-label" for="showPassword">Show Password</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-success w-100" type="submit" id="btnLogin">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <script src="<?= BASEURL ?>/assets/dashboard/vendor/datatables/jQuery-3.6.0/jquery-3.6.0.min.js"></script>
  <script>
    $('#showPassword').on('click', () => {
      if($('#password').attr('type') == 'password') {
        $('#password').attr('type', 'text');
      } else {
        $('#password').attr('type', 'password');
      }
    });

    $('#myForm').on('submit', (e) => {
      e.preventDefault();

      $.ajax({
        url: '<?= BASEURL . "/auth/checkCredentials" ?>',
        type: 'POST',
        data: $('#myForm').serialize(),
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil login ..',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/zakat_fitrah/uang" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Username atau password salah !',
              showConfirmButton: true,
            })
          }
        }
      });
    });
  </script>
</body>
</html>