<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/members" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm" enctype="multipart/form-data">
          <label for="member_name" class="form-label">Nama Anggota</label>
          <input type="text" class="form-control mb-3" id="member_name" name="member_name" autocomplete="off" required>

          <label for="member_position" class="form-label">Jabatan</label>
          <input type="text" class="form-control mb-3" id="member_position" name="member_position" autocomplete="off" required>
          
          <label for="member_job" class="form-label">Tugas Pokok Fungsi</label>
          <textarea class="form-control mb-3" name="member_job" id="member_job" required></textarea>

          <label for="member_image" class="form-label">Foto</label>
          <input type="file" class="form-control mb-3" id="member_image" name="member_image" accept="image/jpg,jpeg,png">

          <button type="submit" class="btn btn-primary btn-sm float-end" id="btnSave">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#member_position').on('keyup', () => {
    $.ajax({
      url: '<?= BASEURL . "/members/checkDuplicate" ?>',
      type: 'POST',
      data: $('#myForm').serialize(),
      success: function(res) {
        if(res) {
          Swal.fire({
            icon: 'error',
            title: $('#member_position').val() + ' sudah terdaftar !',
            showConfirmButton: true,
          });
          $('#btnSave').prop('disabled', true);
        } else {
          $('#btnSave').prop('disabled', false);
        }
      }
    });
  });

  $('#myForm').on('submit', (e) => {
    e.preventDefault();
    const fileInput = $('#member_image')[0].files[0];

    let formData = new FormData();
    formData.append('member_name', $('#member_name').val());
    formData.append('member_position', $('#member_position').val());
    formData.append('member_job', $('#member_job').val());
    formData.append('member_name', $('#member_name').val());
    formData.append('member_image', fileInput);
    
    
    $.ajax({
      url: '<?= BASEURL . "/members/create" ?>',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menambahkan anggota DKM',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/members" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan anggota DKM !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>