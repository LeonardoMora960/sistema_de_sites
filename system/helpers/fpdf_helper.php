<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
//require_once("fpdf/fpdf.php");
require('mc_table.php');

class PDF extends PDF_MC_Table {

  function set_header($title, $ancho = 190,$vertical = true) {
    
    $logo = base_url() . "imagen/logo_pdf.jpg";
    
    if($vertical==true)
     $this->Image($logo, 8, 8, 33);
    else
      $this->Image($logo, 250, 8, 33);
    
    $this->Ln(10);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell($ancho, 7, utf8_decode($title), 0, '', 'C');
    $this->Ln(10);
  }

  function set_datos($header, $wcell = array(), $data, $obj, $item = true) {

    // Colores de los bordes, fondo y texto
    $this->SetDrawColor(0, 0, 50);
    $this->SetFillColor(220, 50, 50);
    $this->SetTextColor(255, 255, 255);

    //tamaño de fuente

    $this->SetFont('Arial', '', 9);

    // Cabecera
    $w = $wcell;
    $total_cols = count($w);

    for ($i = 0; $i < count($w); $i++):
      $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
    endfor;

    $this->Ln();
    // Restauracion de colores y fuentes
    $this->SetFillColor(225, 225, 225);
    $this->SetTextColor(0);
    $this->SetFont('');

    // Datos
    $this->SetFont('Arial', '', 8);
    $f = 1;

    if (count($data) != 0):
      foreach ($data as $row):
        $this->SetWidths($w);
        $datos = array();
        if ($item == true)
          $datos[0] = $f;

        for ($j = ($item == true) ? 1 : 0; $j < $total_cols; $j++):
          $datos[$j] = utf8_decode($row->$obj[$j]);
        endfor;
        $this->Row($datos);
        $f++;
      endforeach;
    endif;
  }

}

?>