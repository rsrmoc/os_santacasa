/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/paginas/controle.js ***!
  \******************************************/
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
Alpine.data('app', function () {
  var _inputsFiltros;
  return {
    inputsFiltros: (_inputsFiltros = {
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
    }, _defineProperty(_inputsFiltros, "status", ['PAGO', 'NEGOCIADO', 'ATRASADO']), _defineProperty(_inputsFiltros, "condominio", null), _defineProperty(_inputsFiltros, "bloco", null), _defineProperty(_inputsFiltros, "page", 1), _inputsFiltros),
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