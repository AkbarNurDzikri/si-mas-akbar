<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/roles" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <label for="role_name" class="form-label">Nama Hak Akses</label>
          <input type="text" class="form-control mb-3" id="role_name" name="role_name" autocomplete="off">

          <label for="remarks" class="form-label">Keterangan</label>
          <input type="text" class="form-control mb-3" id="remarks" name="remarks" autocomplete="off">

          <button type="submit" class="btn btn-primary btn-sm float-end btnSave">Save</button>
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
      data: $('#myForm').serialize(),
      success: function(res) {
        if(res) {
          Swal.fire({
            icon: 'error',
            title: $('#role_name').val() + ' sudah terdaftar !',
            showConfirmButton: true,
          });
          $('.btnSave').prop('disabled', true);
        } else {
          $('.btnSave').prop('disabled', false);
        }
      }
    });
  });

  $('#myForm').on('submit', (e) => {
    e.preventDefault();
    
      $.ajax({
      url: '<?= BASEURL . "/roles/create" ?>',
      type: 'POST',
      data: $('#myForm').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil membuat role',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/roles" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal membuat role !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>