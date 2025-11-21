/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/paginas/contas/receber.js ***!
  \************************************************/
Alpine.data('appReceber', function () {
  return {
    loading: false,
    inputs: {
      tipo: null,
      dti: null,
      dtf: null,
      status: '0',
      excluido: '1',
      nome: null,
      cpf: null,
      condominios: []
    },
    init: function init() {
      var _this = this;
      $('#select-tipo').on('select2:select', function (evt) {
        return _this.inputs.tipo = evt.params.data.id;
      });
      $('#select-status').on('select2:select', function (evt) {
        return _this.inputs.status = evt.params.data.id;
      });
      $('#select-excluido').on('select2:select', function (evt) {
        return _this.inputs.excluido = evt.params.data.id;
      });
      $('#select-condominios').on('select2:select', function (evt) {
        return _this.inputs.condominios.push(evt.params.data.id);
      });
      $('#select-condominios').on('select2:unselect', function (evt) {
        return _this.inputs.condominios.splice(_this.inputs.condominios.indexOf(evt.params.data.id), 1);
      });
    },
    clear: function clear() {
      document.querySelector('#formReceber').reset();
      $('#select-tipo').val(null).trigger('change');
      $('#select-status').val(null).trigger('change');
      $('#select-excluido').val(null).trigger('change');
      $('#select-condominios').val(null).trigger('change');
    },
    save: function save() {
      var _this2 = this;
      this.loading = true;
      axios.post('/brcondos_adv/integracoes-rec-store', this.inputs).then(function (res) {
        toastr['success'](res.data.message);
        _this2.clear();
      })["catch"](function (err) {
        return toastr['error'](err.response.data.message);
      })["finally"](function () {
        return _this2.loading = false;
      });
    }
  };
});
/******/ })()
;