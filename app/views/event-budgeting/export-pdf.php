<?php
require_once dirname(__DIR__, 3) . '/assets/dashboard/vendor/mpdf/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetFooter('{PAGENO}');
$html = '<!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Print Anggaran Dana [ ' . $data['budgets'][0]['event_name'] . ' ]</title>
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

            <hr>
            
            <h3 style="text-align: center;"><u>ANGGARAN DANA ACARA</u></h3>
            <h3 style="text-align: center; padding-top: -10px; padding-bottom: -10px;"><u>' . strtoupper($data['budgets'][0]['event_name']) . '</u></h3>

            <table border="0" style="border-collapse: collapse; margin-top: 30px; margin-bottom: 50px;">
              <tr>
                <td style="border-bottom: 1px dotted black;"><b>Dasar</b></td>
                <td style="border-bottom: 1px dotted black;">: </td>
                <td style="border-bottom: 1px dotted black;">Hasil rapat tanggal ' . date('d-M-Y', strtotime($data['budgets'][0]['meeting_date'])) . ' - ' . $data['budgets'][0]['meeting_time'] .' WIB @ ' . $data['budgets'][0]['meeting_room'] . '</td>
              </tr>
              <tr>
                <td style="border-bottom: 1px dotted black;"><b>Anggota rapat</b></td>
                <td style="border-bottom: 1px dotted black;">: </td>
                <td style="border-bottom: 1px dotted black;">'.$data['budgets'][0]['meeting_participants'].'</td>
              </tr>
            </table>';
            foreach($data['budgets'] as $budget) {
              $html .= '<ul>
                <li>
                  <b>'. $budget['budget_name'] . ' - Rp. ' . number_format($budget['budget_price'], '2', ',', '.') . '</b> <br>
                  <i><u>Keterangan</u></i> : <br>' . $budget['remarks'] .
                '</li>
              </ul>';
            };


  $html .= '<p style="text-align: right; color:grey; margin-top: 50px;">Tanggal download : '. date('d-M-Y H:i') .' WIB</p>
          </body>
        </html>';
$mpdf->WriteHTML($html);
$mpdf->Output('Anggaran Dana ' . $data['budgets'][0]['event_name'] . ' (' . date('d-M-Y', strtotime($data['budgets'][0]['event_date'])) . ').pdf', 'I');
?>