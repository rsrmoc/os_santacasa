<x-layout.brcondos_adv.layout>

    <div class="page-title">
        <h3>Cadastro de Condominios</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('condominios-criar')}}">Cadastrar</a></li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="col-md-12 ">
            <div class="panel panel-white">
                <div class="panel-body">
                    @error('error')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <form role="form"  action="{{ route('condominios-update', ['condominio' => $condominio->chave])  }}" method="post"
                        role="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group @if($errors->has('nm_condominio')) has-error @endif ">
                                    <label for="fname">Nome do condominio: <span class="red normal">*</span></label>
                                    <input type="text" class="form-control required" value="{{ old('nm_condominio',$condominio->nm_condominio) }}" name="nm_condominio"
                                        maxlength="100" aria-required="true" required> 
                                        @if($errors->has('nm_condominio'))
                                            <div class="error">{{ $errors->first('nm_condominio') }}</div>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group @if($errors->has('cd_condominio')) has-error @endif ">
                                    <label for="fname">Codigo do condominio: <span class="red normal"></span></label>
                                    <input type="text" class="form-control required" value="{{ old('cd_condominio',$condominio->cd_condominio) }}" name="cd_condominio"
                                        maxlength="100" aria-required="true"  >
                                        @if($errors->has('cd_condominio'))
                                            <div class="error">{{ $errors->first('cd_condominio') }}</div>
                                        @endif
                                </div>
                            </div> 
                        </div>
                        <div class="checkbox"  >
                            <label>
                                <div class="checker ">
                                    <span>
                                        <input type="checkbox" name="ativo" value="N"  @if($condominio->sn_ativo!='S') checked @endif />
                                    </span>
                                </div> Condomínio Inativo
                            </label>
                        </div><br>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Salvar" />
                            <input type="reset" class="btn btn-default" value="Limpar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layout.brcondos_adv.layout>