<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PdfService;

class BuyReportController extends Controller
{
    // Propiedad para almacenar el servicio de generación de PDFs
    protected $pdfService;
// Constructor de la clase
//El constructor acepta una instancia de PdfService y la asigna a la propiedad $pdfService para su uso en otros métodos del controlador.
    public function __construct(PdfService $pdfService)
    {
        // Inyecta el servicio de PDF en el controlador
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Obtener las compras realizadas por el usuario autenticado
        // Consulta todas las compras del usuario usando el método with para cargar relaciones (details.product, buyer, seller) y where para filtrar por el ID del comprador.
        $buys = Buy::with(['details.product', 'buyer', 'seller']) // Usar 'details' en lugar de 'detailsBuy'
                    ->where('user_id_buyer', $userId) // Filtrar por el usuario autenticado (comprador)
                    ->get();

        // Pasar las compras filtradas a la vista
        return view('buy.index', compact('buys'));
    }
// Método para generar un reporte PDF de una compra específica
    public function generatePdf($buyId)
    {
        // Obtener los detalles de la compra
        // Obtiene los detalles de una compra específica usando el método findOrFail para buscar por ID, lanzando una excepción si no se encuentra.
        $buy = Buy::with(['details.product', 'buyer', 'seller'])
            ->findOrFail($buyId);
    
        // Preparar datos para el PDF
        $data = [
            'buy' => $buy,
            'buyer' => $buy->buyer,
            'seller' => $buy->seller,
            'details' => $buy->details, // Usar 'details' en lugar de 'detailsBuy'
        ];
    
        // Generar el PDF usando el servicio
        // Usa el servicio de PDF para generar un archivo con el nombre nota_de_compra_{buyId}.pdf, basándose en la vista buy.report.
        $this->pdfService->generatePdf('buy.report', $data, "nota_de_compra_{$buyId}.pdf");
    }
}
