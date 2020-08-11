<?php
class PDF extends FPDF
{
  public function Header()
  {
    //Logo
    $this->Image(LOGO_IMG, 10, 8, 33);
    $this->SetFont('Helvetica', 'B', '20');
    $this->Cell(40);
    $this->Cell(0, 5, APPNAME, 0, 1, 'C');
    $this->SetFont('Helvetica', '', '10');
    $this->Cell(40);
    $this->MultiCell(0, 5, "\n Cl 12A 20G-190 Yumbo - Valle del Cauca \n (+57) 24300266  (+57) 26667077", 0, 'C');
    $this->Ln(10);
  }

  public function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }
}
