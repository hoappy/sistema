<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>

            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> AFP
                        <button type="button" @click="abrirModal('afp','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                      <option value="valor">Valor</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarAfp(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarAfp(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Valor</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="afp in arrayAfp" :key="afp.id_afp">
                                    <td v-text="afp.nombre"></td>
                                    <td v-text="afp.descripcion"></td>
                                    <td v-text="afp.valor"></td>
                                    <td>
                                        <div v-if="afp.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('afp','actualizar',afp)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="afp.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarAfp(afp.id_afp)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarAfp(afp.id_afp)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="descripcion" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="num-input">Valor</label>
                                    <div class="col-md-9">
                                        <input type="valor" v-model="valor" class="form-control" placeholder="Ingrese valor">
                                    </div>
                                </div>
                                <div v-show="errorAfp" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAfp" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAfp()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarAfp()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data (){
            return {
                id_id_afp: 0,
                nombre : '',
                descripcion : '',
                valor : '',
                arrayAfp : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorAfp : 0,
                errorMostrarMsjAfp : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarAfp (page,buscar,criterio){
                let me=this;
                var url= '/afp?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayAfp = respuesta.afps.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarAfp(page,buscar,criterio);
            },
            registrarAfp(){
                if (this.validarAfp()){
                    return;
                }
                
                let me = this;

                axios.post('/afp/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'valor': this.valor
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarAfp(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarAfp(){
               if (this.validarAfp()){
                    return;
                }
                
                let me = this;

                axios.put('/afp/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'valor': this.valor,
                    'id_afp': this.id_id_afp
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarAfp(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarAfp(id_afp){
               swal({
                title: 'Esta seguro de desactivar esta AFP?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/afp/desactivar',{
                        'id_afp': id_afp
                    }).then(function (response) {
                        me.listarAfp(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarAfp(id_afp){
               swal({
                title: 'Esta seguro de activar esta AFP?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/afp/activar',{
                        'id_afp': id_afp
                    }).then(function (response) {
                        me.listarAfp(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarAfp(){
                this.errorAfp=0;
                this.errorMostrarMsjAfp =[];

                if (!this.nombre) this.errorMostrarMsjAfp.push("El nombre de la AFP no puede estar vacío.");
                if (!this.descripcion) this.errorMostrarMsjAfp.push("la descripcion de la AFP no puede estar vacío.");
                if (!this.valor) this.errorMostrarMsjAfp.push("El valor de la AFP no puede estar vacío.");

                if (this.errorMostrarMsjAfp.length) this.errorAfp = 1;

                return this.errorAfp;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.valor='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "afp":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar AFP';
                                this.nombre= '';
                                this.descripcion = '';
                                this.valor = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar AFP';
                                this.tipoAccion=2;
                                this.id_id_afp=data['id_afp'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                this.valor= data['valor'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarAfp(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
