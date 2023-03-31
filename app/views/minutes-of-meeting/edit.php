<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/categories" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['category']['id'] ?>">
          <label for="category_name" class="form-label">Nama Kategori</label>
          <input type="text" class="form-control mb-3" id="category_name" name="category_name" value="<?= $data['category']['category_name'] ?>" autocomplete="off" required>

          <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#category_name').on('keyup', () => {
    $.ajax({
      url: '<?= BASEURL . "/categories/checkDuplicate" ?>',
      type: 'POST',
      data: $('#formEdit').serialize(),
      success: function(res) {
        if(res) {
          Swal.fire({
            icon: 'error',
            title: $('#category_name').val() + ' sudah terdaftar !',
            showConfirmButton: true,
          });
          $('.btn').prop('disabled', true);
        } else {
          $('.btn').prop('disabled', false);
        }
      }
    });
  });
  
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    $.ajax({
      url: '<?= BASEURL . '/categories/update/' ?>',
      type: 'POST',
      data: $('#formEdit').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah category',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/categories" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah category ',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>