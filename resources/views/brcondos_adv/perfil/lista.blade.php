<x-layout.brcondos_adv.layout>
    <div class="page-title">
        <h3>Perfis</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('perfis-listar') }}">Relação</a></li>
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
                        <form action="{{ route('perfis-listar') }}" method="GET">
                            <div style="display: flex">
                                <input type="search" name="b" placeholder="Pesquisa" required class="form-control"
                                    value="{{ request()->query('b') }}" />

                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <div>
                            @if (auth()->user()->isPermissao('perfis', 'criar'))
                                <a href="{{ route('perfis-criar') }}" class="btn btn-success">
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
                                <th>Codigo</th>
                                <th>Perfil</th> 
                                <th>Situação</th> 
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($perfil as $linha) 
                                    <tr id="tr-perfil-{{ $linha->cd_perfil }}">
                                        <td>{{ $linha->cd_perfil }}</td> 
                                        <td>{{ $linha->nm_perfil }}</td> 
                                        <td>
                                            @if ($linha->sn_ativo=='S')
                                                Ativo
                                            @else
                                                 Inativo
                                            @endif
                                        </td>
                                        <td class="text-center"> 
                                                <div class="btn-group">
                                                    @if (auth()->user()->isPermissao('perfis', 'criar'))
                                                        <a href="{{ route('perfis-editar', ['perfil' => $linha->cd_perfil]) }}"
                                                            class="btn btn-success btn-xs">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    @if (auth()->user()->isPermissao('perfis', 'excluir'))
                                                        <button class="btn btn-danger btn-xs" onclick="excluirUsuario('#tr-perfis-{{ $linha->cd_perfil }}', {{ $linha->cd_perfil }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div> 
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
                    confirmButtonColor: '#22BAA0',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não',
                    confirmButtonText: 'Sim'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get(`/brcondos_adv/usuarios-delete/${idUsuario}`)
                            .then((res) => {
                                document.querySelector(el).remove();
                                toastr["success"]('Usuário excluido com sucesso!');
                            })
                            .catch((err) => toastr["error"]('Não foi possivel excluir o Usuário!'));
                    }
                });
            }
        </script>
    </x-slot>
</x-layout.brcondos_adv.layout>
