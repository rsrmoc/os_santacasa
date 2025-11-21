/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/paginas/cadastro.js ***!
  \******************************************/
Alpine.data('app', function () {
  return {
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
    init: function init() {
      var _this = this;
      $('#tipoConvenio').on('select2:select', function (evt) {
        var val = evt.params.data.id;
        _this.inputsCadastro.tipo_convenio = val;
        _this.inputsCadastro.nome_convenio = null;
        _this.disabledNomeConvenio = val !== 'CON';
      });
      $('#hospital').on('select2:select', function (evt) {
        _this.inputsCadastro.hospital = evt.params.data.id;
      });
    },
    cadastro: function cadastro() {
      var _this2 = this;
      this.loadingCadastro = true;
      if (this.inputsCadastro.produtos.length == 0) {
        toastr['error']('Adicione um produto!');
        return;
      }
      axios.post('/api/cadastro', this.inputsCadastro).then(function (res) {
        toastr['success'](res.data.message);
        document.querySelector('form.panel-body').reset();
        $('#tipoConvenio').val(null).trigger('change');
        $('#hospital').val(null).trigger('change');
        _this2.inputsCadastro.produtos = [];
      })["catch"](function (err) {
        return toastr['error'](err.response.data.message);
      })["finally"](function () {
        return _this2.loadingCadastro = false;
      });
    },
    addProduto: function addProduto() {
      if (this.inputsCadastro.produtos.find(function (produto) {
        return produto == $('#produto').val();
      })) return;
      this.inputsCadastro.produtos.push($('#produto').val());
      console.log(this.inputsCadastro.produtos);
      $('#produto').val(null).trigger('change');
    },
    excluirProduto: function excluirProduto(indice) {
      var _this3 = this;
      Swal.fire({
        title: 'Confirmação',
        text: "Tem certeza que deseja excluir esse usuáro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(function (result) {
        if (result.isConfirmed) {
          _this3.inputsCadastro.produtos.splice(indice);
        }
      });
    }
  };
});
$(document).ready(function () {
  $('#produto').select2({
    ajax: {
      url: '/api/produto-pesquisa',
      processResults: function processResults(res) {
        var _$$data$results$lastP;
        var search = (_$$data$results$lastP = $('#produto').data('select2').results.lastParams) === null || _$$data$results$lastP === void 0 ? void 0 : _$$data$results$lastP.term;
        var data = res.map(function (produto) {
          return {
            id: produto.cd_produto,
            text: produto.nm_produto
          };
        });
        if (search) {
          data.unshift({
            id: search,
            text: "\"".concat(search, "\" Novo produto")
          });
        }
        return {
          results: data
        };
      }
    }
  });
});
/******/ })()
;