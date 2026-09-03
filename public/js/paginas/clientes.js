/******/ (() => { // webpackBootstrap
/*!******************************************!*\
  !*** ./resources/js/paginas/clientes.js ***!
  \******************************************/
Alpine.data('app', function () {
  return {
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
      page: 1
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
    init: function init() {
      var _this = this;
      this.getClientes();
      $('#select-condominio').on('select2:select', function (evt) {
        _this.inputsFiltros.condominio = evt.params.data.id;
      });
    },
    getClientes: function getClientes() {
      var _this2 = this;
      this.loading = true;
      this.isLoading = true;
      axios.get('/brcondos_adv/clientes-json').then(function (res) {
        retorno = res.data.dados;
        _this2.boletos = retorno.data;
        _this2.pages = retorno.data.last_page;
        _this2.Pagination = res.data.pagination;
        console.log(res.data);
        _this2.inputsFiltros.dti = res.data.request.dti;
        _this2.inputsFiltros.dtf = res.data.request.dtf;
      })["finally"](function () {
        _this2.loading = false;
        _this2.isLoading = false;
      });
    },
    getClientesPorFiltros: function getClientesPorFiltros() {
      var _this3 = this;
      var resetPage = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      this.loading = true;
      this.isLoading = true;
      resetPage && (this.inputsFiltros.page = 1);
      console.log(this.inputsFiltros);
      axios.get('/brcondos_adv/clientes-json', {
        params: this.inputsFiltros
      }).then(function (res) {
        retorno = res.data.dados;
        _this3.boletos = retorno.data;
        console.log(res.data.dados);
        _this3.pages = retorno.data.last_page;
        _this3.Pagination = res.data.pagination;
      })["catch"](function (err) {
        return toastr['error']('Houve um erro ao fazer a pesquisa');
      })["finally"](function () {
        _this3.loading = false;
        _this3.isLoading = false;
      });
    },
    setPageBoletos: function setPageBoletos(page) {
      this.inputsFiltros.page = page;
      this.getClientesPorFiltros();
    },
    verDetalhes: function verDetalhes(boleto) {
      var _this4 = this;
      this.boletosAtrasados = [];
      this.clienteNegociacoes = [];
      this.boletoSelecionado = boleto;
      this.loadingDetalhesBoletosAtrasados = true;
      axios.get("".concat(API_URL, "/clientes-boletos-abertos"), {
        params: {
          cpf_cnpj: boleto.cpf_cnpj
        }
      }).then(function (res) {
        _this4.boletosAtrasados = res.data.boletos;
        _this4.clienteNegociacoes = res.data.negociacoes;
        _this4.historicosCliente = res.data.historico;
      })["catch"](function (error) {
        return toastr['error'](error.response.data.message);
      })["finally"](function () {
        return _this4.loadingDetalhesBoletosAtrasados = false;
      });
    },
    clearInputsNegociacao: function clearInputsNegociacao() {
      this.inputsNegociacao = {
        dt_negociacao: null,
        nr_contato: null,
        email_cliente: null,
        valor: null,
        obs: null
      };
    },
    salvarNegociacao: function salvarNegociacao() {
      var _this5 = this,
        _this$boletoSeleciona,
        _this$boletoSeleciona2,
        _this$boletoSeleciona3;
      this.loadingNegociacao = true;
      if (this.inputsNegociacao.cd_negociacao) {
        axios.put("".concat(API_URL, "/negociacao"), this.inputsNegociacao).then(function (res) {
          _this5.clienteNegociacoes = res.data.negociacoes;
          toastr['success'](res.data.message);
          _this5.clearInputsNegociacao();
        })["catch"](function (err) {
          return parseErrorsAPI(err.response.data.errors, err.response.data.message);
        })["finally"](function () {
          return _this5.loadingNegociacao = false;
        });
        return;
      }
      var data = Object.assign({}, this.inputsNegociacao);
      data.cd_condominio = (_this$boletoSeleciona = this.boletoSelecionado) === null || _this$boletoSeleciona === void 0 ? void 0 : _this$boletoSeleciona.condominio.cd_condominio;
      data.cpf_cnpj_cliente = (_this$boletoSeleciona2 = this.boletoSelecionado) === null || _this$boletoSeleciona2 === void 0 ? void 0 : _this$boletoSeleciona2.cpf_cnpj;
      data.nm_cliente = (_this$boletoSeleciona3 = this.boletoSelecionado) === null || _this$boletoSeleciona3 === void 0 ? void 0 : _this$boletoSeleciona3.nm_cliente;
      axios.post("".concat(API_URL, "/negociacao"), data).then(function (res) {
        toastr['success'](res.data.message);
        _this5.clearInputsNegociacao();
        _this5.clienteNegociacoes.push(res.data.negociacao);
        _this5.clienteNegociacoes = res.data.negociacoes;
      })["catch"](function (err) {
        return parseErrorsAPI(err.response.data.errors, err.response.data.message);
      })["finally"](function () {
        return _this5.loadingNegociacao = false;
      });
    },
    deleteNegociacao: function deleteNegociacao(cdNegociacao) {
      var _this6 = this;
      Swal.fire({
        title: 'Confirmação',
        text: "Tem certeza que deseja excluir essa negociação?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (result.isConfirmed) {
          axios["delete"]("".concat(API_URL, "/negociacao/").concat(cdNegociacao)).then(function (res) {
            var indexNegociacao = _this6.clienteNegociacoes.findIndex(function (negociacao) {
              return negociacao.cd_negociacao == cdNegociacao;
            });
            _this6.clienteNegociacoes.splice(indexNegociacao, 1);
            toastr['success'](res.data.message);
          })["catch"](function (err) {
            return parseErrorsAPI(err.response.data.errors);
          })["finally"](function () {
            return _this6.loadingBoletoNegociacao = false;
          });
        }
      });
    },
    setFormNegociacaoEdit: function setFormNegociacaoEdit(negociacao) {
      Object.assign(this.inputsNegociacao, negociacao);
    },
    openModalNegociacao: function openModalNegociacao(negociacao) {
      this.negociacaoSelecionada = Object.assign({}, negociacao);
      $('#boletos-atrasados-negociacao').select2({
        data: this.boletosAtrasados.map(function (boleto) {
          return {
            id: boleto.cd_boleto,
            text: "".concat(boleto.id_boleto, " | ").concat(boleto.tipo_conta, " | ").concat(boleto.vl_boleto)
          };
        })
      });
      $('#negociaao-modal').modal('show');
    },
    addBoletoNegociacao: function addBoletoNegociacao() {
      var _this7 = this;
      if (this.negociacaoSelecionada.boletos.find(function (boleto) {
        return boleto.cd_boleto == $('#boletos-atrasados-negociacao').val();
      })) {
        toastr['error']('Boleto já foi adicionado!');
        return;
      }
      this.loadingBoletoNegociacao = true;
      axios.post("".concat(API_URL, "/negociacao-boleto"), {
        cd_negociacao: this.negociacaoSelecionada.cd_negociacao,
        cd_boleto: $('#boletos-atrasados-negociacao').val()
      }).then(function (res) {
        _this7.negociacaoSelecionada.boletos.push(res.data.negociacao_boleto);
        toastr['success'](res.data.message);
        $('#boletos-atrasados-negociacao').val(null).trigger('change');
      })["catch"](function (err) {
        return parseErrorsAPI(err.response.data.errors);
      })["finally"](function () {
        return _this7.loadingBoletoNegociacao = false;
      });
    },
    deleteBoletoNegociacao: function deleteBoletoNegociacao(cdNegociacaoBoleto) {
      var _this8 = this;
      Swal.fire({
        title: 'Confirmação',
        text: "Tem certeza que deseja remover esse boleto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (result.isConfirmed) {
          axios["delete"]("".concat(API_URL, "/negociacao-boleto/").concat(cdNegociacaoBoleto)).then(function (res) {
            var indexBoletoNegociacao = _this8.negociacaoSelecionada.boletos.findIndex(function (boleto) {
              return boleto.cd_negociacao_boleto == cdNegociacaoBoleto;
            });
            _this8.negociacaoSelecionada.boletos.splice(indexBoletoNegociacao, 1);
            toastr['success'](res.data.message);
          })["catch"](function (err) {
            return parseErrorsAPI(err.response.data.errors);
          })["finally"](function () {
            return _this8.loadingBoletoNegociacao = false;
          });
        }
      });
    },
    enviarHistorico: function enviarHistorico() {},
    cadastrarHistorico: function cadastrarHistorico() {
      var _this9 = this;
      this.loadingFormHistorico = true;
      if (this.editCDHistorico) {
        var _data = {
          cd_historico: this.editCDHistorico,
          historico: this.inputFormHistorico
        };
        axios.put("".concat(API_URL, "/historico-cliente"), _data).then(function (res) {
          var indexHistorico = _this9.historicosCliente.findIndex(function (historico) {
            return historico.cd_historico == _this9.editCDHistorico;
          });
          _this9.historicosCliente[indexHistorico] = res.data.historico;
          _this9.clearEdicaoHistorico();
          toastr['success'](res.data.message);
        })["catch"](function (err) {
          return parseErrorsAPI(err.response.data.errors);
        })["finally"](function () {
          return _this9.loadingFormHistorico = false;
        });
        return;
      }
      var data = {
        cpf_cnpj_cliente: this.boletoSelecionado.cpf_cnpj,
        historico: this.inputFormHistorico
      };
      axios.post("".concat(API_URL, "/historico-cliente"), data).then(function (res) {
        _this9.historicosCliente.push(res.data.historico);
        _this9.inputFormHistorico = null;
        toastr['success'](res.data.message);
      })["catch"](function (err) {
        return parseErrorsAPI(err.response.data.errors);
      })["finally"](function () {
        return _this9.loadingFormHistorico = false;
      });
    },
    setEdicaoHistorico: function setEdicaoHistorico(historico) {
      this.editCDHistorico = historico.cd_historico;
      this.inputFormHistorico = historico.historico;
    },
    clearEdicaoHistorico: function clearEdicaoHistorico() {
      this.editCDHistorico = null;
      this.inputFormHistorico = null;
    },
    excluirHistorico: function excluirHistorico(cdHistorico) {
      var _this0 = this;
      Swal.fire({
        title: 'Confirmação',
        text: "Tem certeza que deseja remover esse historico?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (result.isConfirmed) {
          axios["delete"]("".concat(API_URL, "/historico-cliente/").concat(cdHistorico)).then(function (res) {
            var indexHistorico = _this0.historicosCliente.findIndex(function (historico) {
              return historico.cd_historico == cdHistorico;
            });
            _this0.historicosCliente.splice(indexHistorico, 1);
            toastr['success'](res.data.message);
          })["catch"](function (err) {
            return parseErrorsAPI(err.response.data.errors);
          })["finally"](function () {
            return _this0.loadingBoletoNegociacao = false;
          });
        }
      });
    }
  };
});
$(document).ready(function () {
  $('#cadastro-consulta, #negociaao-modal').modal({
    backdrop: 'static',
    show: false
  });
});
/******/ })()
;