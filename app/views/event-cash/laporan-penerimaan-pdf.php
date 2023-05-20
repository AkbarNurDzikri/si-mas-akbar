<?php
if(count($data['totalUangMasuk']) == 0) {
  echo 
  '<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Notif</title>
      <link href="' . BASEURL . '/assets/dashboard/css/style.css" rel="stylesheet">
      <link href="' . BASEURL . '/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.css" rel="stylesheet">
      <script src="' . BASEURL . '/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.js"></script>
    </head>
    <body>
      <script>
        Swal.fire({
          icon: "error",
          title: "Data tidak tersedia !",
          text: "Belum ada kas masuk pada acara yang Anda Pilih",
          showConfirmButton: true,
        }).then(() => {
          window.location = "' . BASEURL . '/event_cash"
        })
      </script>
    </body>
    </html>';
} else {
  require_once dirname(__DIR__, 3) . '/assets/dashboard/vendor/mpdf/autoload.php';

  $mpdf = new \Mpdf\Mpdf();
  $mpdf->SetFooter('{PAGENO}');
  $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Laporan Kas Masuk</title>
            </head>
            <body>
              <table style="margin-left: auto; margin-right: auto;">
                <tr>
                  <td rowspan="3"><img src="'. BASEURL . '/assets/images/icons/Foto Masjid Depan.jpeg' .'" style="width: 80px; margin-left: -70px; margin-right: 30px;"></td>
                </tr>
                <tr>
                  <td style="text-align: center;">
                    <h2 style="padding-bottom: -15px;">DEWAN KEMAKMURAN MASJID AL-AKBAR</h2>
                    <p style="padding-bottom: -15px;">Perumahan Mutiara Alam Permai - Dusun Babakan Ciranggon</p>
                    <p style="padding-bottom: -15px;">Desa Pasir Jengkol, Kec. Majalaya, Kab. Karawang, Prov. Jawa Barat</p>
                  </td>
                </tr>
              </table>

              <hr> <hr style="margin-top: -11px;">
              
              <h4 style="text-align: center;">Laporan Kas Masuk "' . $data['totalUangMasuk'][0]['event_name'] . '"</h4>
              <h4 style="text-align: center; padding-top: -15px;">Periode '. date('d M Y', strtotime($data['start_period'])) . ' s.d ' . date('d M Y', strtotime($data['end_period'])) .'</h4>

              <table border="1" style="border-collapse: collapse; margin-left: auto; margin-right: auto; margin: 20px 0 30px 0; width: 700px;">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Tgl, Jam</th>
                    <th>Keterangan</th>
                    <th>Rupiah</th>
                    <th>Diinput Oleh</th>
                  </tr>
                </thead>
                <tbody>';
                  $i = 1;
                  $totalUangMasuk = 0;
                  foreach($data['totalUangMasuk'] as $uangMasuk) :
                    $totalUangMasuk += $uangMasuk['qty_in'];
                    $html .= '<tr>';
                      $html .= '<td style="text-align: center;">'. $i++ .'</td>';
                      $html .= '<td style="text-align: center;">'. date('d/M/y, H:i', strtotime($uangMasuk['created_at'])) .'</td>';
                      $html .= '<td style="text-align: center;">'. $uangMasuk['remarks'] .'</td>';
                      $html .= '<td style="text-align: right;">Rp. '. number_format($uangMasuk['qty_in'], 2, ',', '.') .'</td>';
                      $html .= '<td style="text-align: center;">'. $uangMasuk['username'] .'</td>';
                    $html .= '</tr>';
                  endforeach;

                  $totalUangKeluar = 0;
                  foreach($data['totalUangKeluar'] as $uangKeluar) :
                    $totalUangKeluar += $uangKeluar['qty_out'];
                  endforeach;
      $html .= '<tr>
                  <td colspan="3" style="border: none; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center;"><b>Total</b></td>
                  <td style="border: none; border-bottom: 1px solid black; text-align: right;"><b>Rp.'. number_format($totalUangMasuk, 2, ',', '.') .'</b></td>
                  <td style="border: none; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                </tr>
                </tbody>
              </table>
            <p><b>Pengeluaran : Rp. '. number_format($totalUangKeluar, 2, ',', '.') .'</b></p>
            <p style="padding-top: -15px;"><b>Sisa Saldo :</b> <b style="color: green;">Rp. '. number_format(($totalUangMasuk - $totalUangKeluar), 2, ',', '.') .'</b></p>
            <p style="text-align: right; color:grey;">Karawang, '. date('d-M-Y H:i') .' WIB</p>
            <p style="text-align: right; color:grey;">'. $_SESSION['userInfo']['username'] . ' ('. $_SESSION['userInfo']['role_name'] .')' .'</p>
            </body>
          </html>';
  $mpdf->WriteHTML($html);
  $mpdf->Output('Laporan Kas Masuk Acara ' . $data['totalUangMasuk'][0]['event_name'] . ' Periode ' . date('d/M/Y', strtotime($data['start_period'])) . ' s.d ' . date('d/M/Y', strtotime($data['end_period'])) . '.pdf', 'I');
}
?>