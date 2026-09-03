Alpine.data('app', () => ({
    queryChamados: [],
    Pagination: null,
    page: 1,
    queryModal: null,
    queryIdx: null,
    buttonSalvar: false,
    buttonSearch: false,
    queryOsAndamento: [],
    contadores: {},
    iconLoad: "<i class='fa fa-spinner fa-spin'></i>",
    header:{
        card1: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard1: 100,
        card2: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard2: 100,
        card3: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard3: 100,
        card4: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard4: 100,
        card5: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard5: 100,
        card6: "<i class='fa fa-spinner fa-spin'></i>",
        Pcard6: 100,
    },

    init() {
        this.getPage();
        this.headerSuporte((window.tela ?? null));


        $('.modalCriar').on('show.bs.modal', function() {
            let $selects = $(this).find('select');

            $selects.each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
            });

            $selects.select2({
                dropdownParent: $(this)
            });
        });

        $('#id_setor_suporte').off('change.getLocalidades').on('change.getLocalidades', () => this.getLocalidadesPorSetor());
        $('#id_setor_criar').off('change.getLocalidades').on('change.getLocalidades', () => this.getLocalidadesPorSetorCriar());
    },

    headerSuporte(tela){
        console.log('Fetching header for tela:' +  this.iconLoad);
        this.header.card1 = this.iconLoad;
        this.header.card2 = this.iconLoad;
        this.header.card3 = this.iconLoad;
        this.header.card4 = this.iconLoad;
        this.header.card5 = this.iconLoad;
        this.header.card6 = this.iconLoad;
        axios.post(`/acma/json/chamados-header/${tela}`)
            .then((res) => {
                console.log(res.data);
                if(window.tela == 'suporte') {
                    this.header.card1 = res.data.total_aberta ?? 0;
                    this.header.Pcard1 = res.data.p_total_aberta ?? 100;
                    this.header.card2 = res.data.total_classificada ?? 0;
                    this.header.Pcard2 = res.data.p_total_classificada ?? 100;
                    this.header.card3 = res.data.total_aprazada ?? 0;
                    this.header.Pcard3 = res.data.p_total_aprazada ?? 100;
                    this.header.card4 = res.data.total_ate_5_dias ?? 0;
                    this.header.Pcard4 = res.data.p_total_ate_5_dias ?? 100;
                    this.header.card5 = res.data.total_ate_10_dias ?? 0;
                    this.header.Pcard5 = res.data.p_total_ate_10_dias ?? 100;
                    this.header.card6 = res.data.total_maior_10_dias ?? 0;
                    this.header.Pcard6 = res.data.p_total_maior_10_dias ?? 100;
                }
                if(window.tela == 'projeto') {
                    this.header.card1 = res.data.total_aberta ?? 0;
                    this.header.Pcard1 = res.data.p_total_aberta ?? 100;
                    this.header.card2 = res.data.total_aprazada ?? 0;
                    this.header.Pcard2 = res.data.p_total_aprazada ?? 100;
                    this.header.card3 = res.data.dentro_prazo ?? 0;
                    this.header.Pcard3 = res.data.p_dentro_prazo ?? 100;
                    this.header.card4 = res.data.vencendo_prazo ?? 0;
                    this.header.Pcard4 = res.data.p_vencendo_prazo ?? 100;
                    this.header.card5 = res.data.vencido ?? 0;
                    this.header.Pcard5 = res.data.p_vencido ?? 100;
                }
            })
            .finally(() => {

            });
    },

    getLocalidadesPorSetor(){
        let cdSetor = document.querySelector('#id_setor_suporte').value;
        let localidadeEl = document.querySelector('#id_localidade_suporte');

        let opcoes = window.localidade.filter((loc) => loc.cd_setor == cdSetor);

        let html = '<option value="">Selecione a Localidade</option>';
        opcoes.forEach((loc) => {
            html += `<option value="${loc.cd_localidade}">${loc.ds_localidade}</option>`;
        });

        localidadeEl.innerHTML = html;
        $(localidadeEl).val(null).trigger('change');
    },

    getLocalidadesPorSetorCriar(){
        let cdSetor = document.querySelector('#id_setor_criar').value;
        let localidadeEl = document.querySelector('#id_localidade_criar');

        let opcoes = window.localidade.filter((loc) => loc.cd_setor == cdSetor);

        let html = '<option value="">Selecione a Localidade</option>';
        opcoes.forEach((loc) => {
            html += `<option value="${loc.cd_localidade}">${loc.ds_localidade}</option>`;
        });

        localidadeEl.innerHTML = html;
        $(localidadeEl).val(null).trigger('change');
    },

    getPage(page = 1){
        this.loading = true;
        this.isLoading = true;
        this.buttonSearch = true;
        this.page = page;
        let form = new FormData(document.querySelector('#form-chamados'));
        form.append('page', page);
        axios.post(`/acma/json/chamados-json`, form)
            .then((res) => {
                console.log(res.data.dados.data);
                this.queryChamados = res.data.dados.data;
                this.Pagination = res.data.pagination;
                this.contadores = res.data.contadores;
            })
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
                this.buttonSearch = false;
            });
    },

    setPage(page) {
        this.getPage(page);
    },

    modal(dados,Idx) {
        this.queryModal = dados;
        this.queryIdx = Idx;
        console.log(this.queryIdx);
        $('.modalOS').modal('show');

        this.$nextTick(() => {
            $('.modalOS select').select2({
                dropdownParent: $('.modalOS')
            });

            $('#id_resp_classificar').val(this.queryModal.tab_classificacao?.tab_responsavel?.cd_func ?? null).trigger('change');
            $('#id_oficina_classificar').val(this.queryModal.cd_oficina ?? null).trigger('change');
            $('#id_tipo_classificar').val(this.queryModal.cd_tipo_os ?? null).trigger('change');

            $('#id_tempo_servico').off('change.getOsTempo').on('change.getOsTempo', () => this.getOsTempo());
        });
    },

    getClassificar(){
        this.buttonSalvar = true;
        let form = new FormData(document.querySelector('#form-classificar'));
        form.append('cd_os', this.queryModal.cd_os);
        axios.post(`/acma/json/chamados-classicacao`, form)
            .then((res) => {
                console.log(res.data);
                toastr['info']('Classificação realizada!', 'Sucesso');
                this.queryModal = res.data.retorno;
                this.queryChamados[this.queryIdx] = res.data.retorno;
            })
            .catch((err) => {
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
                this.buttonSalvar = false;
            });
    },

    getAprazar(){
        this.buttonSalvar = true;
        let form = new FormData(document.querySelector('#form-aprazar'));
        form.append('cd_os', this.queryModal.cd_os);
        axios.post(`/acma/json/chamados-aprazar`, form)
            .then((res) => {
                console.log(res.data);
                toastr['info']('Aprazamento realizado!', 'Sucesso');
                //this.queryModal.tab_aprazamento = res.data.retorno;
                this.queryModal = res.data.retorno;
                this.queryChamados[this.queryIdx] = res.data.retorno;
                document.querySelector('#form-aprazar').reset();
            })
            .catch((err) => {
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
                this.buttonSalvar = false;
            });
    },

    getServico(){
        this.buttonSalvar = true;
        let form = new FormData(document.querySelector('#form-servico'));
        form.append('cd_os', this.queryModal.cd_os);
        form.set('dti', form.get('dti').replace('T', ' '));
        form.set('dtf', form.get('dtf').replace('T', ' '));
        axios.post(`/acma/json/chamados-servico`, form)
            .then((res) => {
                console.log(res.data);
                toastr['info']('Observação realizada!', 'Sucesso');
                this.queryModal = res.data.retorno;
                this.queryChamados[this.queryIdx] = res.data.retorno;
                document.querySelector('#form-servico').reset();
            })
            .catch((err) => {
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
                this.buttonSalvar = false;
            });
    },

    getObs(){
        this.buttonSalvar = true;
        let form = new FormData(document.querySelector('#form-obs'));
        form.append('cd_os', this.queryModal.cd_os);
        axios.post(`/acma/json/chamados-obs`, form)
            .then((res) => {
                console.log(res.data);
                toastr['info']('Observação realizada!', 'Sucesso');
                this.queryModal = res.data.retorno;
                this.queryChamados[this.queryIdx] = res.data.retorno;
                document.querySelector('#form-obs').reset();
            })
            .catch((err) => {
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
                this.loading = false;
                this.isLoading = false;
                this.buttonSalvar = false;
            });
    },

    getOsTempo(){
        let inicioEl = document.querySelector('#id_inicio_servico');
        let tempoEl = document.querySelector('#id_tempo_servico');

        if (!inicioEl.value) {
            toastr['error']('Selecione a Data/Hora de Início antes de escolher o Tempo!', 'Atenção');
            inicioEl.focus();
            $(tempoEl).val(null).trigger('change.select2');
            return;
        }

        if (!tempoEl.value) {
            return;
        }

        let dtInicio = new Date(inicioEl.value);
        dtInicio.setMinutes(dtInicio.getMinutes() + parseInt(tempoEl.value));

        let pad = (n) => String(n).padStart(2, '0');
        let dtFim = `${dtInicio.getFullYear()}-${pad(dtInicio.getMonth() + 1)}-${pad(dtInicio.getDate())}T${pad(dtInicio.getHours())}:${pad(dtInicio.getMinutes())}`;

        document.querySelector('#id_fim_servico').value = dtFim;
    },

    deleteServico(id){

        Swal.fire({
            title: 'Confirmação',
            text: 'Deseja realmente cancelar este serviço?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            axios.post(`/acma/json/chamados-servico/cancelar/`+id)
                .then((res) => {
                    toastr['info']('Serviço cancelado com sucesso!', 'Sucesso');
                    this.queryModal = res.data.retorno;
                    this.queryChamados[this.queryIdx] = res.data.retorno;
                })
                .catch((err) => {
                    toastr['error'](err.response.data.message, 'Erro');
                });
        });

    },

    reabrirOs(id){

        Swal.fire({
            title: 'Confirmação',
            text: 'Deseja realmente reabrir esta ordem de serviço?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            axios.post(`/acma/json/chamados-servico/reabrir/`+id)
                .then((res) => {
                    toastr['info']('Ordem de serviço reaberta com sucesso!', 'Sucesso');
                    this.queryModal = res.data.retorno;
                    this.queryChamados[this.queryIdx] = res.data.retorno;
                })
                .catch((err) => {
                    toastr['error'](err.response.data.message, 'Erro');
                });
        });

    },

    fecharOs(id){
        Swal.fire({
            title: 'Confirmação',
            text: 'Deseja realmente fechar esta ordem de serviço?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            axios.post(`/acma/json/chamados-servico/fechar/`+id)
                .then((res) => {
                    toastr['info']('Ordem de serviço fechada com sucesso!', 'Sucesso');
                    this.queryModal = res.data.retorno;
                    this.queryChamados[this.queryIdx] = res.data.retorno;
                })
                .catch((err) => {
                    toastr['error'](err.response.data.message, 'Erro');
                });
        });
    },

    finalizarOs(id){
        Swal.fire({
            title: 'Confirmação',
            text: 'Deseja realmente finalizar esta ordem de serviço?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            axios.post(`/acma/json/chamados-servico/finalizar/`+id)
                .then((res) => {
                    toastr['info']('Ordem de serviço finalizada com sucesso!', 'Sucesso');
                    this.queryOsAndamento = res.data.retorno;
                })
                .catch((err) => {
                    toastr['error'](err.response.data.message, 'Erro');
                });
        });
    },

    getOsSuporte(){
        this.buttonSalvar = true;
        let form = new FormData(document.querySelector('#form-os-suporte'));
        axios.post(`/acma/json/chamados-os-suporte`, form)
            .then((res) => {

                toastr['info']('Ordem de Serviço realizada com sucesso!', 'Sucesso');

                document.querySelector('#form-os-suporte').reset();
                document.querySelector('#id_localidade_suporte').innerHTML = '<option value="">Selecione a Localidade</option>';
                $('#form-os-suporte select').trigger('change');

                this.queryOsAndamento = res.data.retorno;
            })
            .catch((err) => {
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
                this.buttonSalvar = false;
            });
    },

    getOsCriar(){
        this.buttonSalvar = true;
        let form = new FormData(document.querySelector('#form-os-criar'));
        axios.post(`/acma/json/chamados-os-suporte`, form)
            .then((res) => {

                toastr['info']('Ordem de Serviço realizada com sucesso!', 'Sucesso');

                document.querySelector('#form-os-criar').reset();
                document.querySelector('#id_localidade_criar').innerHTML = '<option value="">Selecione a Localidade</option>';
                $('#form-os-criar select').trigger('change');

            })
            .catch((err) => {
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
                this.buttonSalvar = false;
            });
    },

    modalCriar(){

        $('.modalCriar').modal('show');
        axios.post(`/acma/json/chamados-andamentos`)
            .then((res) => {
                console.log(res.data);
                this.queryOsAndamento = res.data.retorno;
            })
            .catch((err) => {
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
            });


    }

}))


