Alpine.data('app', () => ({
    inputsFiltros: {
        tipo: null,
        dti: null,
        dtf: null,
        nome: null,
        cpf: null,
        agrupameno: null,
        status: null,
        titulo: null,
        nr_doc: null,
        ns_num: null,
        tipo_conta: null,
        status: ['PAGO', 'NEGOCIADO', 'ATRASADO'],
        condominio: null,
        bloco: null,
        page: 1,
    },
    inputsPag: {
        current_page: null,
        first_page_url: null,
        last_page: null,
        per_page: null,
        next_page_url: null,
        prev_page_url: null,
    },
    Pagination: null,
    loading: false,
    isLoading: false,
    boletos: [],
    boleto_selecionado: null,
    boleto_selecionado_historico: [],
    descricaoHistorico: null,
    pages: 0,
    teste_popo: [{ "codigo": "01", "nome": "Um" }, { "codigo": "02", "nome": "Dois" }],

    init() {

        this.getBoletos();

        $('#select-tipo').on('select2:select', (evt) => {
            this.inputsFiltros.tipo = evt.params.data.id;
        });

        $('#select-agrupamento').on('select2:select', (evt) => {
            this.inputsFiltros.agrupameno = evt.params.data.id;
        });

        $('#select-tipo_conta').on('select2:select', (evt) => {
            this.inputsFiltros.tipo_conta = evt.params.data.id;
        });

        $('#select-status').on('select2:select', (evt) => {
            this.inputsFiltros.status = evt.params.data.id;
        });

        $('#select-condominio').on('select2:select', (evt) => {
            this.inputsFiltros.condominio = evt.params.data.id;
        });
    },
    getBoletos() {
        this.loading = true;
        this.isLoading = true;
        axios.get('/brcondos_adv/controle-json')
            .then((res) => {
                retorno = res.data.dados;
                this.boletos = retorno.data;
                this.pages = retorno.data.last_page;
                this.Pagination = res.data.pagination;
                console.log(this.inputsFiltros.dti = res.data.request)
                this.inputsFiltros.dti = res.data.request.dti;
                this.inputsFiltros.dtf = res.data.request.dtf;
            })
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
            });
    },

    getBoletosPorFiltros(resetPage = false) {
        this.loading = true;
        this.isLoading = true;

        resetPage && (this.inputsFiltros.page = 1);

        axios.get('/brcondos_adv/controle-json', {
                params: this.inputsFiltros
            })
            .then((res) => {
                retorno = res.data.dados;
                this.boletos = retorno.data;
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
        this.getBoletosPorFiltros();
    },

    detalhes(boleto) {
        axios.get(`/brcondos_adv/controle-historico-json/${boleto.cd_boleto}`)
            .then((res) => this.boleto_selecionado_historico = res.data);

        this.boleto_selecionado = boleto;
        console.log(boleto);

        $('#cadastro-consulta').modal('toggle');
    },

    cadastrarHistorico() {
        axios.post(`/brcondos_adv/controle-historico-json`, {
                cd_boleto: this.boleto_selecionado.cd_boleto,
                nome: this.descricaoHistorico
            })
            .then((res) => {
                this.boleto_selecionado_historico.push(res.data);

                this.descricaoHistorico = null;
            });
    },

    /* Exluir na tabela boletos_historico  */
    excluirHistorico(cd_boleto_hist, indice) {
        $('#cadastro-consulta').modal('toggle');

        Swal.fire({
            title: 'Confirmação',
            text: "Tem certeza que deseja excluir esse historico?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/brcondos_adv/controle-historico-json/${cd_boleto_hist}`)
                    .then((res) => {
                        toastr['success'](res.data.message);
                        this.boleto_selecionado_historico.splice(indice, 1);
                    });
            }

            $('#cadastro-consulta').modal('toggle');
        });
    }
}))

$(document).ready(() => {

})