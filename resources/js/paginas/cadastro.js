Alpine.data('app', () => ({
    inputsCadastro: {
        nome_paciente: null,
        tipo_convenio: null,
        nome_convenio: null,
        nome_medico: null,
        hospital: null,
        data_cirurgia: null,
        produtos: []
    },
    loadingCadastro: false,
    disabledNomeConvenio: true,

    init() {
        $('#tipoConvenio').on('select2:select', (evt) => {
            let val = evt.params.data.id;
            this.inputsCadastro.tipo_convenio = val;
            this.inputsCadastro.nome_convenio = null;
            this.disabledNomeConvenio = val !== 'CON'
        });

        $('#hospital').on('select2:select', (evt) => {
            this.inputsCadastro.hospital = evt.params.data.id
        });
    },

    cadastro() {
        this.loadingCadastro = true;

        if (this.inputsCadastro.produtos.length == 0) {
            toastr['error']('Adicione um produto!');
            return;
        }

        axios.post('/api/cadastro', this.inputsCadastro)
            .then((res) => {
                toastr['success'](res.data.message);

                document.querySelector('form.panel-body').reset();
                $('#tipoConvenio').val(null).trigger('change');
                $('#hospital').val(null).trigger('change');
                this.inputsCadastro.produtos = [];
            })
            .catch((err) => toastr['error'](err.response.data.message))
            .finally(() => this.loadingCadastro = false)
    },

    addProduto() {
        if (this.inputsCadastro.produtos.find((produto) => produto == $('#produto').val() )) return;

        this.inputsCadastro.produtos.push($('#produto').val());
        console.log(this.inputsCadastro.produtos);
        $('#produto').val(null).trigger('change');
    },

    excluirProduto(indice) {
        Swal.fire({
            title: 'Confirmação',
            text: "Tem certeza que deseja excluir esse usuáro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                this.inputsCadastro.produtos.splice(indice);
            }
        });
    }
}))

$(document).ready(() => {
    $('#produto').select2({
        ajax: {
            url: '/api/produto-pesquisa',
            processResults(res) {
                let search = $('#produto').data('select2').results.lastParams?.term;
                let data = res.map((produto) => ({ id: produto.cd_produto, text: produto.nm_produto }));

                if (search) {
                    data.unshift({id: search, text: `"${search}" Novo produto`});
                }

                return {
                    results: data
                };
            }
        }
    })
})
