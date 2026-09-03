<x-layout.acma.layout>
    <div class="page-title">
        <h3>Usuários</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('usuarios-listar') }}">Relação</a></li>
            </ol>
        </div>
    </div>
    <style>
        .btn-xs{
            padding: 0px 10px;
        }
    </style>


    <div id="main-wrapper" x-data="app">

     
        
        
        <div class="col-md-12 ">
            <div class="panel panel-white">
                <div class="panel-heading" style="height: auto">
                    <div style="display: flex; gap: 1em; justify-content: flex-end">
                        <form action="{{ route('usuarios-listar') }}" method="GET">
                            <div style="display: flex">
                                <input type="search" name="b" placeholder="Pesquisa" required class="form-control"
                                    value="{{ request()->query('b') }}" />

                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <div>
                            @if (auth()->user()->isPermissao('usuarios', 'criar'))
                                <a href="{{ route('usuarios-criar') }}" class="btn btn-info">
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
                                <th>Usuario</th>
                                <th>Nome</th>
                                <th>Permissões</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($usuarios as $usuario) 
                                    <tr id="tr-usuario-{{ $usuario->id }}">
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ $usuario->name }}</td>
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
                                                            class="btn btn-info btn-xs">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    @if (auth()->user()->isPermissao('usuarios', 'excluir'))
                                                        <button class="btn btn-danger btn-xs" onclick="excluirUsuario('#tr-usuario-{{ $usuario->id }}', {{ $usuario->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    </tr> 
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
                    text: "Tem certeza que deseja excluir esse usuário?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#12AFCB',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não',
                    confirmButtonText: 'Sim'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/acma/usuarios-delete/${idUsuario}`)
                            .then((res) => {
                                document.querySelector(el).remove();
                                toastr["info"]('Usuário excluido com sucesso!');
                            })
                            .catch((err) => toastr["error"]('Não foi possivel excluir o Usuário!'));
                    }
                });
            }
        </script>
    </x-slot>
</x-layout.acma.layout>
