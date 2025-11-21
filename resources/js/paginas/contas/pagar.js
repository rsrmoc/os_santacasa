Alpine.data('appPagar', () => ({
    loading: false,
    inputs: {
        tipo: null,
        dti: null,
        dtf: null,
        status: '0',
        excluido: '1',
        cpf: null,
        condominios: []
    },

    init() {
        $('#select-tipo').on('select2:select', (evt) => this.inputs.tipo = evt.params.data.id);

        $('#select-status').on('select2:select', (evt) => this.inputs.status = evt.params.data.id);

        $('#select-excluido').on('select2:select', (evt) => this.inputs.excluido = evt.params.data.id);

        $('#select-condominios').on('select2:select', (evt) => this.inputs.condominios.push(evt.params.data.id));

        $('#select-condominios').on('select2:unselect', (evt) => this.inputs.condominios.splice(this.inputs.condominios.indexOf(evt.params.data.id), 1));
    },

    clear() {
        document.querySelector('#formPagar').reset();
        $('#select-tipo').val(null).trigger('change');
        $('#select-status').val(null).trigger('change');
        $('#select-excluido').val(null).trigger('change');
        $('#select-condominios').val(null).trigger('change');
    },

    save() {
        this.loading = true;

        console.log(this.inputs);

        axios.post('/brcondos_adv/integracoes-pag-store', this.inputs)
            .then((res) => {
                toastr['success'](res.data.message);
                this.clear();
            })
            .catch((err) => toastr['error'](err.response.data.message))
            .finally(() => this.loading = false);
    }
}));