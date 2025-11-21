<x-layout.default>
    <div class="page-title">
        <h3>Editar Usuário</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('usuarios-listar') }}">Relação</a></li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper" x-data="app">
        <div class="col-md-12 ">
            <form action="{{ route('usuarios-update', ['usuario' => $usuario->id]) }}" method="POST" class="panel panel-white">
                @csrf

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Nome" name="nome" required value="{{ $usuario->name }}" />
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" name="email" required value="{{ $usuario->email }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-striped" style="margin-bottom: 0">
                                <thead>
                                    <tr class="active">
                                        <th>Página</th>

                                        <th>Permissões</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Usuários</td>

                                        <td>
                                            <div style="display: flex">
                                                <div class="checkbox" style="margin: 0">
                                                    <label>
                                                        <div class="checker">
                                                            <span>
                                                                <input type="checkbox" name="permissoes[usuarios][]" value="ver"
                                                                    @if($usuario->isPermissao('usuarios', 'ver')) checked @endif />
                                                            </span>
                                                        </div> Ver
                                                    </label>
                                                </div>

                                                <div class="checkbox" style="margin: 0">
                                                    <label>
                                                        <div class="checker">
                                                            <span>
                                                                <input type="checkbox" name="permissoes[usuarios][]" value="criar"
                                                                    @if($usuario->isPermissao('usuarios', 'criar')) checked @endif />
                                                            </span>
                                                        </div> Criar/Editar
                                                    </label>
                                                </div>

                                                <div class="checkbox" style="margin: 0">
                                                    <label>
                                                        <div class="checker">
                                                            <span>
                                                                <input type="checkbox" name="permissoes[usuarios][]" value="excluir"
                                                                    @if($usuario->isPermissao('usuarios', 'excluir')) checked @endif />
                                                            </span>
                                                        </div> Excluir
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <button class="btn btn-success">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</x-layout.default>
