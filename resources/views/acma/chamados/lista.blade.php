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

        <div class="modal fade modalOS" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <template x-if="queryModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myLargeModalLabel" x-html="'OS: ' + queryModal.cd_os"></h4>
                    </div>
                    <div class="modal-body">

                        <div role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tabOS" role="tab"
                                        data-toggle="tab" aria-expanded="false">Dados da OS</a></li>
                                <li role="presentation" class=""><a href="#tabClassificar" role="tab"
                                        data-toggle="tab" aria-expanded="true">Classificar</a></li>
                                <li role="presentation" class=""><a href="#tabAprazar" role="tab"
                                        data-toggle="tab" aria-expanded="false">Aprazar OS</a></li>
                                <li role="presentation" class=""><a href="#tabServico" role="tab"
                                        data-toggle="tab" aria-expanded="false">Serviços</a></li>
                                <li role="presentation" class=""><a href="#tabControle" role="tab"
                                        data-toggle="tab" aria-expanded="false">Controle</a></li>

                                <template x-if="(queryModal.tab_situacao?.tipo ?? 'F')=='A'">
                                    <li role="presentation" class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown"
                                            href="#" role="button" x-on:click="fecharOs(queryModal.cd_os)" aria-expanded="false">
                                            <i  style="color: #08A7C3;" class="fa fa-check"></i> <b>Fechar Ordem de Serviço</b>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane fade active in" id="tabOS">

                                    <table class="table" style="margin-top: 10px;">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">  DADOS DO CHAMADO </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td x-html="'<b>DATA:</b> ' + formatDate(queryModal.dt_pedido, 'DD/MM/YYYY') "></td>
                                                <td x-html="'<b>TIPO:</b> ' + queryModal.tab_tipo_os?.ds_tipo_os"></td>
                                            </tr>
                                            <tr>
                                                <td x-html="'<b>SETOR:</b> ' +  queryModal.tab_setor?.nm_setor "></td>
                                                <td x-html="'<b>LOCALIDADE:</b> ' + queryModal.tab_localidade?.ds_localidade "></td>
                                            </tr>
                                            <tr>
                                                <td x-html="'<b>SOLICITANTE:</b> ' +  queryModal.nm_usuario "></td>
                                                <td x-html="'<b>NOME:</b> ' + queryModal.nm_solicitante"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" x-html="'<b>RESPONSÁVEL:</b> ' + (queryModal.tab_classificacao?.tab_responsavel?.nm_func  ?? ' -- ') "></td>
                                            </tr>
                                            <tr>
                                                <td x-html="'<b>PREVISÃO:</b> ' +  (queryModal.tab_classificacao?.dt_previsao ?? ' -- ') "></td>
                                                <td x-html="'<b>SITUAÇÃO:</b> ' + (queryModal.tab_situacao?.nm_situacao ?? ' -- ') "></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" x-html="'<b>DESCRIÇÃO:</b> ' + (queryModal.ds_servico ?? ' -- ') "></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" x-html="'<b>DETALHES:</b> ' + (queryModal.ds_observacao ?? ' -- ').replace(/\n/g, '<br>') "></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tabClassificar">

                                    <form x-on:submit.prevent="getClassificar" class="panel panel-white" id="form-classificar">

                                        <div class="row">
                                            <div class="col-md-12" style="padding: 0px">
                                                <div class="col-md-6">
                                                    <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                        <label>Tipo de OS: <span class="red normal"> *</span></label>
                                                        <select class="form-control" name="tipo" id="id_tipo_classificar" required style="width: 100%;" >
                                                            <option value=""> Tipo de OS</option>
                                                                @foreach ($request['tipos'] as $tipo)
                                                                    <option value="{{ $tipo->cd_tipo_os }}" > {{ $tipo->ds_tipo_os }} </option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                        <label>Oficina: <span class="red normal"> *</span></label>
                                                        <select class="form-control" name="oficina" id="id_oficina_classificar" required style="width: 100%;" >
                                                            <option value=""> Selecione a Oficina</option>
                                                            @foreach ($request['oficina'] as $oficina)
                                                                <option value="{{ $oficina->cd_oficina }}">{{ $oficina->ds_oficina }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group @if ($errors->has('responsavel')) has-error @endif ">
                                                        <label>Responsável: <span class="red normal">  </span></label>
                                                        <select class="form-control" name="responsavel" id="id_resp_classificar" style="width: 100%;" >
                                                            <option value=""> Selecione o Responsável</option>
                                                            @foreach ($request['func'] as $responsavel)
                                                                <option value="{{ $responsavel->cd_func }}">{{ $responsavel->nm_func }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                                        <label>Situação: <span class="red normal">  </span></label>
                                                        <div class="form-control" x-html="'<b>' +queryModal.tab_situacao?.nm_situacao + '</b>'"   > </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center" style="margin-bottom: 20px; margin-top: 10px">
                                                        <template x-if="buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-spinner fa-spin"></i> Salvando</button>
                                                        </template>
                                                        <template x-if="!buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-check"></i> Salvar</button>
                                                        </template>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tabAprazar">

                                    <form x-on:submit.prevent="getAprazar" class="panel panel-white" id="form-aprazar">

                                        <div class="row">
                                            <div class="col-md-12" style="padding: 0px">
                                                <div class="col-md-9">
                                                    <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                        <label>Email: <span class="red normal"> *</span></label>
                                                        <input type="text" class="form-control" name="email" required  >
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                        <label>Data de Previsão: <span class="red normal"> *</span></label>
                                                        <input type="date" class="form-control" name="dt_previsao" required  >
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                                        <label>Descrição: <span class="red normal">  </span></label>
                                                        <textarea class="form-control"  rows="6" name="descricao"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center" style="margin-bottom: 20px; margin-top: 10px">
                                                        <template x-if="buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-spinner fa-spin"></i> Salvando</button>
                                                        </template>
                                                        <template x-if="!buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-check"></i> Salvar</button>
                                                        </template>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                    <h3 class="text-center" style="font-style: italic; font-weight: 400;  ">Historico de Aprazamentos</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <template x-for="aprazamento in queryModal.tab_aprazamento"  >
                                                <table class="table table-striped" width="100%">
                                                    <thead>
                                                        <tr>
                                                        <td width="35%"><b>Data de Previsão : </b> <span x-text=" formatDate(aprazamento.dt_prazo)" ></span></td>
                                                        <td width="65%"><b>Responsável :</b> <span x-text="aprazamento.tab_responsavel?.nm_func"></span></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <td width="100%" colspan="2">
                                                            <b>Data do Envio: </b> <span x-text="formatDate(aprazamento.created_at)"></span><br>
                                                            <b>Email: </b> <span x-text="aprazamento.email"></span><br>
                                                            <b>Descrição: </b> <span x-html="aprazamento.descricao"></span>
                                                        </td>
                                                    </tbody>
                                                </table>
                                            </template>
                                        </div>
                                    </div>
                                    <template x-if="queryModal.tab_aprazamento.length === 0">
                                        <div style="text-align: center">
                                            <img src="{{ asset('assets/images/prazos.png') }}" style="max-width: 150px; margin-top: 30px;" class="img-fluid mx-auto d-block">
                                            <br>Nenhum aprazamento encontrado.
                                        </div>
                                    </template>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tabServico">

                                    <template x-if="(queryModal.tab_situacao?.tipo ?? 'F')=='F'">
                                        <h3 class="text-center " style="font-style: italic;margin-bottom: 10px;">
                                            <i class="fa fa-check-circle" style="color: #08A7C3;"></i> Ordem de Serviço Finalizada!<br>
                                            <button type="button" class="btn btn-info btn-rounded" style="margin-top: 5px;" x-on:click="reabrirOs(queryModal.cd_os)">
                                                <i class="fa fa-undo"></i>  Reabrir Ordem de Serviço
                                            </button>
                                        </h3>
                                    </template>

                                    <form x-on:submit.prevent="getServico" x-show="(queryModal.tab_situacao?.tipo ?? 'F')=='A'" class="panel panel-white" id="form-servico">

                                        <div class="row">
                                            <div class="col-md-12" style="padding: 0px">
                                                <div class="col-md-7" style="padding-left: 0px;">
                                                    <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                        <label>Serviço: <span class="red normal"> *</span></label>
                                                        <select class="form-control select2  " name="servico"
                                                          style="width: 100%" required>
                                                            <option value="">Selecione um serviço</option>
                                                            @foreach ($request['serv'] as $serv)
                                                                <option value="{{ $serv->cd_servico }}">{{ $serv->nm_servico }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5" style="padding-left: 0px; padding-right: 0px;">
                                                    <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                        <label>Funcionário: <span class="red normal"> *</span></label>
                                                        <select class="form-control" name="funcionario" style="width: 100%" required>
                                                            <option value="">Selecione um funcionário</option>
                                                            @foreach ($request['func'] as $func)
                                                                <option value="{{ $func->cd_func }}" @if((auth()->user()->cd_funcionario ?? '') == $func->cd_func) selected @endif>{{ $func->nm_func }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-7" style="padding: 0px">
                                                    <div class="col-md-12" style="padding-left: 0px">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Descrição: <span class="red normal"> *</span></label>
                                                            <textarea class="form-control" style="height: 95px;" name="descricao" required></textarea>
                                                        </div>
                                                    </div>
                                                        <div class=" col-sm-10" style="padding-left: 0px">
                                                            <div class="checkbox" style="margin-top: 0px;">
                                                                <label>
                                                                    <input name="fechar_os" type="checkbox"> <b>Fechar Ordem de Serviço</b>
                                                                </label>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-5" style="padding: 0px">
                                                    <div class="col-md-6" style="padding-left: 0px; padding-right: 5px;">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Inicio do Serviço: <span class="red normal"> *</span></label>
                                                            <input type="datetime-local" class="form-control"
                                                            name="dti" required id="id_inicio_servico" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 5px; padding-right: 0px  ">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Final do Serviço: <span class="red normal"> *</span></label>
                                                            <input type="datetime-local" class="form-control"
                                                            name="dtf" required id="id_fim_servico" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7" style="padding-left: 0px; padding-right: 5px;">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Tempo: <span class="red normal"> </span></label>
                                                            <select class="form-control" name="tempo" id="id_tempo_servico"
                                                            style="width: 100%"  >
                                                                    <option value=""> Selecione o tempo </option>
                                                                    <option value="15">15 Minutos</option>
                                                                    <option value="30">30 Minutos</option>
                                                                    <option value="60">1 hora</option>
                                                                    <option value="120">2 Horas </option>
                                                                    <option value="180">3 Horas</option>
                                                                    <option value="240">4 Horas</option>
                                                                    <option value="300">5 Horas</option>
                                                                    <option value="360">6 Horas</option>
                                                            </select>
                                                         </div>
                                                    </div>
                                                    <div class="col-md-5 text-center" style="margin-bottom: 20px; margin-top: 23px; padding-left: 0px; padding-right: 0px;">
                                                        <template x-if="buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-spinner fa-spin"></i> Salvando</button>
                                                        </template>
                                                        <template x-if="!buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-check"></i> Salvar</button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>

                                    <h3 class="text-center" style="font-style: italic; font-weight: 400;  ">Historico de Serviços Realizados</h3>
                                    <div class="row">
                                        <div class="col-md-12" style="padding: 0px">
                                            <template x-for="serv in queryModal.tab_it_solicitacao"  >
                                                <table class="table table-striped" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <td width="35%"><b>Data Inicial : </b> <span x-text="formatDate(serv.hr_inicio)" ></span></td>
                                                            <td width="35%"><b>Data Final :</b> <span x-text="formatDate(serv.hr_final)"></span></td>
                                                            <td width="25%"><b>Tempo :</b> <span x-text="serv.vl_tempo_gasto.toString().padStart(2, '0') + ':' + serv.vl_tempo_gasto_min.toString().padStart(2, '0')"></span></td>
                                                            <td width="5%" style="text-align: right" x-show="(queryModal.tab_situacao?.tipo ?? 'F')=='A'"> <i  style="cursor: pointer;" x-on:click="deleteServico(serv.cd_itsolicitacao_os)" class="red fa fa-trash"></i>  </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100%" colspan="4"><b>Funcionario : </b> <span x-text=" serv.cd_func + ' - ' + serv.tab_func?.nm_func"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100%" colspan="4"><b>Serviço : </b> <span x-text=" serv.cd_servico + ' - ' + serv.tab_servico?.nm_servico"></span></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <td width="100%" colspan="4">
                                                            <b>Descrição: </b> <span x-html="serv.ds_servico"></span>
                                                        </td>
                                                    </tbody>
                                                </table>
                                            </template>
                                        </div>
                                    </div>
                                    <template x-if="(queryModal.tab_it_solicitacao?.length ?? 0) === 0">
                                        <div style="text-align: center">
                                            <img src="{{ asset('assets/images/servico.png') }}" style="max-width: 150px; margin-top: 30px;" class="img-fluid mx-auto d-block">
                                            <br>Nenhum serviço realizado encontrado.
                                        </div>
                                    </template>

                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tabControle">

                                    <form x-on:submit.prevent="getObs" class="panel panel-white" id="form-obs">

                                        <div class="row">
                                            <div class="col-md-12" style="padding: 0px">
                                                <div class="col-md-12">
                                                    <div class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                                        <label>Descrição: <span class="red normal">  </span></label>
                                                        <textarea class="form-control"  rows="6" name="descricao"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center" style="margin-bottom: 20px; margin-top: 10px">
                                                        <template x-if="buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-spinner fa-spin"></i> Salvando</button>
                                                        </template>
                                                        <template x-if="!buttonSalvar">
                                                            <button type="submit" style="width: 100%" class="btn btn-info"><i class="fa fa-check"></i> Salvar</button>
                                                        </template>

                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                    <h3 class="text-center" style="font-style: italic; font-weight: 400;  ">Historico </h3>
                                    <div class="row">
                                        <div class="col-md-12" style="padding: 0px">
                                            <template x-for="obs in queryModal.tab_observacao"  >
                                                <table class="table table-striped" width="100%">
                                                    <thead>
                                                        <tr>
                                                        <td width="35%"><b>Data da Observação : </b> <span x-text=" formatDate(obs.created_at)" ></span></td>
                                                        <td width="65%"><b>Usuario :</b> <span x-text="obs.cd_usuario + ' - ' + obs.tab_func?.nm_usuario"></span></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <td width="100%" colspan="2">
                                                            <b>Descrição: </b> <span x-html="obs.obs"></span>
                                                        </td>
                                                    </tbody>
                                                </table>
                                            </template>
                                        </div>
                                    </div>
                                    <template x-if="queryModal.tab_observacao.length === 0">
                                        <div style="text-align: center">
                                            <img src="{{ asset('assets/images/historico-de-transacoes.png') }}" style="max-width: 150px; margin-top: 30px;" class="img-fluid mx-auto d-block">
                                            <br>Nenhum historico encontrado.
                                        </div>
                                    </template>

                                </div>



                            </div>
                        </div>
                    </div>

                </div>
                </template>
            </div>
        </div>



    </div>

    <x-slot name="scripts">
        <script src="{{ asset('js/acma/chamados.js') }}"></script>
    </x-slot>
</x-layout.acma.layout>
