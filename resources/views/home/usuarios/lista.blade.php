<x-layout.default>
    <div class="page-title">
        <h3>Usuários</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('usuarios-listar') }}">Relação</a></li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper" x-data="app">
        <div class="col-md-12 ">
            <div class="panel panel-white">
                <div class="panel-heading" style="height: auto">
                    <div style="display: flex; gap: 1em; justify-content: flex-end">
                        <form action="{{ route('usuarios-listar') }}" method="GET">
                            <div style="display: flex">
                                <input type="search" name="b" placeholder="Pesquisa" required class="form-control"
                                    value="{{ request()->query('b') }}" />

                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <div>
                            @if (auth()->user()->isPermissao('usuarios', 'criar'))
                                <a href="{{ route('usuarios-criar') }}" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Novo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <table class="table table-striped" style="margin-bottom: 0">
                        <thead>
                            <tr class="active">
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Permissões</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($usuarios as $usuario)
                                @if ($usuario->id != auth()->user()->id)
                                    <tr id="tr-usuario-{{ $usuario->id }}">
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>
                                            @if ($usuario->admin)
                                                Administrador
                                            @else
                                                @foreach ($usuario->permissoes as $permissao)
                                                    <p style="margin-bottom: 0">{{ $permissao->nome }}
                                                        ({{ $permissao->permissoes }})</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (!$usuario->admin)
                                                <div class="btn-group">
                                                    @if (auth()->user()->isPermissao('usuarios', 'criar'))
                                                        <a href="{{ route('usuarios-editar', ['usuario' => $usuario->id]) }}"
                                                            class="btn btn-success">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    @if (auth()->user()->isPermissao('usuarios', 'excluir'))
                                                        <button class="btn btn-danger" onclick="excluirUsuario('#tr-usuario-{{ $usuario->id }}', {{ $usuario->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    @if (empty($usuarios))
                        <p class="text-center" style="padding: 1.2em">Nenhum usuário</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function excluirUsuario(el, idUsuario) {
                Swal.fire({
                    title: 'Confirmação',
                    text: "Tem certeza que deseja excluir esse usuáro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não',
                    confirmButtonText: 'Sim'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get(`/home/usuarios-delete/${idUsuario}`)
                            .then((res) => {
                                document.querySelector(el).remove();
                                toastr["success"]('Condominio excluido com sucesso!');
                            })
                            .catch((err) => toastr["error"]('Não foi possivel excluir o Condominio!'));
                    }
                });
            }
        </script>
    </x-slot>
</x-layout.default>
