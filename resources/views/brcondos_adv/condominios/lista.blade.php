
<x-layout.brcondos_adv.layout>
    
    <div class="page-title">
        <h3>Condomínios</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('condominios-listar') }}">Relação</a></li>
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
                        <form action="{{ route('condominios-listar') }}" method="GET">
                            <div style="display: flex">
                                <input type="search" name="b" placeholder="Pesquisa"   class="form-control"
                                    value="{{ request()->query('b') }}" />

                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <div>
                            @if (auth()->user()->isPermissao('condominios', 'criar'))
                                <a href="{{ route('condominios-criar') }}" class="btn btn-success">
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
                                <th>Condomínio</th> 
                                <th>Situação</th> 
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($condominios as $condominio) 
                                    <tr id="tr-condominio-{{ $condominio->chave }}">
                                        <td>{{ $condominio->cd_condominio }}</td>
                                        <td>{{ $condominio->nm_condominio }}</td>
                                        <td>@if($condominio->sn_ativo=='S') <span class="label label-success">Ativo</span> @else  <span class="label label-danger">Inativo</span> @endif</td>
                                         
                                        <td class="text-center"> 
                                                <div class="btn-group">
                                                    @if (auth()->user()->isPermissao('condominios', 'criar'))
                                                        <a href="{{ route('condominios-editar', ['condominio' => $condominio->chave]) }}"
                                                            class="btn btn-success btn-xs" style="  padding: 0px 10px; ">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    @if (auth()->user()->isPermissao('condominios', 'excluir') )
                                                        <button class="btn btn-danger btn-xs" style="  padding: 0px 10px; " onclick="excluirRegistro('#tr-condominio-{{ $condominio->chave }}', {{ $condominio->chave }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div> 
                                        </td>
                                    </tr> 
                            @endforeach
                        </tbody>
                    </table>
                    <div style="float: right">
                        {{ $condominios->links() }}
                    </div>
                    @if (empty($condominios))
                        <p class="text-center" style="padding: 1.2em">Nenhum usuário</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function excluirRegistro(el, condominio) {
                Swal.fire({
                    title: 'Confirmação',
                    text: "Tem certeza que deseja excluir esse usuáro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#22BAA0',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não',
                    confirmButtonText: 'Sim'
                }).then((result) => {
                    if (result.isConfirmed) {  
                        axios.get(`/brcondos_adv/condominios-delete/${condominio}`)
                            .then((res) => {
                                document.querySelector(el).remove();
                                toastr["success"]('Usuário excluido com sucesso!');
                            })
                            .catch((err) => toastr["error"]('Não foi possivel excluir o usuário!'));
                    }
                });
            }
        </script>
    </x-slot>
</x-layout.brcondos_adv.layout>
