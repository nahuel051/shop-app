<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PdfService;

class BuyReportController extends Controller
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

        // Obtener las compras realizadas por el usuario autenticado
        $buys = Buy::with(['details.product', 'buyer', 'seller']) // Usar 'details' en lugar de 'detailsBuy'
                    ->where('user_id_buyer', $userId) // Filtrar por el usuario autenticado (comprador)
                    ->get();

        // Pasar las compras filtradas a la vista
        return view('buy.index', compact('buys'));
    }

    public function generatePdf($buyId)
    {
        // Obtener los detalles de la compra
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
        $this->pdfService->generatePdf('buy.report', $data, "nota_de_compra_{$buyId}.pdf");
    }
}
