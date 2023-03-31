<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/mom" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <label for="meeting_date" class="form-label">Tanggal Rapat</label>
          <input type="date" class="form-control mb-3" id="meeting_date" name="meeting_date">

          <label for="meeting_time" class="form-label">Waktu Rapat</label>
          <input type="time" class="form-control mb-3" id="meeting_time" name="meeting_time">

          <label for="meeting_room" class="form-label">Tempat Rapat</label>
          <input type="text" class="form-control mb-3" id="meeting_room" name="meeting_room">

          <label for="title" class="form-label">Judul Rapat</label>
          <input type="text" class="form-control mb-3" id="title" name="title">

          <label for="body" class="form-label">Isi Rapat</label>
          <div id="quillEditor" class="mb-3">
            <!-- user write here -->
          </div>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const quill = new Quill('#quillEditor', {
    theme: 'snow',
  });

  // console.log(quill)

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
    // $.ajax({
    //   url: '<?= BASEURL . "/categories/create" ?>',
    //   type: 'POST',
    //   data: $('#myForm').serialize(),
    //   success: function(res) {
    //     if(res == 'success') {
    //       Swal.fire({
    //         icon: 'success',
    //         title: 'Berhasil menambahkan category baru',
    //         showConfirmButton: true,
    //       }).then(() => {
    //         window.location = '<?= BASEURL . "/categories" ?>'
    //       });
    //     } else {
    //       Swal.fire({
    //         icon: 'error',
    //         title: 'Gagal menambahkan category baru !',
    //         text: res,
    //         showConfirmButton: true,
    //       })
    //     }
    //   }
    // });
    console.log(quill.container.innerHTML);
  });
</script>