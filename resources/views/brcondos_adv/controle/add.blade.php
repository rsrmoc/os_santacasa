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

                    <form role="form" id="addUser" action="{{ route('condominios-store') }}" method="post"
                        role="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group @if($errors->has('nm_condominio')) has-error @endif ">
                                    <label for="fname">Nome do condominio: <span class="red normal">*</span></label>
                                    <input type="text" class="form-control required" value="{{ old('nm_condominio') }}" name="nm_condominio"
                                        maxlength="100" aria-required="true" required> 
                                        @if($errors->has('nm_condominio'))
                                            <div class="error">{{ $errors->first('nm_condominio') }}</div>
                                        @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group @if($errors->has('cd_condominio')) has-error @endif ">
                                    <label for="fname">Codigo do condominio: <span class="red normal"></span></label>
                                    <input type="text" class="form-control required" value="{{ old('nome') }}" name="cd_condominio"
                                        maxlength="100" aria-required="true"  >
                                        @if($errors->has('cd_condominio'))
                                            <div class="error">{{ $errors->first('cd_condominio') }}</div>
                                        @endif
                                </div>
                            </div> 
                        </div>

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
