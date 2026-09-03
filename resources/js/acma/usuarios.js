 
Alpine.data('app', () => ({
    usuario_mv: null,   
    nm_usuario_mv: null,   
    loading: false,

    init() {
      
    },

    UserMv(){
        this.loading = true;
        console.log(this.usuario_mv);

        axios.get(`/acma/json/usuario-mv/${this.usuario_mv}`)
        .then((res) => { 
            console.log(res.data) 
            this.nm_usuario_mv = res.data.nm_usuario;
            this.usuario_mv = res.data.cd_usuario;
        })
        .catch((err) => { 
            toastr['error'](err.response.data.message);
            this.nm_usuario_mv = '';
            this.usuario_mv = '';
        })
        .finally(() => {
            this.loading = false; 
        });
        
    },

    storeUsuario(){
        
        this.loading = true;  
        let form = new FormData(document.querySelector('#formStoreUser'));
        axios.post(`/acma/json/usuario-store`, form)
            .then((res) => {  
                  
                toastr['success']('Usuario cadastrado com sucesso!'); 
                setTimeout(() => { window.location.href = '/acma/usuarios-criar' }, 3000)

            })
            .catch((err) => {
                console.log(err.response.data.xx);
                toastr['error'](err.response.data.message, 'Erro');
            })
            .finally(() => {
                this.loading = false;  
            });
    },

    

 
}));
