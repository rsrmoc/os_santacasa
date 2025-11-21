<x-layout.brcondos_adv.layout>

    <div class="page-title">
        <h3>Negociações</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('controle-listar') }}">Relação</a></li>
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
    </style>
    <div id="app" x-data="app">
        <span x-show="isLoading">
            <div class="fa-3x CarregaPagina" style="  margin-top: 40%; text-align: center; margin: 0 auto; width: 100%; 
            height: 100%;   z-index: 9999999999; overflow: hidden;  "> <Br> 
                <!--<i class="fa fa-spinner fa-pulse has-text-danger" style="font-size: 2.5em; "></i>-->
                <img src="{{ asset('assets/images/logo_amaral.png') }}">
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


        <div class="col-md-12 ">
            <div class="panel panel-white" style="padding-bottom: 0px;">
                <div class="panel-heading" style="height: auto; padding-bottom: 0px;">

                    <form  class="panel panel-white" x-on:submit.prevent="getClientesPorFiltros(true)"
                        style="margin-bottom: 15px;">

                        <div class="row"> 
                            <div class="col-md-2">
                                <div class="form-group @if ($errors->has('dti')) has-error @endif ">
                                    <input type="date" class="form-control" value=""
                                        placeholder="Data Inicial" name="dti" x-model="inputsFiltros.dti"  /> 
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group @if ($errors->has('dtf')) has-error @endif ">
                                    <input type="date" class="form-control" value=""
                                        placeholder="Data Final" name="dtf" x-model="inputsFiltros.dtf" /> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @if ($errors->has('nome')) has-error @endif ">
                                    <input type="text" class="form-control" value="" placeholder="Nome do Cliente" 
                                    x-model="inputsFiltros.nome" name="nome" />
                                    @if ($errors->has('nome'))
                                        <div class="error">{{ $errors->first('nome') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group @if ($errors->has('cpf')) has-error @endif ">
                                    <input type="text" class="form-control" value=""
                                        placeholder="Cnpj/Cpf" name="cpf" x-model="inputsFiltros.cpf"
                                        x-mask:dynamic="$input.length > 14
                                            ? '99.999.999/9999-99' : '999.999.999-99'" />
                                    @if ($errors->has('cpf'))
                                        <div class="error">{{ $errors->first('cpf') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group @if ($errors->has('titulo')) has-error @endif ">
                                    <input type="text" class="form-control"
                                        value="" placeholder="Negociação" x-model="inputsFiltros.negoc"
                                        name="titulo" />
                                    @if ($errors->has('titulo'))
                                        <div class="error">{{ $errors->first('titulo') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                     

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group @if ($errors->has('condominio')) has-error @endif ">
                                    <select class="form-control" name="condominio" id="select-condominio" x-model="inputsFiltros.condominio">
                                        <option value="">Condomínio</option>
                                        @foreach ($condominios as $tab)
                                            <option value="{{ $tab->cd_condominio }}"
                                                @if (old('condominio', $request['condominio']) == $tab->cd_condominio) selected @endif>
                                                {{ $tab->nm_condominio }}</option>
                                        @endforeach
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group @if ($errors->has('bloco')) has-error @endif ">
                                    <input type="text" class="form-control" x-model="inputsFiltros.bloco"
                                        value="" placeholder="Bloco / Apto"
                                        name="bloco" /> 
                                </div>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class=" col-md-12 btn btn-info">
                                    <i class="fa fa-search-plus"></i> Pesquisar
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"> 
                                <div class="checkbox" style="margin-top:0px;margin-bottom:5px;">
                                    <label style="  padding-left:0px;">
                                        <input type="checkbox" x-model="inputsFiltros.status" name="status[]" value="AGUARDANDO"> Aguardando
                                    </label>
                                </div>
                            </div>  
                            <div class="col-md-2"> 
                                <div class="checkbox" style="margin-top:0px;margin-bottom:5px;">
                                    <label>
                                        <input type="checkbox" x-model="inputsFiltros.status" name="status[]" value="ABERTO"> Aberto
                                    </label>
                                </div>
                            </div> 
                            <div class="col-md-2"> 
                                <div class="checkbox" style="margin-top:0px;margin-bottom:5px;">
                                    <label style="  padding-left:0px;">
                                        <input type="checkbox" x-model="inputsFiltros.status" name="status[]" value="ATRASADO"> Atrasado
                                    </label>
                                </div>
                            </div>  
                            <div class="col-md-2"> 
                                <div class="checkbox" style="margin-top:0px;margin-bottom:5px;">
                                    <label style="  padding-left:0px;">
                                        <input type="checkbox" x-model="inputsFiltros.status" name="status[]" value="FECHADO"> Fechado
                                    </label>
                                </div>
                            </div>  
                        </div>

                    </form>
                </div>

                <div class="panel-body">

                    <table class="table table-striped" style="margin-bottom: 0">
                        <thead>
                            <tr class="active">
                                <th>Negociação</th>
                                <th>Data </th>
                                <th>Nome </th>
                                <th>Condomínio</th> 
                                <th class="text-right"> Valor Negociação</th>  
                                <th class="text-right">Qtde. Boleto</th>    
                                <th class="text-right">Valor Boleto</th>    
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <template x-if="!loading">
                                <template x-for="boleto in boletos">
                                    <tr x-bind:id="`tr-condominio-${boleto.cd_negociacao}`">
                                        <th x-text="('0000' + boleto.cd_negociacao ).slice(-4)"></th>
                                        <td x-text="boleto.data_negociacao"></td>
                                        <td x-text="boleto.nm_cliente"></td>
                                        <td x-text="boleto.condominio.nm_condominio"></td> 
                                        <td class="text-right" x-text="boleto.vl_negociacao"></td>  
                                        <td class="text-right" x-text="( boleto.boletos.qtde ) ? boleto.boletos.qtde : '0'"></td> 
                                        <td class="text-right" x-text="( boleto.boletos.vl_boleto ) ? boleto.boletos.vl_boleto : '0,00'"></td> 

                                        <td class="text-center" style="padding: 3px!important;">

                                            <template x-if="boleto.status == 'AGUARDANDO' ">
                                                <span class="label label-default" x-text="boleto.status" data-toggle="modal" style="cursor: pointer"  
                                                data-target="#cadastro-consulta"   x-on:click="verDetalhes(boleto)"></span>
                                            </template>
                                            <template x-if="boleto.status == 'ABERTO' ">
                                                <span class="label label-warning" x-text="boleto.status" data-toggle="modal" style="cursor: pointer"  
                                                data-target="#cadastro-consulta"   x-on:click="verDetalhes(boleto)"></span>
                                            </template>
                                            <template x-if="boleto.status == 'ATRASADO' ">
                                                <span class="label label-danger" x-text="boleto.status" data-toggle="modal" style="cursor: pointer"  
                                                data-target="#cadastro-consulta"   x-on:click="verDetalhes(boleto)"></span>
                                            </template>
                                            <template x-if="boleto.status == 'FECHADO' ">
                                                <span class="label label-success" x-text="boleto.status" data-toggle="modal" style="cursor: pointer"  
                                                data-target="#cadastro-consulta"   x-on:click="verDetalhes(boleto)"></span>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>
 
                    <template x-if="loading">
                        <x-loader />
                    </template>
                    
                    <div style="float: right"> 
                        <span x-html="Pagination"></span> 
                    </div>
   
                </div>
            </div>
        </div>

        <div class="modal fade" id="cadastro-consulta">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header m-b-sm">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" style="font-size: 20px; font-weight: 300; color: #74767d;">
                            <span x-text="`${negocSelecionado?.nm_cliente} #${negocSelecionado?.cpf_cnpj_cliente}`"></span>
                        </h4>
                    </div>

                    <div class="modal-body">

                        <div class="panel-body" style="padding: 0px;">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation" class="active"><a href="#tab-fatura" role="tab"
                                        data-toggle="tab">Dados da Negociação</a></li>
                                <li role="presentation"><a href="#tab-neg" role="tab"
                                        data-toggle="tab">Titulos</a></li>
                                <li role="presentation"><a href="#tab-historico" role="tab"
                                        data-toggle="tab">Historico</a></li>
                                <li role="presentation"><a href="#tab-envio" role="tab"
                                        data-toggle="tab">Envios</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active fade in" id="tab-fatura">
 
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            <tr> 
                                                <td colspan="6">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <td style="width: 33%;">
                                                                <label style=" font-weight: 700; ">Codigo da Negociação: </label><br>
                                                                <span x-text=" ('0000' + negocSelecionado.cd_negociacao ).slice(-4)"></span>
                                                            </td>
                                                            <td style="width: 33%;">
                                                                <label style=" font-weight: 700; ">Data da Negociação: </label><br>
                                                                <span x-text="negocSelecionado.data_negociacao">  </span>
                                                            </td>
                                                            <td style="width: 33%;">
                                                                <label style=" font-weight: 700; ">Situação da Negociação: </label><br>
                                                                <span x-text="negocSelecionado.status"></span>
                                                            </td>
                                                        </tr>
                                                    </table> 
                                                </td> 
                                            </tr> 
                                            <tr>
                                                <td colspan="3">
                                                    <label style=" font-weight: 700; ">Nome do Cliente: </label>
                                                    <span x-text="negocSelecionado?.nm_cliente"></span>
                                                </td>
                                                <td colspan="3">
                                                    <label style=" font-weight: 700; ">CPF: </label>
                                                    <span x-text="negocSelecionado?.cpf_cnpj_cliente"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <label style=" font-weight: 700; ">Condomínio: </label>
                                                    <span x-text="negocSelecionado?.condominio.nm_condominio"></span>
                                                </td> 
                                            </tr> 
                                            <tr>
                                                <td colspan="3">
                                                    <label style=" font-weight: 700; ">Contato do Cliente: </label>
                                                    <span x-text="negocSelecionado?.nr_contato"></span>
                                                </td>
                                                <td colspan="3">
                                                    <label style=" font-weight: 700; ">Email do Cliente: </label>
                                                    <span x-text="negocSelecionado?.email_cliente"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <label style=" font-weight: 700; ">Responsável : </label>
                                                    <span x-text="negocSelecionado?.name"></span>
                                                </td> 
                                            </tr> 
                                            <tr>
                                                <td colspan="6">
                                                    <label style=" font-weight: 700; ">Observações : </label>
                                                    <span x-text="negocSelecionado?.obs"></span>
                                                </td> 
                                            </tr> 
                                        </tbody>
                                    </table>

                                  
                                </div>


                                <div role="tabpanel" class="tab-pane fade" id="tab-neg">
                                     
                                    
                                    <table class="table table-striped table-hover">
                                            <tbody>
                                                <tr> 
                                                    <td colspan="6">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td style="width: 33%;">
                                                                    <label style=" font-weight: 700; ">Codigo da Negociação: </label><br>
                                                                    <span x-text=" ('0000' + negocSelecionado.cd_negociacao ).slice(-4)"></span>
                                                                </td>
                                                                <td style="width: 33%;">
                                                                    <label style=" font-weight: 700; ">Data da Negociação: </label><br>
                                                                    <span x-text="negocSelecionado.data_negociacao">  </span>
                                                                </td>
                                                                <td style="width: 33%;">
                                                                    <label style=" font-weight: 700; ">Situação da Negociação: </label><br>
                                                                    <span x-text="negocSelecionado.status"></span>
                                                                </td>
                                                            </tr>
                                                        </table> 
                                                    </td> 
                                                </tr> 
                                            </tbody>
                                    </table>
                                    <form class="col-md-12" id="formBoletos" x-on:submit.prevent="salvarBoletos">
                                        <table class="table table-striped table-vertical-middle" style="margin-bottom: 0; margin-top: 10px;">
                                            <thead>
                                                <tr  >
                                                    <th  class="text-right" ></th>
                                                    <template x-if="addAcordos">
                                                        <th colspan="5" class="text-center" style="font-size: 17px;  font-weight: 400; color: #74767d;">Relação de Boletos </th>
                                                    </template>
                                                    <template x-if="addAcordos==false">
                                                        <th colspan="4" class="text-center" style="font-size: 17px;  font-weight: 400; color: #74767d;">Relação de Boletos </th>
                                                    </template>
                                                    <th  class="text-right" > <i x-on:click="getBoletosAcordos(negocSelecionado,'TODOS')" class="fa fa-search-plus btn btn-info"></i> </th>
                                                </tr>
                                                <tr class="active">
                                                    <template x-if="addAcordos">
                                                        <th class="text-center">#</th>               
                                                    </template>
                                                    <th class="text-center">Boleto</th> 
                                                    <th class="text-center">Emissão </th>  
                                                    <th class="text-center">Vencimento</th>    
                                                    <th>Nr.Doc</th>   
                                                    <th class="text-right">Valor</th>     
                                                    <th class="text-center" >Situação</th> 
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <template x-for="boleto in boletosAcordos">
                                                    <tr>
                                                        <template x-if="addAcordos"> 
                                                            <td class="text-center">
                                                                <input type="checkbox" x-model="inputBoletos.cd_boletos"    x-bind:value="boleto.cd_boleto" >
                                                            </td>
                                                        </template>
                                                        <th class="text-center" x-text="boleto.id_boleto"></th> 
                                                        <td class="text-center" x-text="boleto.data_emissao"></td>
                                                        <td class="text-center" x-text="boleto.data_vencimento"></td>
                                                        <td x-text="boleto.nr_documento"></td>  
                                                        <td class="text-right" x-text="boleto.valor"></td>
                                                        <td class="text-center" >
                                                            <span  x-bind:class="'label label-'+boleto.tp_status"  
                                                                x-text="boleto.status" style="width: 100%;"></span>
                                                        </td> 
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                        <template x-if="addAcordos && !loadingDetalhesBoletosAtrasados && boletosAcordos.length > 0" >
                                            <div style="text-align: center; width: 100%; margin-top: 15px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Salvar</button>
                                            </div> 
                                        </template>
                                    </form>
                                    <template x-if="loadingDetalhesBoletosAtrasados">
                                        <x-loader />
                                    </template>

                                    <template x-if="!loadingDetalhesBoletosAtrasados && boletosAcordos.length == 0">
                                        <p class="text-center" style="padding-top: 24px"> 
                                        Nenhum Boleto foi vinculado com essa negociação
                                        <br>
                                        <img src="{{ asset('assets/images/negociation.png') }}"></p>
                                    </template>
                                    

                                 </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab-historico">
                                    <div class="row m-b-md">
                                        <form class="col-md-12" x-on:submit.prevent="cadastrarHistorico">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Informar Historico</label>
                                                <textarea class="form-control" id="exampleInputEmail1" required style="height: 120px"
                                                    x-model="inputFormHistorico"></textarea>
                                            </div>

                                            <div style="display:flex; gap: 10px; align-items:center">
                                                <button type="submit" class="btn btn-primary">Salvar</button>

                                                <template x-if="editCDHistorico">
                                                    <button type="reset" class="btn btn-light" x-on:click="clearEdicaoHistorico()">Cancelar</button>
                                                </template>

                                                <template x-if="loadingFormHistorico">
                                                    <x-loader style="padding: 0 !important" />
                                                </template>
                                            </div>
                                        </form>
                                    </div>

                                    <template x-for="historico in historicosCliente">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="active">
                                                    <td>
                                                        <strong>Data do Histórico</strong><br/>
                                                        <span x-text="formatDate(historico.created_at)+' '+formatDate(historico.created_at, 'LT')"></span>
                                                    </td>
                                                    <td>
                                                        <strong>Usuário do Histórico</strong><br/>
                                                        <span x-text="historico.usuario.name"></span>
                                                    </td>

                                                    <td>
                                                        <div style="display: flex; justify-content: flex-end">
                                                            <button class="btn btn-sm btn-success" type="button" x-on:click="setEdicaoHistorico(historico)">
                                                                <i class="fa fa-edit"></i>
                                                            </button>

                                                            <button class="btn btn-sm btn-danger" type="button" x-on:click="excluirHistorico(historico.cd_historico)">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr > 
                                                    <td colspan="3">
                                                        <span x-text="historico.historico"></span>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </template>
                                </div>


                                <div role="tabpanel" class="tab-pane fade" id="tab-envio">
                                     ...
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="display: flex; justify-content: flex-end; align-items: center">
                        <template x-if="loadingEnviarHistorico">
                            <x-loader style="padding: 0 !important; margin-right: 20px"/>
                        </template>
                       <!-- <button type="button" class="btn btn-success" x-on:click="enviarHistorico" x-bind:disabled="loadingEnviarHistorico">Enviar histórico por email</button> -->
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
 

    </div>

    <x-slot name="scripts">
        <style>
            .table.table-striped:last-child {
                margin-bottom: 0;
            }
        </style>
        <script src="{{ asset('js/paginas/negociacoes.js') }}"></script>
    </x-slot>
</x-layout.brcondos_adv.layout>
