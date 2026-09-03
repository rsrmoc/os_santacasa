        <div class="modal fade modalCriar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myLargeModalLabel">Criação de Ordem de Serviço</h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation" class="active" ><a href="#tabOsSuporte" role="tab"
                                        data-toggle="tab">OS Suporte</a></li>
                                <li role="presentation" ><a href="#tabOsCriar" role="tab"
                                        data-toggle="tab">Criação de OS</a></li>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane  active fade in" id="tabOsSuporte">
                                        <form x-on:submit.prevent="getOsSuporte" class="panel panel-white"
                                            id="form-os-suporte">
                                            <input type="hidden" name="tp_form" value="suporte">
                                            <div class="row">
                                                <div class="col-md-12" style="padding: 0px">

                                                    <div class="col-md-5" style="padding-left: 5px" >
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Tipo de OS: <span class="red normal">
                                                                    *</span></label>
                                                            <select class="form-control" name="tipo"
                                                                id="id_tipo_os_suporte" required
                                                                style="width: 100%;">
                                                                <option value=""> Tipo de OS</option>
                                                                @foreach ($request['tipos'] as $tipo)
                                                                    <option value="{{ $tipo->cd_tipo_os }}" @if($tipo->cd_tipo_os == $request['Config']->cd_tipo_suporte) selected @endif> {{ $tipo->ds_tipo_os }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5" style="padding-left: 0px">
                                                        <div
                                                            class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Oficina: <span class="red normal"> *</span></label>
                                                            <select class="form-control" name="oficina"
                                                                id="id_oficina_suporte" required
                                                                style="width: 100%;">
                                                                <option value=""> Selecione a Oficina</option>
                                                                @foreach ($request['oficina'] as $oficina)
                                                                    <option value="{{ $oficina->cd_oficina }}" @if($oficina->cd_oficina == Auth::user()->cd_oficina) selected @endif>
                                                                        {{ $oficina->ds_oficina }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" style="padding-left: 0px; padding-right: 5px;">
                                                        <div
                                                            class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                                            <label>Usuario: <span class="red normal"> </span></label>
                                                            <div class="form-control" ><b>{{ Auth::user()->email }}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 5px">
                                                        <div
                                                            class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Setor: <span class="red normal"> *</span></label>
                                                            <select class="form-control" name="setor" id="id_setor_suporte" style="width: 100%;">
                                                                <option value="">Selecione o Setor</option>
                                                                @foreach ($request['setor'] as $setor)
                                                                    <option value="{{ $setor->cd_setor }}">{{ $setor->nm_setor }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 5px; padding-right: 5px">
                                                        <div
                                                            class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Localidade: <span class="red normal"> *</span></label>
                                                            <select class="form-control" name="localidade"
                                                                id="id_localidade_suporte" required
                                                                style="width: 100%;">
                                                                <option value=""> Selecione a Localidade</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding-left: 5px; padding-right: 5px">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Descrição: <span class="red normal"> *</span></label>
                                                            <input type="text" class="form-control" name="descricao" value="{{ $request['Config']->os_suporte ?? '' }}" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding-left: 5px; padding-right: 5px">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Observação: <span class="red normal"> *</span></label>
                                                            <textarea class="form-control" name="observacao" required style="height: 80px;">{{ $request['Config']->os_suporte ?? '' }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-center"
                                                        style="margin-bottom: 20px; margin-top: 10px; padding-left: 5px; padding-right: 5px">
                                                        <template x-if="buttonSalvar">
                                                            <button type="submit" style="width: 100%"
                                                                class="btn btn-info"><i
                                                                    class="fa fa-spinner fa-spin"></i>
                                                                Salvando</button>
                                                        </template>
                                                        <template x-if="!buttonSalvar">
                                                            <button type="submit" style="width: 100%"
                                                                class="btn btn-info"><i class="fa fa-check"></i>
                                                                Salvar</button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                        <h3 class="text-center" style="font-style: italic; font-weight: 400;  ">
                                            Ordem de Serviço em Andamento</h3>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <template x-if="queryOsAndamento.length > 0">
                                                    <table class="table table-striped" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>OS</th>
                                                                <th>Data</th>
                                                                <th>Oficina</th>
                                                                <th>Tipo</th>
                                                                <th>Setor</th>
                                                                <th class="text-center">Finalizar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <template x-for="os in queryOsAndamento">
                                                                <tr>
                                                                    <th x-text="os.tab_solicitacao?.cd_os" > </th>
                                                                    <td x-text="formatDate(os.tab_solicitacao?.dt_pedido, 'DD/MM/YYYY HH:mm')" > </td>
                                                                    <td x-text="os.tab_solicitacao?.tab_oficina?.ds_oficina" > </td>
                                                                    <td x-text="os.tab_solicitacao?.tab_tipo_os?.ds_tipo_os" > </td>
                                                                    <td x-text="os.tab_solicitacao?.tab_setor?.nm_setor" > </td>
                                                                    <td class="text-center" >
                                                                        <i style=" color: #12AFCB; cursor: pointer; font-size: 110%"
                                                                           class="fa fa-check-square-o " x-on:click="finalizarOs(os.tab_solicitacao?.cd_os)" title="Finalizar"></i>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </template>
                                            </div>
                                        </div>
                                        <template x-if="queryOsAndamento.length === 0">
                                            <div style="text-align: center">
                                                <img src="{{ asset('assets/images/em-andamento.png') }}"
                                                    style="max-width: 100px; margin-top: 30px;"
                                                    class="img-fluid mx-auto d-block">
                                                <br>Nenhuma OS encontrada.
                                            </div>
                                        </template>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="tabOsCriar">
                                        <form x-on:submit.prevent="getOsCriar" class="panel panel-white"
                                            id="form-os-criar">
                                            <input type="hidden" name="tp_form" value="criar">
                                            <div class="row">
                                                <div class="col-md-12" style="padding: 0px">

                                                    <div class="col-md-5" style="padding-left: 5px" >
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Tipo de OS: <span class="red normal">
                                                                    *</span></label>
                                                            <select class="form-control" name="tipo"  required
                                                                style="width: 100%;">
                                                                <option value=""> Tipo de OS</option>
                                                                @foreach ($request['tipos'] as $tipo)
                                                                    <option value="{{ $tipo->cd_tipo_os }}"  > {{ $tipo->ds_tipo_os }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5" style="padding-left: 0px">
                                                        <div
                                                            class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Oficina: <span class="red normal"> *</span></label>
                                                            <select class="form-control" name="oficina"  required
                                                                style="width: 100%;">
                                                                <option value=""> Selecione a Oficina</option>
                                                                @foreach ($request['oficina'] as $oficina)
                                                                    <option value="{{ $oficina->cd_oficina }}"  >
                                                                        {{ $oficina->ds_oficina }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" style="padding-left: 0px; padding-right: 5px;">
                                                        <div
                                                            class="form-group @if ($errors->has('situacao')) has-error @endif ">
                                                            <label>Usuario: <span class="red normal"> </span></label>
                                                            <div class="form-control" ><b>{{ Auth::user()->email }}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 5px">
                                                        <div
                                                            class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Setor: <span class="red normal"> *</span></label>
                                                            <select class="form-control" name="setor" id="id_setor_criar" style="width: 100%;">
                                                                <option value="">Selecione o Setor</option>
                                                                @foreach ($request['setor'] as $setor)
                                                                    <option value="{{ $setor->cd_setor }}">{{ $setor->nm_setor }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 5px; padding-right: 5px">
                                                        <div
                                                            class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Localidade: <span class="red normal"> *</span></label>
                                                            <select class="form-control" name="localidade"
                                                                id="id_localidade_criar" required
                                                                style="width: 100%;">
                                                                <option value=""> Selecione a Localidade</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding-left: 5px; padding-right: 5px">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Descrição: <span class="red normal"> *</span></label>
                                                            <input type="text" class="form-control" name="descricao" value="" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding-left: 5px; padding-right: 5px">
                                                        <div class="form-group @if ($errors->has('tipo')) has-error @endif ">
                                                            <label>Observação: <span class="red normal"> *</span></label>
                                                            <textarea class="form-control" name="observacao" required style="height: 110px;"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-center"
                                                        style="margin-bottom: 20px; margin-top: 10px; padding-left: 5px; padding-right: 5px">
                                                        <template x-if="buttonSalvar">
                                                            <button type="submit" style="width: 100%"
                                                                class="btn btn-info"><i
                                                                    class="fa fa-spinner fa-spin"></i>
                                                                Salvando</button>
                                                        </template>
                                                        <template x-if="!buttonSalvar">
                                                            <button type="submit" style="width: 100%"
                                                                class="btn btn-info"><i class="fa fa-check"></i>
                                                                Salvar</button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
