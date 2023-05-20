<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/users" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">
          
          <label for="member_id" class="form-label mt-3">Anggota DKM</label>
          <select name="member_id" id="member_id" class="form-select mb-3">
            <option value="<?= $data['user']['member_id'] ?>" selected><?= $data['user']['member_name'] ?></option>
            <!-- tidak diberi option lagi karena nama anggota dkm tidak perlu diganti, edit ini hanya untuk ganti hak akses saja -->
          </select>
          
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control mb-3" id="username" name="username" value="<?= $data['user']['username'] ?>" autocomplete="off">

          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control mb-3" id="email" name="email" value="<?= $data['user']['email'] ?>" autocomplete="off">

          <label for="role_id" class="form-label">Hak Akses</label>
          <select name="role_id" id="role_id" class="form-select mb-3" required>
            <option value="<?= $data['user']['role_id'] ?>" selected><?= $data['user']['role_name'] ?></option>
            <option value="" disabled>Pilih Hak Akses</option>
            <?php foreach($data['roles'] as $role) : ?>
              <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
            <?php endforeach; ?>
          </select>
          
          <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    $.ajax({
      url: '<?= BASEURL . '/users/changeAccessDoor' ?>',
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
  });
</script>