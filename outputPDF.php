<?php

require('fpdf.php');
if (session_id() == '') {
    session_start();
    include 'config.php';

    class myPDF extends FPDF
    {
        // Mengatur tampilan header
        function header()
        {
            $this->SetFillColor(0, 61, 121);
            $this->SetFont('Times', 'B', 16);
            $this->Cell(0, 25, '', 1, 1, 'L', true);
            $this->Image('logo_kuning_mandiri2.png', 8, 12, 40);
            $this->Ln(10);
        }
    }

    $pdf = new myPDF();

    $pdf->AddPage();
    // Mengatur judul pada halaman pdf
    $pdf->SetFont('Times', 'B', 16);
    $pdf->Cell(0, 7, 'RIWAYAT HASIL PENCARIAN', 0, 1, 'C');
    $pdf->Cell(10, 7, '', 0, 1);
    $pdf->SetFont('Times', 'B', 7);

    // Menata ukuran tabel sebagai tempat menampilkan data-data
    $pdf->SetFillColor(234, 144, 0);
    $pdf->Ln(8);
    $pdf->Cell(70, 15, 'NAMA', 1, 0, 'C', true);
    $pdf->Cell(17, 15, 'NIP', 1, 0, 'C', true);
    $pdf->Cell(14, 15, 'GENDER', 1, 0, 'C', true);
    $pdf->Cell(56.5, 15, 'JABATAN', 1, 0, 'C', true);
    $pdf->Cell(10, 15, 'PL', 1, 0, 'C', true);
    $pdf->Cell(11, 15, 'TC', 1, 0, 'C', true);
    $pdf->Cell(13, 15, 'GRADE', 1, 1, 'C', true);
    $keyword_kode = '';
    if (isset($_SESSION['keyword_kode'])) {
        $keyword_kode = $_SESSION['keyword_kode'];
    } else {
        $keyword_kode = null;
    }

    // Menampilkan data-data ke dalam tabel berdasarkan baris dan kolom
    $sql = "SELECT * FROM detail_history_pencarian JOIN pegawai AS tp ON detail_history_pencarian.nip = tp.nip JOIN nilai_jabatan AS tnj ON tp.PS_group = tnj.name JOIN history_pencarian AS hp ON detail_history_pencarian.id_history_pencarian = hp.id_history_pencarian JOIN jabatan ON jabatan.kode_posisi = tp.kode_posisi WHERE tnj.kode_posisi = hp.kode_posisi AND hp.id_history_pencarian = $keyword_kode ORDER BY detail_history_pencarian.id_detail_history ASC";
    $no = 1;
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pdf->Cell(70, 12, $row["nama"], 1, 0, 'C');
                $pdf->Cell(17, 12, $row['nip'], 1, 0, 'C');
                $pdf->Cell(14, 12, $row['gender'], 1, 0, 'C');
                $pdf->Cell(56.5, 12, $row['posisi'], 1, 0, 'C');
                $pdf->Cell(10, 12, $row["pl"], 1, 0, 'C');
                $pdf->Cell(11, 12, $row["tc"], 1, 0, 'C');
                $pdf->Cell(13, 12, $row["PS_group"], 1, 1, 'C');

                $no++;
            }
        } else {
        }
    }
    $pdf->Output();
}
