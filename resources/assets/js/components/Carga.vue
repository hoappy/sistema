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
                        <i class="fa fa-align-justify"></i> Cargas
                        <button type="button" @click="abrirModal('carga','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="rut">Rut Trabajador</option>
                                      <option value="nombre">Nombre Trabajador</option>
                                      <option value="apellido1">Apellido Paterno</option>
                                      <option value="apellido2">Apellido Materno</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCarga(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCarga(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>RUT Trabajador</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Inicio Tramo</th>
                                    <th>Fin Tramo</th>
                                    <th>Descripcion</th>
                                    <th>Valor</th>
                                    
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="carga in arrayCarga" :key="carga.id_carga">
                                    <td v-text="carga.rut + '-' + carga.dv"></td>
                                    
                                    <td v-text="carga.nombre + ' ' + carga.apellido1 + ' ' + carga.apellido2"></td>
                                    <td v-text="carga.inicioTramo"></td>
                                    <td v-text="carga.finTramo"></td>
                                    <td v-text="carga.descripcion"></td>
                                    <td v-text="carga.valor"></td>
                                
                                    <td>
                                        <div v-if="carga.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('carga','actualizar',carga)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="carga.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCarga(carga.id_carga)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarCarga(carga.id_carga)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Empleado</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_empleado">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="empleado in arrayEmpleado" :key="empleado.id_empleado" :value="empleado.id_empleado" v-text="empleado.nombre + ' ' + empleado.apellido1 + ' ' + empleado.apellido2"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Inicio Tramo</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="inicioTramo" class="form-control" placeholder="Ingrese el Tramo de Inicio">
                                    </div>
                                </div>    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fin Tramo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="finTramo" class="form-control" placeholder="Ingrese el Tramo de Fin">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese una Descripcion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="valor" class="form-control" placeholder="Ingrese un Valor">
                                    </div>
                                </div>
                                
                                <div v-show="errorCarga" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCarga" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCarga()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCarga()">Actualizar</button>
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
                id_id_carga: 0,
                id_empleado : 0,
                valor : 0,
                inicioTramo : 0,
                finTramo : 0,
                descripcion : '',
                
                arrayCarga : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCarga : 0,
                errorMostrarMsjCarga : [],
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
                arrayEmpleado : []
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
            selectEmpleado(){
                let me=this;
                var url= '/empleado/selectEmpleado';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayEmpleado = respuesta.empleados;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            listarCarga (page,buscar,criterio){
                let me=this;
                var url= '/carga?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCarga = respuesta.cargas.data;
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
                me.listarCarga(page,buscar,criterio);
            },
            registrarCarga(){
                if (this.validarCarga()){
                    return;
                }
                
                let me = this;

                axios.post('/carga/registrar',{
                    'valor': this.valor,
                    'inicioTramo': this.inicioTramo,
                    'finTramo': this.finTramo,
                    'descripcion': this.descripcion,
                    'id_empleado': this.id_empleado,
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCarga(1,'','id_carga');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCarga(){
               if (this.validarCarga()){
                    return;
                }
                
                let me = this;

                axios.put('/carga/actualizar',{
                    'valor': this.valor,
                    'inicioTramo': this.inicioTramo,
                    'finTramo': this.finTramo,
                    'descripcion': this.descripcion,
                    'id_empleado': this.id_empleado,
                    'id_carga': this.id_id_carga
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCarga(1,'','id_carga');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarCarga(id_carga){
               swal({
                title: 'Esta seguro de desactivar esta Carga?',
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

                    axios.put('/carga/desactivar',{
                        'id_carga': id_carga
                    }).then(function (response) {
                        me.listarCarga(1,'','nombre');
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
            activarCarga(id_carga){
               swal({
                title: 'Esta seguro de activar esta Carga?',
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

                    axios.put('/carga/activar',{
                        'id_carga': id_carga
                    }).then(function (response) {
                        me.listarCarga(1,'','nombre');
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
            validarCarga(){
                this.errorCarga=0;
                this.errorMostrarMsjCarga =[];

                if (!this.valor) this.errorMostrarMsjCarga.push("El Valor no puede estar vacío.");
                if (!this.inicioTramo) this.errorMostrarMsjCarga.push("El Tramo de Inicio no puede estar vacío.");
                if (!this.finTramo) this.errorMostrarMsjCarga.push("El Tramo Final no puede estar vacío.");
                if (!this.descripcion) this.errorMostrarMsjCarga.push("La Descripcion no puede estar vacío.");
                if (!this.id_empleado) this.errorMostrarMsjCarga.push("Tiene que seleccionar un Empleado.");

                if (this.errorMostrarMsjCarga.length) this.errorCarga = 1;

                return this.errorCarga;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.valor= 0;
                this.descripcion= '';

                this.id_empleado= 0;
                this.inicioTramo= 0;
                this.finTramo= 0;
  
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "carga":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Carga';
                                this.valor= 0;
                                this.descripcion= '';

                                this.id_empleado= 0;
                                this.inicioTramo= 0;
                                this.finTramo= 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar Carga';
                                this.tipoAccion = 2;
                                this.id_id_carga = data['id_carga'];
                                this.valor= data['valor'];
                                this.descripcion = data['descripcion'];

                                this.id_empleado= data['id_empleado'];
                                this.inicioTramo= data['inicioTramo'];
                                this.finTramo= data['finTramo'];
                                break;
                            }
                        }
                    }
                }
                this.selectEmpleado();
                
            }
        },
        mounted() {
            this.listarCarga(1,this.buscar,this.criterio);
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
