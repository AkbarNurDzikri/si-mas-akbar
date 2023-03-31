<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/members" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['member']['id'] ?>">
          <label for="member_name" class="form-label">Nama Anggota</label>
          <input type="text" class="form-control mb-3" id="member_name" name="member_name" autocomplete="off" value="<?= $data['member']['member_name'] ?>" required>

          <label for="member_position" class="form-label">Jabatan</label>
          <input type="text" class="form-control mb-3" id="member_position" name="member_position" autocomplete="off" value="<?= $data['member']['member_position'] ?>" required>
          
          <label for="member_job" class="form-label">Tugas Pokok Fungsi</label>
          <textarea class="form-control mb-3" name="member_job" id="member_job" required><?= $data['member']['member_job'] ?></textarea>

          <label for="member_image" class="form-label" id="labelImage" style="display: none;">Foto</label>
          <input type="hidden" class="form-control mb-3" id="member_image" name="member_image" accept="image/jpg,jpeg,png" value="<?= $data['member']['member_image'] ?>">

          <img src="<?= BASEURL . '/assets/images/dkm/members/' . $data['member']['member_image'] ?>" alt="member-photo" class="w-25 memberImage" style="display: block;">
          <a href="#" class="badge rounded-pill text-bg-primary" id="changeImage"><i class="bi bi-cloud-upload"></i> Ganti Foto</a>
          <a href="#" class="badge rounded-pill text-bg-primary" id="undoChangeImage" style="display: none;"><i class="bi bi-arrow-counterclockwise"></i> Batal</a>

          <button type="submit" class="btn btn-primary btn-sm float-end" id="btnUpdate">Update</button>
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
      data: $('#formEdit').serialize(),
      success: function(res) {
        if(res) {
          Swal.fire({
            icon: 'error',
            title: $('#member_position').val() + ' sudah terdaftar !',
            showConfirmButton: true,
          });
          $('#btnUpdate').prop('disabled', true);
        } else {
          $('#btnUpdate').prop('disabled', false);
        }
      }
    });
  });

  $('#changeImage').on('click', () => {
    $('#labelImage').show();
    $('#member_image').removeAttr('value');
    $('#member_image').attr('type', 'file');
    $('#member_image').attr('required', true);
    $('.memberImage').hide();
    $('#changeImage').hide();
    $('#undoChangeImage').show();
  });

  $('#undoChangeImage').on('click', () => {
    $('#labelImage').hide();
    $('#member_image').attr('value', '<?= $data['member']['member_image'] ?>');
    $('#member_image').attr('type', 'hidden');
    $('#member_image').removeAttr('required');
    $('.memberImage').show();
    $('#changeImage').show();
    $('#undoChangeImage').hide();
  });
  
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();
    
    if($('#member_image').attr('type') == 'file') {
      const fileInput = $('#member_image')[0].files[0];
      let formData = new FormData();
      formData.append('id', <?= $data['member']['id'] ?>);
      formData.append('member_name', $('#member_name').val());
      formData.append('member_position', $('#member_position').val());
      formData.append('member_job', $('#member_job').val());
      formData.append('member_name', $('#member_name').val());
      formData.append('member_imageOld', '<?= $data['member']['member_image'] ?>');
      formData.append('member_image', fileInput);
      $.ajax({
        url: '<?= BASEURL . '/members/update' ?>',
        type: 'POST',
        contentType: false,
        processData: false,
        data: formData,
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil merubah anggota',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/members" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal merubah anggota',
              text: res,
              showConfirmButton: true,
            })
          }
        }
      });
    } else {
      $.ajax({
        url: '<?= BASEURL . '/members/update/' ?>',
        type: 'POST',
        data: $('#formEdit').serialize(),
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil merubah anggota',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/members" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal merubah anggota ',
              text: res,
              showConfirmButton: true,
            })
          }
        }
      });
    }
  });
</script>