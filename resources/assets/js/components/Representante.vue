<template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Representante
                        <button type="button" @click="abrirModal('representante','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="rut">RUT</option>
                                      <option value="nombre">Nombre</option>
                                      <option value="apellido1">Apellido Paterno</option>
                                      <option value="apellido2">Apellido Materno</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRepresentante(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarRepresentante(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>RUT</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="representante in arrayRepresentante" :key="representante.id_representante">
                                    <td v-text="representante.rut + '-' + representante.dv"></td>
                                    <td v-text="representante.nombre"></td>
                                    <td v-text="representante.apellido1"></td>
                                    <td v-text="representante.apellido2"></td>
                                    <td>
                                        <div v-if="representante.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('representante','actualizar',representante)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="representante.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarRepresentante(representante.id_representante)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarRepresentante(representante.id_representante)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">RUT</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="rut" class="form-control" placeholder="Ingrese RUT del Representante">
                                    </div>
                                </div>    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Digito  Verificador</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="dv" class="form-control" placeholder="Ingrese Digito  Verificador del RUT">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Ingrese Nombres del Representante">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido Paterno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido1" class="form-control" placeholder="Ingrese Apellido Paterno del Representante">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido Materno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido2" class="form-control" placeholder="Ingrese Materno Paterno del Representante">
                                    </div>
                                </div>
                                <div v-show="errorRepresentante" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjRepresentante" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRepresentante()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRepresentante()">Actualizar</button>
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
                id_id_representante: 0,
                rut : '',
                dv : '',
                nombre : '',
                apellido1 : '',
                apellido2 : '',
                arrayRepresentante : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorRepresentante : 0,
                errorMostrarMsjRepresentante : [],
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
            listarRepresentante (page,buscar,criterio){
                let me=this;
                var url= '/representante?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRepresentante = respuesta.representantes.data;
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
                me.listarRepresentante(page,buscar,criterio);
            },
            registrarRepresentante(){
                if (this.validarRepresentante()){
                    return;
                }
                
                let me = this;

                axios.post('/representante/registrar',{
                    'rut': this.rut,
                    'dv': this.dv,
                    'nombre': this.nombre,
                    'apellido1': this.apellido1,
                    'apellido2': this.apellido2
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRepresentante(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarRepresentante(){
               if (this.validarRepresentante()){
                    return;
                }
                
                let me = this;

                axios.put('/representante/actualizar',{
                    'rut': this.rut,
                    'dv': this.dv,
                    'nombre': this.nombre,
                    'apellido1': this.apellido1,
                    'apellido2': this.apellido2,
                    'id_representante': this.id_id_representante
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRepresentante(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarRepresentante(id_representante){
               swal({
                title: 'Esta seguro de desactivar esta Representante?',
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

                    axios.put('/representante/desactivar',{
                        'id_representante': id_representante
                    }).then(function (response) {
                        me.listarRepresentante(1,'','nombre');
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
            activarRepresentante(id_representante){
               swal({
                title: 'Esta seguro de activar esta Representante?',
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

                    axios.put('/representante/activar',{
                        'id_representante': id_representante
                    }).then(function (response) {
                        me.listarRepresentante(1,'','nombre');
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
            validarRepresentante(){
                this.errorRepresentante=0;
                this.errorMostrarMsjRepresentante =[];

                if (!this.rut) this.errorMostrarMsjRepresentante.push("El RUT del Representante no puede estar vacío.");
                if (!this.dv) this.errorMostrarMsjRepresentante.push("El Digito  Verificador no puede estar vacío.");
                if (!this.nombre) this.errorMostrarMsjRepresentante.push("El nombre de la Representante no puede estar vacío.");
                if (!this.apellido1) this.errorMostrarMsjRepresentante.push("El apellido parterno del Representante no puede estar vacío.");
                if (!this.apellido2) this.errorMostrarMsjRepresentante.push("El apellido materno del Representante no puede estar vacío.");

                if (this.errorMostrarMsjRepresentante.length) this.errorRepresentante = 1;

                return this.errorRepresentante;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.rut= '';
                this.dv= '';
                this.nombre= '';
                this.apellido1= '';
                this.apellido2= '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "representante":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Representante';
                                this.rut= '';
                                this.dv= '';
                                this.nombre= '';
                                this.apellido1= '';
                                this.apellido2= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Representannte';
                                this.tipoAccion=2;
                                this.id_id_representante=data['id_representante'];
                                this.rut = data['rut'];
                                this.dv = data['dv'];
                                this.nombre = data['nombre'];
                                this.apellido1 = data['apellido1'];
                                this.apellido2 = data['apellido2'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarRepresentante(1,this.buscar,this.criterio);
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
