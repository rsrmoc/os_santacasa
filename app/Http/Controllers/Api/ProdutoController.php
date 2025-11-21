<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProdutoController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'nome' => 'required|string|min:3|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()]);
        }

        try {
            $produto = Produto::create(['nm_produto' => $request->nome]);

            return response()->json([
                'message' => 'Produto criada com sucesso!',
                'produto' => $produto
            ]);
        }
        catch (Throwable $th) {
            return response()->json([
                'message' => 'Houve um erro ao cadastrar o produto.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function search(Request $request) {
        return Produto::where("nm_produto", "LIKE", "%{$request->q}%")->get();
    }
}
