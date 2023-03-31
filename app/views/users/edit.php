<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/users" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">
          
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control mb-3" id="username" name="username" value="<?= $data['user']['username'] ?>" autocomplete="off">

          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control mb-3" id="email" name="email" value="<?= $data['user']['email'] ?>" autocomplete="off">

          <label for="role_id" class="form-label">Hak Akses</label>
          <select name="role_id" id="role_id" class="form-select mb-3">
            <option value="<?= $data['user']['role_id'] ?>"><?= $data['user']['role_name'] ?></option>
            <option value="" disabled>Pilih Hak Akses</option>
            <?php foreach($data['roles'] as $role) : ?>
              <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
            <?php endforeach; ?>
          </select>

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
              title: 'Berhasil merubah users',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/users" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal merubah users',
              text: res,
              showConfirmButton: true,
            })
          }
        }
      });
    }
  });
</script>