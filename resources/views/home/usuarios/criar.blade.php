<x-layout.default>
    <div class="page-title">
        <h3>Cadastrar Usuário</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('usuarios-listar') }}">Relação</a></li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper" x-data="app">
        <div class="col-md-12 ">
            <form action="{{ route('usuarios-store') }}" method="POST" class="panel panel-white">
                @csrf

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Nome" name="nome" required />
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" name="email" required />
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
                                                                <input type="checkbox" name="permissoes[usuarios][]" value="ver" />
                                                            </span>
                                                        </div> Ver
                                                    </label>
                                                </div>

                                                <div class="checkbox" style="margin: 0">
                                                    <label>
                                                        <div class="checker">
                                                            <span>
                                                                <input type="checkbox" name="permissoes[usuarios][]" value="criar" />
                                                            </span>
                                                        </div> Criar/Editar
                                                    </label>
                                                </div>

                                                <div class="checkbox" style="margin: 0">
                                                    <label>
                                                        <div class="checker">
                                                            <span>
                                                                <input type="checkbox" name="permissoes[usuarios][]" value="excluir" />
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
