<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-body mt-3">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['member']['id'] ?>">
          
          <div class="text-center">
            <h1 class="text-center"><?= $data['member']['member_name'] ?></h1>
            <img src="<?= BASEURL . '/assets/images/dkm/members/' . $data['member']['member_image'] ?>" alt="member-photo" class="mt-3 w-75 img-thumbnail rounded memberImage">
          </div>
          <div class="text-center">
            <p class="badge rounded-pill text-bg-success" id="changeImage"><i class="bi bi-cloud-upload"></i> Ganti Foto</p>
            <input type="hidden" class="mt-3 form-control" id="member_image" name="member_image" accept="image/jpg,jpeg,png" value="<?= $data['member']['member_image'] ?>">
            <p class="badge rounded-pill text-bg-secondary" id="undoChangeImage" style="display: none;"><i class="bi bi-arrow-counterclockwise"></i> Batal</p>
          </div>

          <h5 class="text-center"><?= $data['member']['member_position'] ?></h5>
          <p class="text-center text-muted" style="margin-top: -10px;"><?= $data['member']['member_job'] ?></p>

          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-sm" id="btnUpdate">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
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
      formData.append('member_name', '<?=$data['member']['member_name'] ?>');
      formData.append('member_position', '<?=$data['member']['member_position'] ?>');
      formData.append('member_job', '<?=$data['member']['member_job'] ?>');
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
              title: 'Berhasil merubah profile',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/users/profile/" . $data['member']['id'] ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal merubah profile',
              text: 'Kode Kesalahan : ' + res,
              showConfirmButton: true,
            })
          }
        }
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Foto tidak terdeteksi !',
        text: 'Silahkan pilih foto dulu',
        showConfirmButton: true,
      })
    }
  });
</script>