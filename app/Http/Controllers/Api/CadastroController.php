<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cadastro;
use App\Models\CadastroProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CadastroController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->post(), [
            'nome_paciente' => 'required|string|max:100',
            'tipo_convenio' => 'required|string|in:CON,PAR,SUS',
            'nome_convenio' => 'nullable|string|max:100',
            'nome_medico' => 'required|string|max:100',
            'hospital' => 'required|integer|exists:hospital,cd_hospital',
            'data_cirurgia' => 'required|date_format:Y-m-d',
            'produtos' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()]);
        }

        try {
            DB::transaction(function() use($request, $validator) {
                $dataCadastro = $validator->validated();
                $dataCadastro['cd_hospital'] = $dataCadastro['hospital'];

                unset($dataCadastro['hospital']);
                unset($dataCadastro['produtos']);

                $cadastro = Cadastro::create($dataCadastro);

                foreach($request->produtos as $cdProduto) {
                    if (!is_numeric($cdProduto)) {
                        $produto = Produto::create(["nm_produto" => $cdProduto]);

                        CadastroProduto::create([
                            'cd_cadastro' => $cadastro->cd_cadastro,
                            'cd_produto' => $produto->cd_produto
                        ]);

                        continue;
                    }

                    CadastroProduto::create([
                        'cd_cadastro' => $cadastro->cd_cadastro,
                        'cd_produto' => $cdProduto
                    ]);
                }
            });

            return response()->json(['message' => 'Cadastro realizado com sucesso!']);
        }
        catch (Throwable $th) {
            return response()->json([
                'message' => 'Houve um erro ao fazer o cadastro. '.$th->getMessage()
            ], 500);
        }
    }
}
