<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\NegociacaoBoleto;
use Exception;
use Illuminate\Http\Request;

class NegociacaoBoletoController extends Controller
{
    public function createJson(Request $request) {
        $validated = $request->validate([
            'cd_negociacao' => 'required|integer|exists:negociacoes,cd_negociacao',
            'cd_boleto' => 'required|integer|exists:boletos,cd_boleto'
        ]);

        try {
            $validated['id_usuario'] = $request->user()->id;
            $negociacaoBoleto = NegociacaoBoleto::create($validated);

            return response()->json([
                'message' => 'Boleto adicionado a negociação!',
                'negociacao_boleto' => $negociacaoBoleto->load('boleto')
            ]);
        }
        catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteJson($negociacaoBoleto) {
        try {
            NegociacaoBoleto::find($negociacaoBoleto)->delete();

            return response()->json(['message' => 'Boleto removido da negociação']);
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
