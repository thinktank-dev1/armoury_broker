<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    public function download(string $type, string $parcelId){
        if (!in_array($type, ['waybill', 'sticker'])) {
            abort(404);
        }

        $baseUrl = env('PUDO_URL');
        $apiKey  = env('PUDO_API_KEY');

        $url = "{$baseUrl}/generate/{$type}/{$parcelId}";

        $response = Http::get($url, [
            'api_key' => $apiKey,
        ]);

        if ($response->failed()) {
            abort(502, 'Unable to retrieve document from Pudo.');
        }
        
        $contentType = $response->header('Content-Type') ?? 'application/pdf';
        $filename    = "{$type}-{$parcelId}.pdf";

        return response($response->body(), 200, [
            'Content-Type'        => $contentType,
            'Content-Disposition' => "inline; filename=\"{$filename}\"", // Use 'attachment' to force download
        ]);
    }
}
