<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PdfService;

class SaleReportController extends Controller
{
    protected $pdfService;
   // El constructor acepta una instancia de PdfService y la asigna a la propiedad $pdfService. Esto permite el uso de esta instancia en otros métodos del controlador.    
   public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Obtener las ventas del usuario autenticado
        // Consulta todas las ventas del usuario usando el método with para cargar relaciones (details.product, buyer, seller) y where para filtrar por el ID del comprador.
        $sales = Sale::with(['details.product', 'buyer', 'seller']) // Asegúrate de que las relaciones sean correctas
                     ->where('user_id_seller', $userId)
                     ->get();

        // Pasar las ventas filtradas a la vista
        return view('sales.index', compact('sales'));
    }

    public function generatePdf($saleId)
    {
        // Obtener los detalles de la venta
        // Obtiene los detalles de una venta específica usando el método findOrFail para buscar por ID, lanzando una excepción si no se encuentra.
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
        // Usa el servicio de PDF para generar un archivo con el nombre nota_de_venta_{saleId}.pdf, basándose en la vista buy.report.
        $this->pdfService->generatePdf('sales.report', $data, "nota_de_venta_{$saleId}.pdf");
    }
}
