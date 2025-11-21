<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\HistoricoCliente;
use Illuminate\Http\Request;

class HistoricoClienteController extends Controller
{
    public function storeJson(Request $request) {
        $validated = $request->validate([
            'cpf_cnpj_cliente' => 'required|string',
            'historico' => 'required|string'
        ]);

        try {
            $validated['id_usuario'] = $request->user()->id;

            $historico = HistoricoCliente::create($validated);

            return response()->json([
                'message' => 'Histórico salvo com sucesso!',
                'historico' => $historico->load('usuario')
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateJson(Request $request) {
        $validated = $request->validate([
            'cd_historico' => 'required|integer|exists:historico_cliente,cd_historico',
            'historico' => 'required|string'
        ]);

        try {
            unset($validated['cd_historico']);

            $historico = HistoricoCliente::find($request->cd_historico);
            $historico->update($validated);

            return response()->json([
                'message' => 'Histórico atualizado com sucesso!',
                'historico' => $historico->load('usuario')
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroyJson($cdHistorico) {
        try {
            $historico = HistoricoCliente::find($cdHistorico);
            $historico->delete();

            return response()->json(['message' => 'Historico excluido com sucesso!']);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
