Alpine.data('app', () => ({
    isLoading: false,
    loadingEnviarHistorico: false,
    loadingDetalhesBoletosAtrasados: false,
    boletoSelecionado: null,
    boletosAtrasados: [],
    inputsFiltros: { 
        dti: null,
        dtf: null,
        nome: null,
        cpf: null,  
        titulo: null,   
        status: ['PENDENTE', 'ATRASADO'],
        condominio: null,
        bloco: null,
        page: 1,
    },
    inputsNegociacao: {
        dt_negociacao: null,
        nr_contato: null,
        email_cliente: null,
        valor: null,
        obs: null
    },
    loadingNegociacao: false,
    clienteNegociacoes: [],
    negociacaoSelecionada: null,
    loadingBoletoNegociacao: false,
    inputFormHistorico: null,
    loadingFormHistorico: false,
    editCDHistorico: null,
    historicosCliente: [],
    pages: 0,
    Pagination: null,

    init() {
        this.getClientes();
        $('#select-condominio').on('select2:select', (evt) => {
            this.inputsFiltros.condominio = evt.params.data.id;
        });
    },

    getClientes() {
        this.loading = true;
        this.isLoading = true;
        axios.get('/brcondos_adv/clientes-json')
            .then((res) => {
                retorno = res.data.dados;
                this.boletos = retorno.data;
                this.pages = retorno.data.last_page;
                this.Pagination = res.data.pagination;
                console.log(res.data)
                this.inputsFiltros.dti = res.data.request.dti;
                this.inputsFiltros.dtf = res.data.request.dtf;
            })
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
            });
    },

    getClientesPorFiltros(resetPage = false) {
        this.loading = true;
        this.isLoading = true;

        resetPage && (this.inputsFiltros.page = 1);

        console.log(this.inputsFiltros);
        axios.get('/brcondos_adv/clientes-json', {
                params: this.inputsFiltros
            })
            .then((res) => {
                retorno = res.data.dados;
                this.boletos = retorno.data;
                console.log(res.data.dados);
                this.pages = retorno.data.last_page;
                this.Pagination = res.data.pagination;

            })
            .catch((err) => toastr['error']('Houve um erro ao fazer a pesquisa'))
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
            });
    },

    setPageBoletos(page) {
        this.inputsFiltros.page = page;
        this.getClientesPorFiltros();
    },

    verDetalhes(boleto) {
        this.boletosAtrasados = [];
        this.clienteNegociacoes = [];
        this.boletoSelecionado = boleto;

        this.loadingDetalhesBoletosAtrasados = true;

        axios.get(`${API_URL}/clientes-boletos-abertos`, {
                params: {
                    cpf_cnpj: boleto.cpf_cnpj
                }
            })
            .then((res) => {

                this.boletosAtrasados = res.data.boletos;
                this.clienteNegociacoes = res.data.negociacoes;
                this.historicosCliente = res.data.historico;
            })
            .catch((error) => toastr['error'](error.response.data.message))
            .finally(() => this.loadingDetalhesBoletosAtrasados = false);
    },

    clearInputsNegociacao() {
        this.inputsNegociacao = {
            dt_negociacao: null,
            nr_contato: null,
            email_cliente: null,
            valor: null,
            obs: null
        };
    },

    salvarNegociacao() {
        this.loadingNegociacao = true;

        if (this.inputsNegociacao.cd_negociacao) {
            axios.put(`${API_URL}/negociacao`, this.inputsNegociacao)
                .then((res) => {  
                    this.clienteNegociacoes  = res.data.negociacoes; 
                    toastr['success'](res.data.message);
                    this.clearInputsNegociacao();
                })
                .catch((err) => parseErrorsAPI(err.response.data.errors, err.response.data.message))
                .finally(() => this.loadingNegociacao = false);
            return;
        }

        let data = Object.assign({}, this.inputsNegociacao);
        data.cd_condominio = this.boletoSelecionado ?.condominio.cd_condominio;
        data.cpf_cnpj_cliente = this.boletoSelecionado ?.cpf_cnpj;
        data.nm_cliente = this.boletoSelecionado ?.nm_cliente;

        axios.post(`${API_URL}/negociacao`, data)
            .then((res) => {
                toastr['success'](res.data.message);
                this.clearInputsNegociacao();
                this.clienteNegociacoes.push(res.data.negociacao); 
                this.clienteNegociacoes  = res.data.negociacoes; 
            })
            .catch((err) => parseErrorsAPI(err.response.data.errors, err.response.data.message))
            .finally(() => this.loadingNegociacao = false);
    },

    deleteNegociacao(cdNegociacao) {
        Swal.fire({
            title: 'Confirmação',
            text: "Tem certeza que deseja excluir essa negociação?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`${API_URL}/negociacao/${cdNegociacao}`)
                    .then((res) => {
                        let indexNegociacao = this.clienteNegociacoes.findIndex((negociacao) => negociacao.cd_negociacao == cdNegociacao);
                        this.clienteNegociacoes.splice(indexNegociacao, 1);

                        toastr['success'](res.data.message);
                    })
                    .catch((err) => parseErrorsAPI(err.response.data.errors))
                    .finally(() => this.loadingBoletoNegociacao = false);
            }
        });
    },

    setFormNegociacaoEdit(negociacao) {
        Object.assign(this.inputsNegociacao, negociacao);
    },

    openModalNegociacao(negociacao) {
        this.negociacaoSelecionada = Object.assign({}, negociacao);

        $('#boletos-atrasados-negociacao').select2({
            data: this.boletosAtrasados.map((boleto) => ({
                id: boleto.cd_boleto,
                text: `${boleto.id_boleto} | ${boleto.tipo_conta} | ${boleto.vl_boleto}`
            }))
        })

        $('#negociaao-modal').modal('show');
    },

    addBoletoNegociacao() {
        if (this.negociacaoSelecionada.boletos.find((boleto) => boleto.cd_boleto == $('#boletos-atrasados-negociacao').val())) {
            toastr['error']('Boleto já foi adicionado!');
            return;
        }

        this.loadingBoletoNegociacao = true;

        axios.post(`${API_URL}/negociacao-boleto`, {
                cd_negociacao: this.negociacaoSelecionada.cd_negociacao,
                cd_boleto: $('#boletos-atrasados-negociacao').val()
            })
            .then((res) => {
                this.negociacaoSelecionada.boletos.push(res.data.negociacao_boleto);
                toastr['success'](res.data.message);
                $('#boletos-atrasados-negociacao').val(null).trigger('change');
            })
            .catch((err) => parseErrorsAPI(err.response.data.errors))
            .finally(() => this.loadingBoletoNegociacao = false);
    },

    deleteBoletoNegociacao(cdNegociacaoBoleto) {
        Swal.fire({
            title: 'Confirmação',
            text: "Tem certeza que deseja remover esse boleto?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`${API_URL}/negociacao-boleto/${cdNegociacaoBoleto}`)
                    .then((res) => {
                        let indexBoletoNegociacao = this.negociacaoSelecionada.boletos.findIndex((boleto) => boleto.cd_negociacao_boleto == cdNegociacaoBoleto);
                        this.negociacaoSelecionada.boletos.splice(indexBoletoNegociacao, 1);

                        toastr['success'](res.data.message);
                    })
                    .catch((err) => parseErrorsAPI(err.response.data.errors))
                    .finally(() => this.loadingBoletoNegociacao = false);
            }
        });
    },

    enviarHistorico() {},

    cadastrarHistorico() {
        this.loadingFormHistorico = true;

        if (this.editCDHistorico) {
            let data = { cd_historico: this.editCDHistorico, historico: this.inputFormHistorico };

            axios.put(`${API_URL}/historico-cliente`, data)
                .then((res) => {
                    let indexHistorico = this.historicosCliente.findIndex((historico) => historico.cd_historico == this.editCDHistorico);
                    this.historicosCliente[indexHistorico] = res.data.historico;
                    this.clearEdicaoHistorico();

                    toastr['success'](res.data.message);
                })
                .catch((err) => parseErrorsAPI(err.response.data.errors))
                .finally(() => this.loadingFormHistorico = false);

            return;
        }

        let data = { cpf_cnpj_cliente: this.boletoSelecionado.cpf_cnpj, historico: this.inputFormHistorico };

        axios.post(`${API_URL}/historico-cliente`, data)
            .then((res) => {
                this.historicosCliente.push(res.data.historico);
                this.inputFormHistorico = null;

                toastr['success'](res.data.message);
            })
            .catch((err) => parseErrorsAPI(err.response.data.errors))
            .finally(() => this.loadingFormHistorico = false);
    },

    setEdicaoHistorico(historico) {
        this.editCDHistorico = historico.cd_historico;
        this.inputFormHistorico = historico.historico;
    },

    clearEdicaoHistorico() {
        this.editCDHistorico = null;
        this.inputFormHistorico = null;
    },

    excluirHistorico(cdHistorico) {
        Swal.fire({
            title: 'Confirmação',
            text: "Tem certeza que deseja remover esse historico?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`${API_URL}/historico-cliente/${cdHistorico}`)
                    .then((res) => {
                        let indexHistorico = this.historicosCliente.findIndex((historico) => historico.cd_historico == cdHistorico);
                        this.historicosCliente.splice(indexHistorico, 1);

                        toastr['success'](res.data.message);
                    })
                    .catch((err) => parseErrorsAPI(err.response.data.errors))
                    .finally(() => this.loadingBoletoNegociacao = false);
            }
        });
    }
}));

$(document).ready(function() {
    $('#cadastro-consulta, #negociaao-modal').modal({
        backdrop: 'static',
        show: false
    });
});