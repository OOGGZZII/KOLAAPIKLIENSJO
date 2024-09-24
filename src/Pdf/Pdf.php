<?php

namespace App\Pdf;

class Pdf extends \tFPDF
{
    function Header()
    {
        // Logo
        $this->Image('img/UN256.jpg',10,6,30);
        // Arial bold 15
//        $this->AddFont('times','','times.ttf',true);
        $this->SetFont('DejaVuB','',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Megyék listája',0,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('DejaVuI','',8);
        // Page number
        $this->Cell(0,10,'Oldal '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function createCountiesList(array $counties)
    {
        $this->AliasNbPages();
        $this->AddFont('DejaVu','','DejaVuSerif.ttf',true);
        $this->AddFont('DejaVuB','','DejaVuSerif-Bold.ttf',true);
        $this->AddFont('DejaVuI','','DejaVuSerif-Italic.ttf',true);
        $this->AddPage();
        $this->SetFont('DejaVuB','',12);
        $h = 10;
        $this->Cell(10, $h, '#');
        $this->Cell(50, $h, 'árvíztűrő tükörfúrógép, ÁRVÍZTŰRŐ TÜKÖRFÚRÓGÉP');
        $this->Ln($h);
        $x = 10;
        $y = $this->GetY();
        $this->SetFont('DejaVu','',10);
        for ($i = 0; $i < count($counties); $i++) {
            $county = $counties[$i];
            ($i % 2) ? $this->SetFillColor(225) : $this->SetFillColor(255);
            $this->Cell(10, $h, $county['id'], 0, 0, 'L', true);
            $this->Cell(50, $h, $county['name'] ,0, 0, 'L', true);
            $this->Line($x, $y, $x+60, $y);
            $y += $h;
            $this->Ln($h);
        }
    }

}
