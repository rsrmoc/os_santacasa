/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/acma/usuarios.js ***!
  \***************************************/
Alpine.data('app', function () {
  return {
    usuario_mv: null,
    nm_usuario_mv: null,
    loading: false,
    init: function init() {},
    UserMv: function UserMv() {
      var _this = this;
      this.loading = true;
      console.log(this.usuario_mv);
      axios.get("/acma/json/usuario-mv/".concat(this.usuario_mv)).then(function (res) {
        console.log(res.data);
        _this.nm_usuario_mv = res.data.nm_usuario;
        _this.usuario_mv = res.data.cd_usuario;
      })["catch"](function (err) {
        toastr['error'](err.response.data.message);
        _this.nm_usuario_mv = '';
        _this.usuario_mv = '';
      })["finally"](function () {
        _this.loading = false;
      });
    },
    storeUsuario: function storeUsuario() {
      var _this2 = this;
      this.loading = true;
      var form = new FormData(document.querySelector('#formStoreUser'));
      axios.post("/acma/json/usuario-store", form).then(function (res) {
        toastr['success']('Usuario cadastrado com sucesso!');
        setTimeout(function () {
          window.location.href = '/acma/usuarios-criar';
        }, 3000);
      })["catch"](function (err) {
        console.log(err.response.data.xx);
        toastr['error'](err.response.data.message, 'Erro');
      })["finally"](function () {
        _this2.loading = false;
      });
    }
  };
});
/******/ })()
;