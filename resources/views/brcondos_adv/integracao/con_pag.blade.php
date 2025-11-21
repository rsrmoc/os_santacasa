<x-layout.brcondos_adv.layout>
    <div class="page-title">
        <h3>BOT </h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('usuarios-listar') }}">Contas a Pagar</a></li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper" x-data="appPagar">
        <div class="col-md-12 ">
            <form class="panel panel-white" x-on:submit.prevent="save" id="formPagar">
                @csrf

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group @if($errors->has('tipo')) has-error @endif ">
                                <label for="fname">Tipo de Data: <span class="red normal">*</span></label>
                                <select class="form-control" name="tipo" required id="select-tipo">
                                    <option value="">SELECIONE</option>
                                    <option value="Vencimento" @if(old('tipo')=='Vencimento') selected @endif >VENCIMENTO</option>
                                    <option value="Pagamento" @if(old('tipo')=='Pagamento') selected @endif>PAGAMENTO</option> 
                                    <option value="E" @if(old('tipo')=='E') selected @endif>EMISSÃO</option> 
                                    <option value="X" @if(old('tipo')=='XE') selected @endif>EXCLUSÃO</option> 
                                </select>
                                @if($errors->has('tipo'))
                                    <div class="error">{{ $errors->first('tipo') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('dti')) has-error @endif ">
                                <label for="fname">Data Inicial: <span class="red normal">*</span></label>
                                <input type="date" class="form-control" value="{{old('dti')}}" placeholder="Data Inicial" name="dti" required x-model="inputs.dti" />
                                @if($errors->has('dti'))
                                    <div class="error">{{ $errors->first('dti') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('dtf')) has-error @endif ">
                                <label for="fname">Data Final: <span class="red normal">*</span></label>
                                <input type="date" class="form-control" value="{{old('dtf')}}" placeholder="Data Final" name="dtf" required x-model="inputs.dtf" />
                                @if($errors->has('dtf'))
                                    <div class="error">{{ $errors->first('dtf') }}</div>
                                @endif
                            </div>
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group @if($errors->has('status')) has-error @endif ">
                                <label for="fname">Status: <span class="red normal"> </span></label>
                                <select class="form-control" name="status" id="select-status">
                                    <option value="0" @if(old('status')=='0') selected @endif>TODOS</option>
                                    <option value="1" @if(old('status')=='1') selected @endif >ABERTAS</option>
                                    <option value="2" @if(old('status')=='2') selected @endif>PAGAS</option>  
                                </select>
                                @if($errors->has('status'))
                                    <div class="error">{{ $errors->first('status') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group @if($errors->has('excluido')) has-error @endif ">
                                <label for="fname">Exluidos: <span class="red normal"> </span></label>
                                <select class="form-control" name="excluido" id="select-excluido">
                                    <option value="">TODOS</option>
                                    <option value="1" @if(old('excluido')=='1') selected @endif >SIM</option>
                                    <option value="0" @if(old('excluido')=='0') selected @endif>NÃO</option>  
                                </select>
                                @if($errors->has('excluido'))
                                    <div class="error">{{ $errors->first('excluido') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('cpf')) has-error @endif ">
                                <label for="fname">CPF/CNPJ: <span class="red normal"> </span></label>
                                <input type="text" class="form-control" value="{{old('cpf')}}" placeholder="CPF/CNPJ" name="cpf" x-model="inputs.cpf" />
                                @if($errors->has('cpf'))
                                  <div class="error">{{ $errors->first('cpf') }}</div>
                                @endif
                            </div>
                        </div> 
                        <div class="col-md-9">
                            <div class="form-group @if($errors->has('condominios')) has-error @endif ">
                                <label for="fname">Condomínios: <span class="red normal"></span></label>
                                <select class="form-control" multiple="multiple" name="condominios[]" id="select-condominios">
                                    <option value="">TODOS</option>
                                    @foreach($condominios as $condominio )
                                        <option value="{{$condominio->cd_condominio }}" @if(old('condominios')==$condominio->cd_condominio) selected @endif >{{ $condominio->nm_condominio }}</option> 
                                    @endforeach
                                </select>
                                @if($errors->has('condominios'))
                                    <div class="error">{{ $errors->first('condominios') }}</div>
                                @endif
                            </div>
                        </div> 

                    </div>

                </div>

                <div class="panel-footer" style="display: flex; align-items: center; gap: 10px">
                    <button class="btn btn-success" x-bind:disabled="loading">Iniciar Rotina</button>

                    <template x-if="loading">
                        <x-loader style="padding: 0" />
                    </template>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('js/paginas/contas/pagar.js') }}"></script>
    </x-slot>
</x-layout.brcondos_adv.layout>
