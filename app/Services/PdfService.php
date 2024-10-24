<?php
// Este archivo define un servicio que se encarga de generar documentos PDF utilizando la biblioteca Dompdf.
namespace App\Services;

use Dompdf\Dompdf;

class PdfService
{
    protected $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function generatePdf($view, $data = [], $filename = 'documento.pdf')
    {
        $html = view($view, $data)->render();
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream($filename, ['Attachment' => 0]); // 0 para mostrar en el navegador
    }
}
