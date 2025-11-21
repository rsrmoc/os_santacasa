<x-layout.default>
    <div class="page-title">
        <h3>Tela de Cadastro</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="#">Relação</a></li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper" x-data="app">
        <div class="col-md-12 ">
            <div class="panel panel-white">
                <form x-on:submit.prevent="cadastro" class="panel-body">
                    <div class="row">
                        <div class="col-md-3 m-b-sm">
                            <label>Nome do paciente</label>
                            <input type="text" class="form-control" placeholder="Nome do paciente" required
                                x-model="inputsCadastro.nome_paciente" />
                        </div>

                        <div class="col-md-2 m-b-sm">
                            <label>Tipo de convênio</label>
                            <select class="form-control" id="tipoConvenio" required>
                                <option value="">SELECIONE</option>
                                <option value="CON">CONVENIO</option>
                                <option value="PAR">PARTICULAR</option>
                                <option value="SUS">SUS</option>
                            </select>
                        </div>

                        <div class="col-md-3 m-b-sm">
                            <label>Nome do convênio</label>
                            <input type="text" class="form-control" placeholder="Nome do convênio"
                                x-bind:disabled="disabledNomeConvenio" required
                                x-model="inputsCadastro.nome_convenio" />
                        </div>

                        <div class="col-md-3 m-b-sm">
                            <label>Nome do médico</label>
                            <input type="text" class="form-control" placeholder="Nome do médico" required
                                x-model="inputsCadastro.nome_medico" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 m-b-sm">
                            <label>Hospital</label>
                            <select class="form-control" required id="hospital">
                                <option value="">SELECIONE</option>
                                @foreach ($hospitais as $hospital)
                                    <option value="{{ $hospital->cd_hospital }}">{{ $hospital->nm_hospital }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 m-b-sm">
                            <label>Data da cirurgia</label>
                            <input type="date" class="form-control" required
                                x-model="inputsCadastro.data_cirurgia" />
                        </div>
                    </div>

                    <hr />

                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Produto</label>

                                <div style="display: flex; gap: 10px;" class="m-b-sm">
                                    <div style="width: 100%">
                                        <select class="form-control" data-placeholder="SELECIONE" id="produto"></select>
                                    </div>

                                    <button class="btn btn-success" type="button"
                                        x-on:click="addProduto">Adicionar</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th class="text-center">Ação</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <template x-for="produto, indice in inputsCadastro.produtos">
                                            <tr>
                                                <td x-text="produtos.find((prod) => prod.cd_produto == produto)?.nm_produto ?? produto"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger" x-on:click="excluirProduto(indice)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>

                                <template x-if="inputsCadastro.produtos.length == 0">
                                    <p class="text-center">Nenhum produto</p>
                                </template>
                            </div>
                        </div>

                    </div>

                    <hr />

                    <button type="submit" class="btn btn-success" x-bind:disabled="loadingCadastro">
                        <span class="loader loader-sm" x-show="loadingCadastro"></span>
                        Cadastrar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            const produtos = @json($produtos);
        </script>
        <script src="{{ asset('js/paginas/cadastro.js') }}"></script>
    </x-slot>
</x-layout.default>
