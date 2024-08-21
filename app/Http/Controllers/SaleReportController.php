<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PdfService;

class SaleReportController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Obtener las ventas del usuario autenticado
        $sales = Sale::with(['details.product', 'buyer', 'seller']) // Asegúrate de que las relaciones sean correctas
                     ->where('user_id_seller', $userId)
                     ->get();

        // Pasar las ventas filtradas a la vista
        return view('sales.index', compact('sales'));
    }

    public function generatePdf($saleId)
    {
        // Obtener los detalles de la venta
        $sale = Sale::with(['details.product', 'buyer', 'seller'])
            ->findOrFail($saleId);
    
        // Preparar datos para el PDF
        $data = [
            'sale' => $sale,
            'buyer' => $sale->buyer,
            'seller' => $sale->seller,
            'details' => $sale->details,
        ];
    
        // Generar el PDF usando el servicio
        $this->pdfService->generatePdf('sales.report', $data, "nota_de_venta_{$saleId}.pdf");
    }
}
