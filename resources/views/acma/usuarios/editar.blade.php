<x-layout.acma.layout>
    <div class="page-title">
        <h3>Editar Usuário</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('usuarios-listar') }}">Relação</a></li>
            </ol>
        </div>
    </div>
 
    <div id="main-wrapper" x-data="app">
        <div class="col-md-12 ">
            <form action="{{ route('usuarios-update', ['usuario' => $usuario->id]) }}" method="POST" class="panel panel-white">
                @csrf

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group @if($errors->has('usuario')) has-error @endif ">
                                <label for="fname">Usuario de Acesso: <span class="red normal">*</span></label>
                                <input type="text" class="form-control" readonly value="{{ old('usuario',$usuario->email)  }}" 
                                placeholder="Usuario MV" name="usuario" required /> 
                                @if($errors->has('usuario'))
                                    <div class="error">{{ $errors->first('usuario') }}</div>
                                @endif 
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('nome')) has-error @endif ">
                                <label for="fname">Nome do Usuário: <span class="red normal">*</span></label>
                                <input type="text" class="form-control" placeholder="Nome" name="nome" readonly value="{{ old('name',$usuario->name)  }}"  required />   
                                @if($errors->has('nome'))
                                    <div class="error">{{ $errors->first('nome') }}</div>
                                @endif 
                            </div>
                        </div> 
                        
                        <div class="col-md-2">
                            <div class="form-group @if($errors->has('password')) has-error @endif ">
                                <label for="fname">Senha: <span class="red normal"></span></label>
                                <input type="password" class="form-control" placeholder="Senha" name="password" value="{{old('password')}}"  />    
                                @if($errors->has('password'))
                                    <div class="error">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('email')) has-error @endif ">
                                <label for="fname">Email: <span class="red normal"></span></label>
                                <input type="email" class="form-control" placeholder="Email" name="email"   value="{{ old('email',$usuario->email_user)  }}"   />    
                                @if($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        
                        <div class="col-md-2">
                            <div class="form-group @if($errors->has('sexo')) has-error @endif ">
                                <label for="fname">Sexo: <span class="red normal"> *</span></label>
                                <select class="form-control" name="sexo" required >
                                    <option value="">SELECIONE</option>
                                    <option value="F" @if(old('sexo',$usuario->sexo)=='F') selected @endif >FEMININO</option>
                                    <option value="M" @if(old('sexo',$usuario->sexo)=='M') selected @endif>MASCULINO</option> 
                                </select>
                                @if($errors->has('sexo'))
                                    <div class="error">{{ $errors->first('sexo') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group @if($errors->has('celular')) has-error @endif ">
                                <label for="fname">Celular: <span class="red normal"> </span></label>
                                <input type="text" class="form-control" placeholder="Celular" name="celular" value="{{old('celular',$usuario->fone)}}"   />    
                                @if($errors->has('celular'))
                                    <div class="error">{{ $errors->first('celular') }}</div>
                                @endif
                            </div>
                        </div>  
                        
                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('oficina')) has-error @endif ">
                                <label for="fname">Oficina: <span class="red normal"> *</span></label>
                                <select class="form-control" name="oficina" required  >
                                    <option value="">SELECIONE</option> 
                                    @foreach($oficina as $key => $val)
                                        <option value="{{$val->cd_oficina}}" @if(old('oficina',$usuario->cd_oficina)==$val->cd_oficina) selected @endif> {{$val->ds_oficina}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('oficina'))
                                    <div class="error">{{ $errors->first('oficina') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('func')) has-error @endif ">
                                <label for="fname">Funcionario: <span class="red normal"> *</span></label>
                                <select class="form-control" name="func" required >
                                    <option value="">SELECIONE</option> 
                                    @foreach($func as $key => $val)
                                        <option value="{{$val->cd_func}}" @if(old('func',$usuario->cd_funcionario)==$val->cd_func) selected @endif> {{$val->nm_func}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('func'))
                                    <div class="error">{{ $errors->first('func') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
 

                    <div class="row">
                        <div class="col-md-10">
                            <table class="table table-striped" style="margin-bottom: 0">
                                <thead>
                                    <tr class="active">
                                        <th>Página</th>

                                        <th>Permissões</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($permissoes as $tela)
                                        <tr>
                                            <td>{{ $tela->cd_permissao }}</td>

                                            <td>
                                                <div style="display: flex">
                                                    @if(strpos($tela->opcao, 'ver') !== false)
                                                        <div class="checkbox" style="margin: 0">
                                                            <label>
                                                                <div class="checker">
                                                                    <span>
                                                                        <input type="checkbox" name="permissoes[{{ $tela->cd_permissao }}][]" value="ver"
                                                                            @if($usuario->isPermissao($tela->cd_permissao, 'ver')) checked @endif />
                                                                    </span>
                                                                </div> Ver
                                                            </label>
                                                        </div>
                                                    @endif
 

                                                    @if(strpos($tela->opcao, 'criar') !== false)
                                                        <div class="checkbox" style="margin: 0">
                                                            <label>
                                                                <div class="checker">
                                                                    <span>
                                                                        <input type="checkbox" name="permissoes[{{ $tela->cd_permissao }}][]" value="criar"
                                                                            @if($usuario->isPermissao($tela->cd_permissao, 'criar')) checked @endif />
                                                                    </span>
                                                                </div> Criar/Editar
                                                            </label>
                                                        </div>
                                                    @endif

                                                 
                                                    @if(strpos($tela->opcao, 'excluir') !== false)
                                                        <div class="checkbox" style="margin: 0">
                                                            <label>
                                                                <div class="checker">
                                                                    <span>
                                                                        <input type="checkbox" name="permissoes[{{ $tela->cd_permissao }}][]" value="excluir"
                                                                            @if($usuario->isPermissao($tela->cd_permissao , 'excluir')) checked @endif />
                                                                    </span>
                                                                </div> Excluir
                                                            </label>
                                                        </div>
                                                    @endif
                                                    
                                                    @if(strpos($tela->opcao, 'detalhes') !== false)
                                                        <div class="checkbox" style="margin: 0">
                                                            <label>
                                                                <div class="checker">
                                                                    <span>
                                                                        <input type="checkbox" name="permissoes[{{ $tela->cd_permissao }}][]" value="detalhes"
                                                                            @if($usuario->isPermissao($tela->cd_permissao, 'detalhes')) checked @endif />
                                                                    </span>
                                                                </div> Detalhes
                                                            </label>
                                                        </div>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr> 
                                    @endforeach
 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <button class="btn btn-info"> <i class="fa fa-fw fa-check-square-o"></i> Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</x-layout.acma.layout>
