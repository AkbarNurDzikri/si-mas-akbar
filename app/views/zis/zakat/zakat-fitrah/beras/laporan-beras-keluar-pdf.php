<?php
require_once dirname(__DIR__, 6) . '/assets/dashboard/vendor/mpdf/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetFooter('{PAGENO}');
$html = '<!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Laporan Distribusi Zakat Fitrah (Beras)</title>
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
            
            <h4 style="text-align: center;">Laporan Distribusi Zakat Fitrah (Beras)</h4>
            <h4 style="text-align: center; padding-top: -15px;">Periode '. date('d M Y', strtotime($data['start_period'])) . ' s.d ' . date('d M Y', strtotime($data['end_period'])) .'</h4>

            <table border="1" style="border-collapse: collapse; margin-left: auto; margin-right: auto; margin: 20px 0 30px 0; width: 700px;">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Tgl, Jam</th>
                  <th>Nama Mustahik</th>
                  <th>Status</th>
                  <th>Alamat</th>
                  <th>Qty</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>';
                $i = 1;
                $totalBerasKeluar = 0;
                foreach($data['totalBerasKeluar'] as $berasKeluar) :
                  $totalBerasKeluar += $berasKeluar['qty_out'];
                  $html .= '<tr>';
                    $html .= '<td style="text-align: center;">'. $i++ .'</td>';
                    $html .= '<td style="text-align: center;">'. date('d/M/y, H:i', strtotime($berasKeluar['created_at'])) .'</td>';
                    $html .= '<td style="text-align: center;">'. $berasKeluar['person_name'] .'</td>';
                    $html .= '<td style="text-align: center;">'. $berasKeluar['person_status'] .'</td>';
                    $html .= '<td style="text-align: center;">'. $berasKeluar['person_address'] .'</td>';
                    $html .= '<td style="text-align: right;">'. str_replace('.', ',', $berasKeluar['qty_out']) .' L</td>';
                    $html .= '<td style="text-align: center;">'. $berasKeluar['remarks'] .'</td>';
                  $html .= '</tr>';
                endforeach;

                $totalBerasMasuk = 0;
                foreach($data['totalBerasMasuk'] as $berasMasuk) :
                  $totalBerasMasuk += $berasMasuk['qty_in'];
                endforeach;
    $html .= '<tr>
                <td colspan="5" style="border: none; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center;"><b>Total</b></td>
                <td style="border: none; border-bottom: 1px solid black; text-align: right;"><b>'. str_replace('.', ',', $totalBerasKeluar) .' L</b></td>
                <td style="border: none; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
              </tr>
              </tbody>
            </table>
          <p><b>Total Penerimaan : '. str_replace('.', ',', $totalBerasMasuk) .' L</b></p>
          <p style="padding-top: -15px;"><b>Sisa Saldo :</b> <b style="color: green;">'. str_replace('.', ',', $totalBerasMasuk - $totalBerasKeluar) .' L</b></p>
          <p style="text-align: right; color:grey;">Karawang, '. date('d-M-Y H:i') .' WIB</p>
          <p style="text-align: right; color:grey;">'. $_SESSION['userInfo']['username'] . ' ('. $_SESSION['userInfo']['role_name'] .')' .'</p>
          </body>
        </html>';
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan Distribusi Zakat Fitrah (Uang) Periode ' . date('d/M/Y', strtotime($data['start_period'])) . ' s.d ' . date('d/M/Y', strtotime($data['end_period'])) . '.pdf', 'I');
?>