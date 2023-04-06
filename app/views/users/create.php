<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/users" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <label for="member_id" class="form-label mt-3">Anggota DKM</label>
          <select name="member_id" id="member_id" class="form-select mb-3">
            <option value="" disabled selected>Pilih Anggota</option>
            <?php foreach($data['members'] as $member) : ?>
              <option value="<?= $member['id'] ?>"><?= $member['member_name'] ?></option>
            <?php endforeach; ?>
          </select>

          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control mb-3" id="username" name="username" autocomplete="off" required>

          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control mb-3" id="email" name="email" autocomplete="off" required>

          <label for="role_id" class="form-label">Hak Akses</label>
          <select name="role_id" id="role_id" class="form-select mb-3" required>
            <option value="" disabled selected>Pilih Hak Akses</option>
            <?php foreach($data['roles'] as $role) : ?>
              <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
            <?php endforeach; ?>
          </select>

          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control mb-3" id="password" name="password" required>

          <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control mb-3" id="confirmPassword" name="confirmPassword" required>

          <button type="submit" class="btn btn-primary btn-sm float-end btnSave">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    if($('#password').val().length < 6) {
      Swal.fire({
        icon: 'error',
        title: 'Minimal password 6 karakter !',
        showConfirmButton: true,
      });
    } else if($('#confirmPassword').val() !== $('#password').val()) {
      Swal.fire({
        icon: 'error',
        title: 'Konfirmasi password tidak sesuai !',
        showConfirmButton: true,
      });
    } else {
      $.ajax({
        url: '<?= BASEURL . "/users/create" ?>',
        type: 'POST',
        data: $('#myForm').serialize(),
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil membuat user',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/users" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal membuat user !',
              text: res,
              showConfirmButton: true,
            })
          }
        }
      });
    }
  });
</script>