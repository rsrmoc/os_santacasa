<x-layout.acma.layout>

    <div class="page-title">
        <h3>Chamados</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('chamados-listar') }}">{{ $request['nm_oficina'] ?? 'Relação' }}</a></li>
            </ol>
        </div>
    </div>

    <style>
        .btn-xs {
            padding: 0px 10px;
        }

        .label-purple {
            color: white !important;
            border-color: #9585bf;
            background: #9585bf !important;
        }

        .bg-green {
            background-color: #22BAA0 !important;
        }

        .bg-pendente {
            background-color: #7a6fbe !important;
        }

        .bg-aguardando {
            background-color: #f39c12 !important;
        }

        .bg-cancelado {
            background-color: #f25656 !important;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .bg-vencido {
            color: #f25656 !important;
            border: 1px solid #f25656;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 5px;
        }

        .bg-prazos{
            color: #22BAA0 !important;
            border: 1px solid #22BAA0;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 5px;
        }

        .bg-dias{
            color: #666867 !important;
            border: 1px solid #666867;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 5px;
        }
        .table td, .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 5px !important;
        }
    </style>

    <div id="app" x-data="app">

        <span x-show="isLoading">
            <div class="fa-3x CarregaPagina"
                style="  margin-top: 40%; text-align: center; margin: 0 auto; width: 100%;
            height: 100%;   z-index: 9999999999; overflow: hidden;  ">
                <Br>
                <!--<i class="fa fa-spinner fa-pulse has-text-danger" style="font-size: 2.5em; "></i>-->
                <img src="{{ asset('assets/images/logo_sc.png') }}">
                <br>
                <section class="fa-1x ">
                    <div class="loading loading01">
                        <span>C</span>
                        <span>a</span>
                        <span>r</span>
                        <span>r</span>
                        <span>e</span>
                        <span>g</span>
                        <span>a</span>
                        <span>n</span>
                        <span>d</span>
                        <span>o</span>
                    </div>
                </section>
            </div>
        </span>


        <div class="col-md-12 " style="padding: 0px;">
            <div class="panel panel-white" style="padding-bottom: 0px;">
                <div class="panel-heading" style="height: auto; padding-bottom: 0px;">

                    <form x-on:submit.prevent="getPage()" class="panel panel-white" id="form-chamados"
                        style="margin-bottom: 15px;">
                        <input type="hidden" name="tp_pagina" value="chamados" />
                        <div class="row">
                            <div class="col-md-2" >
                                <div class="form-group @if ($errors->has('dti')) has-error @endif ">
                                    <input type="date" class="form-control" value="{{ old('dti', $request['dti']) }}"
                                        placeholder="Data Inicial" name="dti" required />
                                </div>
                            </div>
                            <div class="col-md-2"  >
                                <div class="form-group @if ($errors->has('dtf')) has-error @endif ">
                                    <input type="date" class="form-control" value="{{ old('dtf', $request['dtf']) }}"
                                        placeholder="Data Final" name="dtf" required />
                                </div>
                            </div>

                            <div class="col-md-2" style="padding-left: 0px;">
                                <div class="form-group @if ($errors->has('cd_os')) has-error @endif ">
                                    <input type="text" class="form-control" placeholder="OS" name="cd_os" />
                                </div>
                            </div>

                            <div class="col-md-3" style="padding-left: 0px;"   >
                                <div class="form-group @if ($errors->has('descricao')) has-error @endif ">
                                    <input type="text" class="form-control" placeholder="Descrição do Chamado"
                                        name="descricao" />
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;">
                                <div class="form-group @if ($errors->has('setor')) has-error @endif ">
                                    <select class="form-control" name="setor" id="select-agrupamento">
                                        <option value="">Todos os Setores</option>
                                        @foreach ($request['setor'] as $setor)
                                            <option value="{{ $setor->cd_setor }}">{{ $setor->nm_setor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group @if ($errors->has('agrupamento')) has-error @endif ">
                                    <select class="form-control" name="func">
                                        <option value="">Todos Funcionarios</option>
                                        @foreach ($request['func'] as $func)
                                            <option value="{{ $func->cd_func }}">{{ $func->nm_func }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;">
                                <div class="form-group @if ($errors->has('tipo_os')) has-error @endif ">
                                    <select class="form-control" name="tipo_os">
                                        <option value="">Tipo de OS</option>
                                        @foreach ($request['tipo_os'] as $tipo)
                                            <option value="{{ $tipo->cd_tipo_os }}">{{ $tipo->ds_tipo_os }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2" style="padding-left: 0px;">
                                <div class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                    <select class="form-control" name="situacao">
                                        <option value="">Todas Situações</option>
                                        <option value="A" @if (request('cd_situacao') == 'A') selected @endif>
                                            Aberto</option>
                                        <option value="F" @if (request('cd_situacao') == 'F') selected @endif>
                                            Concluido</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="padding: 0px;">
                                <div class="col-md-5" style="padding-left: 0px;">
                                    <div class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                        <select class="form-control" name="ordenacao">
                                            <option value="dt_pedido desc">Criação desc</option>
                                            <option value="dt_pedido asc">Criação asc</option>
                                            <option value="cd_setor asc">Setor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding-left: 0px;">
                                    <div class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                        <select class="form-control" name="linha_pagina">
                                            <option value="30">30 Linhas</option>
                                            <option value="50">50 Linhas</option>
                                            <option value="100">100 Linhas</option>
                                            <option value="200">200 Linhas</option>
                                            <option value="500">500 Linhas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" style="padding-left: 0px;">
                                    <div class="form-group">
                                        <template x-if="buttonSearch">
                                            <button type="submit" style="width: 100%" class="btn btn-info"><i
                                                    class="fa fa-spinner fa-spin"></i> Pesquisando</button>
                                        </template>
                                        <template x-if="!buttonSearch">
                                            <button type="submit" class="col-md-12 btn btn-info" style="width: 100%">
                                                <i class="fa fa-search-plus"></i> Pesquisar
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>

                <div class="panel-body">

                    <table class="table table-striped" style="margin-bottom: 0">
                        <thead>
                            <tr class="active">
                                <th>Chamado</th>
                                <th>Data</th>
                                <th>Tipo de OS</th>
                                <th>Descrição</th>
                                <th>Setor</th>
                                <th>Responsável</th>
                                <th>Solicitante</th>
                                <th>Previsão</th>
                                <th class="text-center">Situação</th>
                            </tr>
                        </thead>

                        <tbody>
                            <template x-if="!loading">
                                <template x-for="os in queryChamados">
                                    <tr x-bind:id="`tr-chamado-${os.cd_os}`">
                                        <th x-text="os.cd_os"></th>
                                        <td x-text="formatDate(os.dt_pedido, 'DD/MM/YYYY')"></td>
                                        <td x-text="os.tab_tipo_os?.ds_tipo_os"></td>
                                        <td x-text="os.ds_servico"></td>
                                        <td x-text="os.tab_setor?.nm_setor"></td>
                                        <td x-text="os.tab_classificacao?.tab_responsavel?.nm_func ?? ' -- '"></td>
                                        <td x-text="os.nm_usuario"></td>
                                        <td style="padding: 3px!important;" >
                                            <span :class="(os.tab_classificacao?.class_prazo ?? 'bg-dias')"
                                            x-text="os.tab_classificacao?.dt_prazo ? formatDate(os.tab_classificacao?.dt_prazo, 'DD/MM/YYYY') : os.dias_em_aberto"
                                            style="font-size: 80%;  font-weight: 900; font-weight: 900; text-transform: none; "></span>
                                        </td>
                                        <td class="text-center" style="padding: 3px!important;">
                                            <span x-on:click="modal(os)"
                                                x-bind:style="'font-size: 85%; font-weight: 500; width: 100%; display: inline-block; cursor: pointer; text-transform: none; background-color: ' +
                                                (os.tab_situacao?.cor ?? '#999797')"
                                                class="label pull-center"
                                                x-html="(os.tab_situacao?.icone ?? '') + ' ' + (os.tab_situacao?.nm_situacao ?? ' --- ')">
                                            </span>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>

                    <template x-if="loading">
                        <x-loader />
                    </template>
                    <br>
                    <div x-html="Pagination"></div>

                    <template x-if="queryChamados.length == 0 && !loading">
                        <p class="text-center" style="padding: 1.2em">Nenhum Chamado</p>
                    </template>
                </div>
            </div>
        </div>




        @include('acma.modal_os.detalhes_os', ['request' => $request])



    </div>

    <x-slot name="scripts">
        <script src="{{ asset('js/acma/chamados.js') }}"></script>
    </x-slot>
</x-layout.acma.layout>
