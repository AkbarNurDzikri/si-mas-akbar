<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/categories" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <label for="category_name" class="form-label">Nama Kategori</label>
          <input type="text" class="form-control mb-3" id="category_name" name="category_name" autocomplete="off" required>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
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
      data: $('#myForm').serialize(),
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

  $('#myForm').on('submit', (e) => {
    e.preventDefault();
    $.ajax({
      url: '<?= BASEURL . "/categories/create" ?>',
      type: 'POST',
      data: $('#myForm').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menambahkan category baru',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/categories" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan category baru !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>