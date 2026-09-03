<x-layout.acma.layout>

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

        .bg-prazos {
            color: #22BAA0 !important;
            border: 1px solid #22BAA0;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 5px;
        }
        .modalCriar label {
            margin-bottom: 0px;
        }
        .bg-dias{
            color: #666867 !important;
            border: 1px solid #666867;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 5px;
        }

        .progress-bar-alert {
            background-color: #FF9800 !important;
        }

        .icon-bar{
            color:#7a6fbe !important;
        }

        .icon-bar-info{
            color:#12AFCB !important;
        }

        .icon-bar-success{
            color:#22BAA0 !important;
        }

        .icon-bar-warning{
            color:#f6d433 !important;
        }

        .icon-bar-alert{
            color:#FF9800 !important;
        }

        .icon-bar-danger{
            color:#f25656 !important;
        }
    </style>

    <div id="app" x-data="app">

        <div class="page-title">

            <div class="row">
                <div class="col-md-10 ">
                    <h3>Projetos</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="{{ route('chamados-projetos') }}">{{ $request['nm_oficina'] ?? 'Relação' }}</a></li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-2" style="text-align: right; ">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-6" style="text-align: right;">

                            <div class="btn-group">

                                <a href="#" class="btn btn-default" x-on:click="modalCriar()" >
                                    <span aria-hidden="true" class="icon-plus"></span>
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

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

        <div class="row" style="margin-left: 3px; margin-right: 3px;">

            <div class="col-lg-2 col-md-4" style="padding-right: 3px; padding-left: 3px;">
                <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;" >
                    <div class="panel-body" style="padding: 10px;">
                        <div class="info-box-stats">
                            <p class="counter" x-html="header.card1"></p>
                            <span class="info-box-title">OS Abertas</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="glyphicon glyphicon-folder-open icon-bar" ></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard1 + '%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-12" style="padding: 0px; ">

                <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                    <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;" >
                        <div class="panel-body" style="padding: 10px;">
                            <div class="info-box-stats">
                                <p class="counter" x-html="header.card2"></p>
                                <span class="info-box-title">Aguardando Aprazamento</span>
                            </div>
                            <div class="info-box-icon">
                                <i class="glyphicon glyphicon-calendar icon-bar-warning"></i>
                            </div>
                            <div class="info-box-progress">
                                <div class="progress progress-xs progress-squared bs-n">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40"
                                        aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard2 + '%'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                    <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;" >
                        <div class="panel-body" style="padding: 10px;">
                            <div class="info-box-stats">
                                <p class="counter" x-html="header.card3"></p>
                                <span class="info-box-title">Dentro do Prazo</span>
                            </div>
                            <div class="info-box-icon">
                                <i class="glyphicon glyphicon-ok-circle icon-bar-success"></i>
                            </div>
                            <div class="info-box-progress">
                                <div class="progress progress-xs progress-squared bs-n">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                        aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard3 + '%'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                    <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;" >
                        <div class="panel-body" style="padding: 10px;">
                            <div class="info-box-stats">
                                <p class="counter" x-html="header.card4"></p>
                                <span class="info-box-title">Vencendo</span>
                            </div>
                            <div class="info-box-icon">
                                <i class="glyphicon glyphicon-exclamation-sign icon-bar-alert"></i>
                            </div>
                            <div class="info-box-progress">
                                <div class="progress progress-xs progress-squared bs-n">
                                    <div class="progress-bar progress-bar-alert" role="progressbar" aria-valuenow="80"
                                        aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard4 + '%'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" style="padding-right: 3px; padding-left: 3px;">
                    <div class="panel info-box panel-white" style="margin: 10px; margin-left: 0px; margin-right: 0px;" >
                        <div class="panel-body" style="padding: 10px;">
                            <div class="info-box-stats">
                                <p class="counter" x-html="header.card5"></p>
                                <span class="info-box-title">Vencidos</span>
                            </div>
                            <div class="info-box-icon">
                                <i class="glyphicon glyphicon-remove-circle icon-bar-danger"></i>
                            </div>
                            <div class="info-box-progress">
                                <div class="progress progress-xs progress-squared bs-n">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50"
                                        aria-valuemin="0" aria-valuemax="100" :style="'width: ' + header.Pcard5 + '%'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="col-md-12 " style="padding: 0px;">
            <div class="panel panel-white" style="padding-bottom: 0px;">
                <div class="panel-heading" style="height: auto; padding-bottom: 0px;">

                    <form x-on:submit.prevent="getPage()" class="panel panel-white" id="form-chamados"
                        style="margin-bottom: 15px;">
                        <input type="hidden" name="tp_pagina" value="projeto" />
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group @if ($errors->has('dti')) has-error @endif ">
                                    <input type="date" class="form-control" value="{{ old('dti', $request['dti']) }}"
                                        placeholder="Data Inicial" name="dti" required />
                                </div>
                            </div>
                            <div class="col-md-2">
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

                            <div class="col-md-3" style="padding-left: 0px;">
                                <div class="form-group @if ($errors->has('descricao')) has-error @endif ">
                                    <input type="text" class="form-control" placeholder="Descrição do Chamado"
                                        name="descricao" />
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;">
                                <div class="form-group @if ($errors->has('setor')) has-error @endif ">
                                    <select class="form-control" name="setor" >
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
                                            <option value="{{ $func->cd_func }}" @if(Auth::user()->cd_funcionario == $func->cd_func) selected @endif>{{ $func->nm_func }}</option>
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
                                <th>Dias</th>
                                <th class="text-center">Situação</th>
                            </tr>
                        </thead>

                        <tbody>
                            <template x-if="!loading">
                                <template x-for="(os, index) in queryChamados" :key="index">
                                    <tr x-bind:id="`tr-chamado-${os.cd_os}`" >
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
                                            <span x-on:click="modal(os,index)"
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

        @include('acma.modal_os.criacao_os', ['request' => $request])

    </div>

    <x-slot name="scripts">
        <script>

        window.setor = {!! json_encode($request['setor']) !!};
        window.localidade = {!! json_encode($request['localidade']) !!};
        window.tela = 'projeto';

        </script>
        <script src="{{ asset('js/acma/chamados.js') }}"></script>
    </x-slot>
</x-layout.acma.layout>
