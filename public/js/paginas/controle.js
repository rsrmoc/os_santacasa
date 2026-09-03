/******/ (() => { // webpackBootstrap
/*!******************************************!*\
  !*** ./resources/js/paginas/controle.js ***!
  \******************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
Alpine.data('app', function () {
  return {
    inputsFiltros: _defineProperty(_defineProperty(_defineProperty(_defineProperty({
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
      tipo_conta: null
    }, "status", ['PAGO', 'NEGOCIADO', 'ATRASADO']), "condominio", null), "bloco", null), "page", 1),
    inputsPag: {
      current_page: null,
      first_page_url: null,
      last_page: null,
      per_page: null,
      next_page_url: null,
      prev_page_url: null
    },
    Pagination: null,
    loading: false,
    isLoading: false,
    boletos: [],
    boleto_selecionado: null,
    boleto_selecionado_historico: [],
    descricaoHistorico: null,
    pages: 0,
    teste_popo: [{
      "codigo": "01",
      "nome": "Um"
    }, {
      "codigo": "02",
      "nome": "Dois"
    }],
    init: function init() {
      var _this = this;
      this.getBoletos();
      $('#select-tipo').on('select2:select', function (evt) {
        _this.inputsFiltros.tipo = evt.params.data.id;
      });
      $('#select-agrupamento').on('select2:select', function (evt) {
        _this.inputsFiltros.agrupameno = evt.params.data.id;
      });
      $('#select-tipo_conta').on('select2:select', function (evt) {
        _this.inputsFiltros.tipo_conta = evt.params.data.id;
      });
      $('#select-status').on('select2:select', function (evt) {
        _this.inputsFiltros.status = evt.params.data.id;
      });
      $('#select-condominio').on('select2:select', function (evt) {
        _this.inputsFiltros.condominio = evt.params.data.id;
      });
    },
    getBoletos: function getBoletos() {
      var _this2 = this;
      this.loading = true;
      this.isLoading = true;
      axios.get('/brcondos_adv/controle-json').then(function (res) {
        retorno = res.data.dados;
        _this2.boletos = retorno.data;
        _this2.pages = retorno.data.last_page;
        _this2.Pagination = res.data.pagination;
        console.log(_this2.inputsFiltros.dti = res.data.request);
        _this2.inputsFiltros.dti = res.data.request.dti;
        _this2.inputsFiltros.dtf = res.data.request.dtf;
      })["finally"](function () {
        _this2.loading = false;
        _this2.isLoading = false;
      });
    },
    getBoletosPorFiltros: function getBoletosPorFiltros() {
      var _this3 = this;
      var resetPage = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      this.loading = true;
      this.isLoading = true;
      resetPage && (this.inputsFiltros.page = 1);
      axios.get('/brcondos_adv/controle-json', {
        params: this.inputsFiltros
      }).then(function (res) {
        retorno = res.data.dados;
        _this3.boletos = retorno.data;
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
      this.getBoletosPorFiltros();
    },
    detalhes: function detalhes(boleto) {
      var _this4 = this;
      axios.get("/brcondos_adv/controle-historico-json/".concat(boleto.cd_boleto)).then(function (res) {
        return _this4.boleto_selecionado_historico = res.data;
      });
      this.boleto_selecionado = boleto;
      console.log(boleto);
      $('#cadastro-consulta').modal('toggle');
    },
    cadastrarHistorico: function cadastrarHistorico() {
      var _this5 = this;
      axios.post("/brcondos_adv/controle-historico-json", {
        cd_boleto: this.boleto_selecionado.cd_boleto,
        nome: this.descricaoHistorico
      }).then(function (res) {
        _this5.boleto_selecionado_historico.push(res.data);
        _this5.descricaoHistorico = null;
      });
    },
    /* Exluir na tabela boletos_historico  */excluirHistorico: function excluirHistorico(cd_boleto_hist, indice) {
      var _this6 = this;
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
      }).then(function (result) {
        if (result.isConfirmed) {
          axios["delete"]("/brcondos_adv/controle-historico-json/".concat(cd_boleto_hist)).then(function (res) {
            toastr['success'](res.data.message);
            _this6.boleto_selecionado_historico.splice(indice, 1);
          });
        }
        $('#cadastro-consulta').modal('toggle');
      });
    }
  };
});
$(document).ready(function () {});
/******/ })()
;