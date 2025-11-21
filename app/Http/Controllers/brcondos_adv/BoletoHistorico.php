<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\BoletoHistorico as ModelsBoletoHistorico;
use Illuminate\Http\Request;

class BoletoHistorico extends Controller
{
    public function index($cd_boleto) {
        $query = ModelsBoletoHistorico::where('cd_boleto', $cd_boleto)->get();

        return response()->json($query);
    }

    public function store(Request $request) {
        $valdated = $request->validate([
            'cd_boleto' => 'required|integer|exists:boletos,cd_boleto',
            'nome' => 'required|string'
        ]);

        $query = ModelsBoletoHistorico::create($valdated);

        return response()->json($query);
    }

    public function destroy($cd_boleto_hist) {
        ModelsBoletoHistorico::find($cd_boleto_hist)->delete();

        return response()->json(["message" => "Historico excluído com sucesso!"]);
    }
}
