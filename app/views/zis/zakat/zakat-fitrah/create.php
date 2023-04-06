<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/zakat" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <label for="person_status" class="form-label mt-3">Status</label>
          <select name="person_status" id="person_status" class="form-select mb-3" required>
            <option value="" disabled selected>Pilih Status</option>
            <option value="Muzakki">Muzakki</option>
            <option value="Fakir">Fakir</option>
            <option value="Miskin">Miskin</option>
            <option value="Amil">Amil</option>
            <option value="Mualaf">Mualaf</option>
            <option value="Riqab">Riqab</option>
            <option value="Gharimin">Gharimin</option>
            <option value="Fisabilillah">Fisabilillah</option>
            <option value="Ibnu Sabil">Ibnu Sabil</option>
          </select>

          <label for="person_name" class="form-label" id="labelPersonName">Nama</label>
          <input type="text" class="form-control mb-3" name="person_name" id="person_name" required>

          <label for="person_address" class="form-label">Alamat</label>
          <textarea name="person_address" id="person_address" class="form-control mb-3" placeholder="Perum MAP Blok UU No. 20" required></textarea>

          <label for="zakat_type" class="form-label">Jenis Zakat</label>
          <select name="zakat_type" id="zakat_type" class="form-select mb-3" required>
            <option value="" disabled selected>Pilih Jenis Zakat</option>
            <option value="Uang">Uang</option>
            <option value="Beras">Beras</option>
          </select>
          
          <label for="qty" class="form-label" id="labelPersonName">Jumlah</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="labelRupiah" style="display: none;">Rp. </span>
            <input type="number" class="form-control" id="inputQty" step="0.01" required>
            <span class="input-group-text" id="labelKilo" style="display: none;">Kg</span>
          </div>

          <label for="remarks" class="form-label">Keterangan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Opsional"></textarea>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#person_status').on('change', () => {
    if($('#person_status').val() == 'Muzakki') {
      $('#labelPersonName').html('Nama Muzakki');
      $('#inputQty').attr('name', 'qty_in');
    } else {
      $('#labelPersonName').html('Nama Mustahik');
      $('#inputQty').attr('name', 'qty_out');
    }
  });
  
  $('#zakat_type').on('change', () => {
    if($('#zakat_type').val() == 'Uang') {
      $('#labelRupiah').show();
      $('#labelKilo').hide();
    } else {
      $('#labelKilo').show();
      $('#labelRupiah').hide();
    }
  });

  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#myForm').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/zakat/createFitrah" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menambahkan zakat baru',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/zakat/fitrah" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan zakat baru !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>