<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/committees" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <div id="boxPanitia">
            <div class="inputPanitia">
              <h6 class="text-muted" id="titlePanitia1">Panitia #1</h6>
              
              <label for="personName1" class="form-label mt-3" id="labelpersonName1">Nama Panitia</label>
              <input type="text" class="form-control mb-3" id="personName1" name="panitia[person_name][1]" placeholder="Syaipul Nur" autocomplete="off" required>
              
              <label for="position1" class="form-label" id="labelposition1">Jabatan</label>
              <input type="text" class="form-control mb-3" id="position1" name="panitia[position][1]" placeholder="Ketua" autocomplete="off" required>

              <label for="duties1" class="form-label" id="labelduties1">Tupoksi</label>
              <textarea class="form-control mb-3" name="panitia[main_duties_and_functions][1]" id="duties1" placeholder="Melaporkan progress tanggung jawab kepada ketua .." required></textarea>
            </div>
          </div>

          <button type="button" class="btn btn-sm btn-primary" onclick="addCommittee()">+ Panitia</button>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#titlePanitia1').hide();

  const addCommittee = () => {
    let itemNum = document.querySelectorAll('#boxPanitia>.inputPanitia').length + 1;
    
    if(itemNum > 1) {
      $('#titlePanitia1').show();
    }

    const html = `
      <div class="inputPanitia" id="panitiaInput${itemNum}">
        <h6 class="text-muted" id="titlePanitia${itemNum}">Panitia #${itemNum} | <a href="javascript:deletePanitia(${itemNum})" class="text-danger"><i class="bi bi-trash3"></i> Hapus</a></h6>
        <label for="personName${itemNum}" class="form-label" id="labelpersonName${itemNum}">Nama Panitia</label>
        <input type="text" class="form-control mb-3" id="personName${itemNum}" name="panitia[person_name][${itemNum}]" placeholder="Syaipul Nur" autocomplete="off" required>
        
        <label for="position${itemNum}" class="form-label" id="labelposition${itemNum}">Jabatan</label>
        <input type="text" class="form-control mb-3" id="position${itemNum}" name="panitia[position][${itemNum}]" placeholder="Ketua" autocomplete="off" required>

        <label for="duties${itemNum}" class="form-label" id="labelduties${itemNum}">Tupoksi</label>
              <textarea class="form-control mb-3" name="panitia[main_duties_and_functions][${itemNum}]" id="duties${itemNum}" placeholder="Melaporkan progress tanggung jawab kepada ketua .." required></textarea>
      </div>
    `;
    $('#boxPanitia').append(html);
  };

  const deletePanitia = (id) => {
    let itemNum = document.querySelectorAll('#boxPanitia>.inputPanitia').length;
    $('#panitiaInput' + id).remove();
  };

  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#myForm').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/committees/create/" . $data['eventId'] ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menambahkan panitia baru',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/committees" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan panitia baru !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>