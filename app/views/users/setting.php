<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">
          <input type="hidden" name="member_id" value="<?= $data['user']['member_id'] ?>">
          
          <label for="username" class="form-label mt-3">Username</label>
          <input type="text" class="form-control mb-3" id="username" name="username" value="<?= $data['user']['username'] ?>" autocomplete="off">

          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control mb-3" id="email" name="email" value="<?= $data['user']['email'] ?>" autocomplete="off">

          <div class="currentPassword">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control mb-3" id="password" name="password">
          </div>

          <div class="createNewPassword" style="display: none;">
            <label for="newPassword" class="form-label">Password Baru</label>
            <input type="password" class="form-control mb-3" id="newPassword" name="newPassword">

            <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control mb-3" id="confirmPassword" name="confirmPassword">
          </div>

          <button type="button" class="btn btn-primary btn-sm float-end checkPassword">Check Password</button>
          <button type="submit" class="btn btn-primary btn-sm float-end btnUpdate" style="display: none;">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('.checkPassword').on('click', () => {
    $.ajax({
      url: '<?= BASEURL . '/users/checkPassword/' ?>',
      type: 'POST',
      data: $('#formEdit').serialize(),
      success: function(res) {
        if(res == false) {
          Swal.fire({
            icon: 'error',
            title: 'Password salah !',
            text: 'Masukkan password lama Anda',
            showConfirmButton: true,
          });
        } else {
          Swal.fire({
            icon: 'success',
            title: 'Password diterima',
            showConfirmButton: true,
          }).then(() => {
            $('.checkPassword').hide();
            $('.btnUpdate').show();
            $('.currentPassword').hide();
            $('.createNewPassword').show();
          });
        }
      }
    });
  });

  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    if($('#newPassword').val().length < 6) {
      Swal.fire({
        icon: 'error',
        title: 'Minimal password 6 karakter !',
        showConfirmButton: true,
      });
    } else if($('#confirmPassword').val() !== $('#newPassword').val()) {
      Swal.fire({
        icon: 'error',
        title: 'Konfirmasi password tidak sesuai !',
        showConfirmButton: true,
      });
    } else {
      $.ajax({
        url: '<?= BASEURL . '/users/changeCredentials' ?>',
        type: 'POST',
        data: $('#formEdit').serialize(),
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil merubah kredensial Anda',
              text: 'Silahkan login kembali',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/auth/logout" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal merubah kredensial',
              text: res,
              showConfirmButton: true,
            })
          }
        }
      });
    }
  });
</script>