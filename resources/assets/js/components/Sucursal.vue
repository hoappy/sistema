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
                        <i class="fa fa-align-justify"></i> Sucursal
                        <button type="button" @click="abrirModal('sucursal','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="direccion">Direccion</option>
                                      <option value="region">Region</option>
                                      <option value="comuna">Comuna</option>
                                      <option value="ciudad">Ciudad</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarSucursal(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarSucursal(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
                                    <th>Region</th>
                                    <th>Comuna</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sucursal in arraySucursal" :key="sucursal.id_sucursal">
                                    <td v-text="sucursal.nombre"></td>
                                    <td v-text="sucursal.telefono"></td>
                                    <td v-text="sucursal.direccion"></td>
                                    <td v-text="sucursal.region"></td>
                                    <td v-text="sucursal.comuna"></td>
                                    <td v-text="sucursal.ciudad"></td>
                                    <td>
                                        <div v-if="sucursal.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('sucursal','actualizar',sucursal)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="sucursal.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarSucursal(sucursal.id_sucursal)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarSucursal(sucursal.id_sucursal)">
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
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Ingrese el nombre / prefijo de la Sucursal">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_empresa">
                                            <option value="0" disabled>Seleccione una Empresa</option>
                                            <option v-for="empresa in arrayEmpresa" :key="empresa.id_empresa" :value="empresa.id_empresa" v-text="empresa.razonSocial"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">telefono</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="telefono" class="form-control" placeholder="Ingrese Telefono o Celular de la Sucursal">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese la Direccion de la Sucursal">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Region</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="region" class="form-control" placeholder="Ingrese la Region de la Sucursal">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Comuna</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="comuna" class="form-control" placeholder="Ingrese la Comuna de la Sucursal">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ciudad</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="ciudad" class="form-control" placeholder="Ingrese la Ciudad de la Sucursal">
                                    </div>
                                </div>
                                <div v-show="errorSucursal" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjSucursal" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSucursal()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSucursal()">Actualizar</button>
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
                id_id_sucursal: 0,
                id_empresa : 0,
                nombre : '',
                telefono : 0,
                direccion : '',
                ciudad : '',
                comuna  : '',
                region : '',
                arraySucursal : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorSucursal : 0,
                errorMostrarMsjSucursal : [],
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
                buscar : '',
                arrayEmpresa : []
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
            selectEmpresa(){
                let me=this;
                var url= '/empresa/selectEmpresa';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayEmpresa = respuesta.empresas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            listarSucursal (page,buscar,criterio){
                let me=this;
                var url= '/sucursal?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySucursal = respuesta.sucursals.data;
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
                me.listarSucursal(page,buscar,criterio);
            },
            registrarSucursal(){
                if (this.validarSucursal()){
                    return;
                }
                
                let me = this;

                axios.post('/sucursal/registrar',{
                    
                    'id_empresa': this.id_empresa,
                    'nombre': this.nombre,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'region': this.region,
                    'comuna': this.comuna,
                    'ciudad': this.ciudad,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarSucursal(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarSucursal(){
               if (this.validarSucursal()){
                    return;
                }
                
                let me = this;

                axios.put('/sucursal/actualizar',{
                    
                    'id_empresa': this.id_empresa,
                    'nombre': this.nombre,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'region': this.region,
                    'comuna': this.comuna,
                    'ciudad': this.ciudad,
                    'id_sucursal': this.id_id_sucursal
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarSucursal(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarSucursal(id_sucursal){
               swal({
                title: 'Esta seguro de desactivar esta Sucursal?',
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

                    axios.put('/sucursal/desactivar',{
                        'id_sucursal': id_sucursal
                    }).then(function (response) {
                        me.listarSucursal(1,'','nombre');
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
            activarSucursal(id_sucursal){
               swal({
                title: 'Esta seguro de activar esta Sucursal?',
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

                    axios.put('/sucursal/activar',{
                        'id_sucursal': id_sucursal
                    }).then(function (response) {
                        me.listarSucursal(1,'','nombre');
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
            validarSucursal(){
                this.errorSucursal=0;
                this.errorMostrarMsjSucursal =[];

                if (!this.id_empresa) this.errorMostrarMsjSucursal.push("Tiene que seleccionar una Empresa para la Sucursal.");
                if (!this.nombre) this.errorMostrarMsjSucursal.push("El campo Nombre no puede estar vacío.");
                if (!this.telefono) this.errorMostrarMsjSucursal.push("El campo Telefono no puede estar vacío.");
                if (!this.direccion) this.errorMostrarMsjSucursal.push("El campo Direccion no puede estar vacío.");
                if (!this.region) this.errorMostrarMsjSucursal.push("El campo Region no puede estar vacío.");
                if (!this.comuna) this.errorMostrarMsjSucursal.push("El campo Comuna no puede estar vacío.");
                if (!this.ciudad) this.errorMostrarMsjSucursal.push("El campo Ciudad no puede estar vacío.");

                if (this.errorMostrarMsjSucursal.length) this.errorSucursal = 1;

                return this.errorSucursal;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                
                this.id_empresa= 0;
                this.nombre= '';
                this.telenofo= 0;
                this.direccion= '';
                this.region= '';
                this.comuna= '';
                this.ciudad= '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "sucursal":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Sucursal';
                                
                                this.id_empresa= 0;
                                this.nombre= '';
                                this.telefono= 0;
                                this.direccion= '';
                                this.region= '';
                                this.comuna= '';
                                this.ciudad= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar Sucursal';
                                this.tipoAccion = 2;
                                this.id_id_sucursal = data['id_sucursal'];
                                
                                this.id_empresa = data['id_empresa'];
                                this.nombre = data['nombre'];
                                this.telefono = data['telefono'];
                                this.direccion = data['direccion'];
                                this.region = data['region'];
                                this.comuna = data['comuna'];
                                this.ciudad = data['ciudad'];
                                break;
                            }
                        }
                    }
                }
                this.selectEmpresa();
                
            }
        },
        mounted() {
            this.listarSucursal(1,this.buscar,this.criterio);
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
