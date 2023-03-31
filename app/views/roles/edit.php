<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/roles" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['role']['id'] ?>">
          
          <label for="role_name" class="form-label">Nama Hak Akses</label>
          <input type="text" class="form-control mb-3" id="role_name" name="role_name" value="<?= $data['role']['role_name'] ?>" autocomplete="off">

          <label for="remarks" class="form-label">Keterangan</label>
          <input type="text" class="form-control mb-3" id="remarks" name="remarks" value="<?= $data['role']['remarks'] ?>" autocomplete="off">

          <button type="submit" class="btn btn-primary btn-sm float-end btnUpdate">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#role_name').on('keyup', () => {
    $.ajax({
      url: '<?= BASEURL . "/roles/checkDuplicate" ?>',
      type: 'POST',
      data: $('#formEdit').serialize(),
      success: function(res) {
        if(res) {
          Swal.fire({
            icon: 'error',
            title: $('#role_name').val() + ' sudah terdaftar !',
            showConfirmButton: true,
          });
          $('.btnUpdate').prop('disabled', true);
        } else {
          $('.btnUpdate').prop('disabled', false);
        }
      }
    });
  });

  $('#formEdit').on('submit', (e) => {
    e.preventDefault();
    
    $.ajax({
      url: '<?= BASEURL . '/roles/update' ?>',
      type: 'POST',
      data: $('#formEdit').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah role',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/roles" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah role',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>