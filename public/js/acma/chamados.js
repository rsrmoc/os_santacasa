/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/acma/chamados.js ***!
  \***************************************/
Alpine.data('app', function () {
  return {
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
    header: {
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
      Pcard6: 100
    },
    init: function init() {
      var _window$tela,
        _this = this;
      this.getPage();
      this.headerSuporte((_window$tela = window.tela) !== null && _window$tela !== void 0 ? _window$tela : null);
      $('.modalCriar').on('show.bs.modal', function () {
        var $selects = $(this).find('select');
        $selects.each(function () {
          if ($(this).data('select2')) {
            $(this).select2('destroy');
          }
        });
        $selects.select2({
          dropdownParent: $(this)
        });
      });
      $('#id_setor_suporte').off('change.getLocalidades').on('change.getLocalidades', function () {
        return _this.getLocalidadesPorSetor();
      });
      $('#id_setor_criar').off('change.getLocalidades').on('change.getLocalidades', function () {
        return _this.getLocalidadesPorSetorCriar();
      });
    },
    headerSuporte: function headerSuporte(tela) {
      var _this2 = this;
      console.log('Fetching header for tela:' + this.iconLoad);
      this.header.card1 = this.iconLoad;
      this.header.card2 = this.iconLoad;
      this.header.card3 = this.iconLoad;
      this.header.card4 = this.iconLoad;
      this.header.card5 = this.iconLoad;
      this.header.card6 = this.iconLoad;
      axios.post("/acma/json/chamados-header/".concat(tela)).then(function (res) {
        console.log(res.data);
        if (window.tela == 'suporte') {
          var _res$data$total_abert, _res$data$p_total_abe, _res$data$total_class, _res$data$p_total_cla, _res$data$total_apraz, _res$data$p_total_apr, _res$data$total_ate_, _res$data$p_total_ate, _res$data$total_ate_2, _res$data$p_total_ate2, _res$data$total_maior, _res$data$p_total_mai;
          _this2.header.card1 = (_res$data$total_abert = res.data.total_aberta) !== null && _res$data$total_abert !== void 0 ? _res$data$total_abert : 0;
          _this2.header.Pcard1 = (_res$data$p_total_abe = res.data.p_total_aberta) !== null && _res$data$p_total_abe !== void 0 ? _res$data$p_total_abe : 100;
          _this2.header.card2 = (_res$data$total_class = res.data.total_classificada) !== null && _res$data$total_class !== void 0 ? _res$data$total_class : 0;
          _this2.header.Pcard2 = (_res$data$p_total_cla = res.data.p_total_classificada) !== null && _res$data$p_total_cla !== void 0 ? _res$data$p_total_cla : 100;
          _this2.header.card3 = (_res$data$total_apraz = res.data.total_aprazada) !== null && _res$data$total_apraz !== void 0 ? _res$data$total_apraz : 0;
          _this2.header.Pcard3 = (_res$data$p_total_apr = res.data.p_total_aprazada) !== null && _res$data$p_total_apr !== void 0 ? _res$data$p_total_apr : 100;
          _this2.header.card4 = (_res$data$total_ate_ = res.data.total_ate_5_dias) !== null && _res$data$total_ate_ !== void 0 ? _res$data$total_ate_ : 0;
          _this2.header.Pcard4 = (_res$data$p_total_ate = res.data.p_total_ate_5_dias) !== null && _res$data$p_total_ate !== void 0 ? _res$data$p_total_ate : 100;
          _this2.header.card5 = (_res$data$total_ate_2 = res.data.total_ate_10_dias) !== null && _res$data$total_ate_2 !== void 0 ? _res$data$total_ate_2 : 0;
          _this2.header.Pcard5 = (_res$data$p_total_ate2 = res.data.p_total_ate_10_dias) !== null && _res$data$p_total_ate2 !== void 0 ? _res$data$p_total_ate2 : 100;
          _this2.header.card6 = (_res$data$total_maior = res.data.total_maior_10_dias) !== null && _res$data$total_maior !== void 0 ? _res$data$total_maior : 0;
          _this2.header.Pcard6 = (_res$data$p_total_mai = res.data.p_total_maior_10_dias) !== null && _res$data$p_total_mai !== void 0 ? _res$data$p_total_mai : 100;
        }
        if (window.tela == 'projeto') {
          var _res$data$total_abert2, _res$data$p_total_abe2, _res$data$total_apraz2, _res$data$p_total_apr2, _res$data$dentro_praz, _res$data$p_dentro_pr, _res$data$vencendo_pr, _res$data$p_vencendo_, _res$data$vencido, _res$data$p_vencido;
          _this2.header.card1 = (_res$data$total_abert2 = res.data.total_aberta) !== null && _res$data$total_abert2 !== void 0 ? _res$data$total_abert2 : 0;
          _this2.header.Pcard1 = (_res$data$p_total_abe2 = res.data.p_total_aberta) !== null && _res$data$p_total_abe2 !== void 0 ? _res$data$p_total_abe2 : 100;
          _this2.header.card2 = (_res$data$total_apraz2 = res.data.total_aprazada) !== null && _res$data$total_apraz2 !== void 0 ? _res$data$total_apraz2 : 0;
          _this2.header.Pcard2 = (_res$data$p_total_apr2 = res.data.p_total_aprazada) !== null && _res$data$p_total_apr2 !== void 0 ? _res$data$p_total_apr2 : 100;
          _this2.header.card3 = (_res$data$dentro_praz = res.data.dentro_prazo) !== null && _res$data$dentro_praz !== void 0 ? _res$data$dentro_praz : 0;
          _this2.header.Pcard3 = (_res$data$p_dentro_pr = res.data.p_dentro_prazo) !== null && _res$data$p_dentro_pr !== void 0 ? _res$data$p_dentro_pr : 100;
          _this2.header.card4 = (_res$data$vencendo_pr = res.data.vencendo_prazo) !== null && _res$data$vencendo_pr !== void 0 ? _res$data$vencendo_pr : 0;
          _this2.header.Pcard4 = (_res$data$p_vencendo_ = res.data.p_vencendo_prazo) !== null && _res$data$p_vencendo_ !== void 0 ? _res$data$p_vencendo_ : 100;
          _this2.header.card5 = (_res$data$vencido = res.data.vencido) !== null && _res$data$vencido !== void 0 ? _res$data$vencido : 0;
          _this2.header.Pcard5 = (_res$data$p_vencido = res.data.p_vencido) !== null && _res$data$p_vencido !== void 0 ? _res$data$p_vencido : 100;
        }
      })["finally"](function () {});
    },
    getLocalidadesPorSetor: function getLocalidadesPorSetor() {
      var cdSetor = document.querySelector('#id_setor_suporte').value;
      var localidadeEl = document.querySelector('#id_localidade_suporte');
      var opcoes = window.localidade.filter(function (loc) {
        return loc.cd_setor == cdSetor;
      });
      var html = '<option value="">Selecione a Localidade</option>';
      opcoes.forEach(function (loc) {
        html += "<option value=\"".concat(loc.cd_localidade, "\">").concat(loc.ds_localidade, "</option>");
      });
      localidadeEl.innerHTML = html;
      $(localidadeEl).val(null).trigger('change');
    },
    getLocalidadesPorSetorCriar: function getLocalidadesPorSetorCriar() {
      var cdSetor = document.querySelector('#id_setor_criar').value;
      var localidadeEl = document.querySelector('#id_localidade_criar');
      var opcoes = window.localidade.filter(function (loc) {
        return loc.cd_setor == cdSetor;
      });
      var html = '<option value="">Selecione a Localidade</option>';
      opcoes.forEach(function (loc) {
        html += "<option value=\"".concat(loc.cd_localidade, "\">").concat(loc.ds_localidade, "</option>");
      });
      localidadeEl.innerHTML = html;
      $(localidadeEl).val(null).trigger('change');
    },
    getPage: function getPage() {
      var _this3 = this;
      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      this.loading = true;
      this.isLoading = true;
      this.buttonSearch = true;
      this.page = page;
      var form = new FormData(document.querySelector('#form-chamados'));
      form.append('page', page);
      axios.post("/acma/json/chamados-json", form).then(function (res) {
        console.log(res.data.dados.data);
        _this3.queryChamados = res.data.dados.data;
        _this3.Pagination = res.data.pagination;
        _this3.contadores = res.data.contadores;
      })["finally"](function () {
        _this3.loading = false;
        _this3.isLoading = false;
        _this3.buttonSearch = false;
      });
    },
    setPage: function setPage(page) {
      this.getPage(page);
    },
    modal: function modal(dados, Idx) {
      var _this4 = this;
      this.queryModal = dados;
      this.queryIdx = Idx;
      console.log(this.queryIdx);
      $('.modalOS').modal('show');
      this.$nextTick(function () {
        var _this4$queryModal$tab, _this4$queryModal$tab2, _this4$queryModal$cd_, _this4$queryModal$cd_2;
        $('.modalOS select').select2({
          dropdownParent: $('.modalOS')
        });
        $('#id_resp_classificar').val((_this4$queryModal$tab = (_this4$queryModal$tab2 = _this4.queryModal.tab_classificacao) === null || _this4$queryModal$tab2 === void 0 || (_this4$queryModal$tab2 = _this4$queryModal$tab2.tab_responsavel) === null || _this4$queryModal$tab2 === void 0 ? void 0 : _this4$queryModal$tab2.cd_func) !== null && _this4$queryModal$tab !== void 0 ? _this4$queryModal$tab : null).trigger('change');
        $('#id_oficina_classificar').val((_this4$queryModal$cd_ = _this4.queryModal.cd_oficina) !== null && _this4$queryModal$cd_ !== void 0 ? _this4$queryModal$cd_ : null).trigger('change');
        $('#id_tipo_classificar').val((_this4$queryModal$cd_2 = _this4.queryModal.cd_tipo_os) !== null && _this4$queryModal$cd_2 !== void 0 ? _this4$queryModal$cd_2 : null).trigger('change');
        $('#id_tempo_servico').off('change.getOsTempo').on('change.getOsTempo', function () {
          return _this4.getOsTempo();
        });
      });
    },
    getClassificar: function getClassificar() {
      var _this5 = this;
      this.buttonSalvar = true;
      var form = new FormData(document.querySelector('#form-classificar'));
      form.append('cd_os', this.queryModal.cd_os);
      axios.post("/acma/json/chamados-classicacao", form).then(function (res) {
        console.log(res.data);
        toastr['info']('Classificação realizada!', 'Sucesso');
        _this5.queryModal = res.data.retorno;
        _this5.queryChamados[_this5.queryIdx] = res.data.retorno;
      })["catch"](function (err) {
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {
        _this5.loading = false;
        _this5.isLoading = false;
        _this5.buttonSalvar = false;
      });
    },
    getAprazar: function getAprazar() {
      var _this6 = this;
      this.buttonSalvar = true;
      var form = new FormData(document.querySelector('#form-aprazar'));
      form.append('cd_os', this.queryModal.cd_os);
      axios.post("/acma/json/chamados-aprazar", form).then(function (res) {
        console.log(res.data);
        toastr['info']('Aprazamento realizado!', 'Sucesso');
        //this.queryModal.tab_aprazamento = res.data.retorno;
        _this6.queryModal = res.data.retorno;
        _this6.queryChamados[_this6.queryIdx] = res.data.retorno;
        document.querySelector('#form-aprazar').reset();
      })["catch"](function (err) {
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {
        _this6.loading = false;
        _this6.isLoading = false;
        _this6.buttonSalvar = false;
      });
    },
    getServico: function getServico() {
      var _this7 = this;
      this.buttonSalvar = true;
      var form = new FormData(document.querySelector('#form-servico'));
      form.append('cd_os', this.queryModal.cd_os);
      form.set('dti', form.get('dti').replace('T', ' '));
      form.set('dtf', form.get('dtf').replace('T', ' '));
      axios.post("/acma/json/chamados-servico", form).then(function (res) {
        console.log(res.data);
        toastr['info']('Observação realizada!', 'Sucesso');
        _this7.queryModal = res.data.retorno;
        _this7.queryChamados[_this7.queryIdx] = res.data.retorno;
        document.querySelector('#form-servico').reset();
      })["catch"](function (err) {
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {
        _this7.loading = false;
        _this7.isLoading = false;
        _this7.buttonSalvar = false;
      });
    },
    getObs: function getObs() {
      var _this8 = this;
      this.buttonSalvar = true;
      var form = new FormData(document.querySelector('#form-obs'));
      form.append('cd_os', this.queryModal.cd_os);
      axios.post("/acma/json/chamados-obs", form).then(function (res) {
        console.log(res.data);
        toastr['info']('Observação realizada!', 'Sucesso');
        _this8.queryModal = res.data.retorno;
        _this8.queryChamados[_this8.queryIdx] = res.data.retorno;
        document.querySelector('#form-obs').reset();
      })["catch"](function (err) {
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {
        _this8.loading = false;
        _this8.isLoading = false;
        _this8.buttonSalvar = false;
      });
    },
    getOsTempo: function getOsTempo() {
      var inicioEl = document.querySelector('#id_inicio_servico');
      var tempoEl = document.querySelector('#id_tempo_servico');
      if (!inicioEl.value) {
        toastr['error']('Selecione a Data/Hora de Início antes de escolher o Tempo!', 'Atenção');
        inicioEl.focus();
        $(tempoEl).val(null).trigger('change.select2');
        return;
      }
      if (!tempoEl.value) {
        return;
      }
      var dtInicio = new Date(inicioEl.value);
      dtInicio.setMinutes(dtInicio.getMinutes() + parseInt(tempoEl.value));
      var pad = function pad(n) {
        return String(n).padStart(2, '0');
      };
      var dtFim = "".concat(dtInicio.getFullYear(), "-").concat(pad(dtInicio.getMonth() + 1), "-").concat(pad(dtInicio.getDate()), "T").concat(pad(dtInicio.getHours()), ":").concat(pad(dtInicio.getMinutes()));
      document.querySelector('#id_fim_servico').value = dtFim;
    },
    deleteServico: function deleteServico(id) {
      var _this9 = this;
      Swal.fire({
        title: 'Confirmação',
        text: 'Deseja realmente cancelar este serviço?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (!result.isConfirmed) {
          return;
        }
        axios.post("/acma/json/chamados-servico/cancelar/" + id).then(function (res) {
          toastr['info']('Serviço cancelado com sucesso!', 'Sucesso');
          _this9.queryModal = res.data.retorno;
          _this9.queryChamados[_this9.queryIdx] = res.data.retorno;
        })["catch"](function (err) {
          toastr['error'](err.response.data.message, 'Erro');
        });
      });
    },
    reabrirOs: function reabrirOs(id) {
      var _this0 = this;
      Swal.fire({
        title: 'Confirmação',
        text: 'Deseja realmente reabrir esta ordem de serviço?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (!result.isConfirmed) {
          return;
        }
        axios.post("/acma/json/chamados-servico/reabrir/" + id).then(function (res) {
          toastr['info']('Ordem de serviço reaberta com sucesso!', 'Sucesso');
          _this0.queryModal = res.data.retorno;
          _this0.queryChamados[_this0.queryIdx] = res.data.retorno;
        })["catch"](function (err) {
          toastr['error'](err.response.data.message, 'Erro');
        });
      });
    },
    fecharOs: function fecharOs(id) {
      var _this1 = this;
      Swal.fire({
        title: 'Confirmação',
        text: 'Deseja realmente fechar esta ordem de serviço?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (!result.isConfirmed) {
          return;
        }
        axios.post("/acma/json/chamados-servico/fechar/" + id).then(function (res) {
          toastr['info']('Ordem de serviço fechada com sucesso!', 'Sucesso');
          _this1.queryModal = res.data.retorno;
          _this1.queryChamados[_this1.queryIdx] = res.data.retorno;
        })["catch"](function (err) {
          toastr['error'](err.response.data.message, 'Erro');
        });
      });
    },
    finalizarOs: function finalizarOs(id) {
      var _this10 = this;
      Swal.fire({
        title: 'Confirmação',
        text: 'Deseja realmente finalizar esta ordem de serviço?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (!result.isConfirmed) {
          return;
        }
        axios.post("/acma/json/chamados-servico/finalizar/" + id).then(function (res) {
          toastr['info']('Ordem de serviço finalizada com sucesso!', 'Sucesso');
          _this10.queryOsAndamento = res.data.retorno;
        })["catch"](function (err) {
          toastr['error'](err.response.data.message, 'Erro');
        });
      });
    },
    getOsSuporte: function getOsSuporte() {
      var _this11 = this;
      this.buttonSalvar = true;
      var form = new FormData(document.querySelector('#form-os-suporte'));
      axios.post("/acma/json/chamados-os-suporte", form).then(function (res) {
        toastr['info']('Ordem de Serviço realizada com sucesso!', 'Sucesso');
        document.querySelector('#form-os-suporte').reset();
        document.querySelector('#id_localidade_suporte').innerHTML = '<option value="">Selecione a Localidade</option>';
        $('#form-os-suporte select').trigger('change');
        _this11.queryOsAndamento = res.data.retorno;
      })["catch"](function (err) {
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {
        _this11.buttonSalvar = false;
      });
    },
    getOsCriar: function getOsCriar() {
      var _this12 = this;
      this.buttonSalvar = true;
      var form = new FormData(document.querySelector('#form-os-criar'));
      axios.post("/acma/json/chamados-os-suporte", form).then(function (res) {
        toastr['info']('Ordem de Serviço realizada com sucesso!', 'Sucesso');
        document.querySelector('#form-os-criar').reset();
        document.querySelector('#id_localidade_criar').innerHTML = '<option value="">Selecione a Localidade</option>';
        $('#form-os-criar select').trigger('change');
      })["catch"](function (err) {
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {
        _this12.buttonSalvar = false;
      });
    },
    modalCriar: function modalCriar() {
      var _this13 = this;
      $('.modalCriar').modal('show');
      axios.post("/acma/json/chamados-andamentos").then(function (res) {
        console.log(res.data);
        _this13.queryOsAndamento = res.data.retorno;
      })["catch"](function (err) {
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {});
    }
  };
});
/******/ })()
;