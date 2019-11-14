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
                        <i class="fa fa-align-justify"></i> Finiquitos
                        <button type="button" @click="abrirModal('finiquito','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="rut">Articulo</option>
                                      <option value="rut">Causa</option>
                                      <option value="rut">Fecha Aviso</option>
                                      <option value="rut">Fecha Termino</option>
                                      <option value="nombre">Nombre Trabajador</option>
                                      <option value="apellido1">Apellido Paterno</option>
                                      <option value="apellido2">Apellido Materno</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarFiniquito(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarFiniquito(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>RUT Trabajador</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Fecha Aviso</th>
                                    <th>Fecha Termino</th>
                                    <th>Causa</th>
                                    <th>Detalle</th>
                                    <th>Articulo</th>
                                    
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="finiquito in arrayFiniquito" :key="finiquito.id_finiquito">
                                    <td v-text="finiquito.rut + '-' + finiquito.dv"></td>
                                    
                                    <td v-text="finiquito.nombre + ' ' + finiquito.apellido1 + ' ' + finiquito.apellido2"></td>
                                    <td v-text="finiquito.fechaAviso"></td>
                                    <td v-text="finiquito.fechaTermino"></td>
                                    <td v-text="finiquito.causa"></td>
                                    <td v-text="finiquito.detalle"></td>
                                    <td v-text="finiquito.articulo"></td>
                                
                                    <td>
                                        <div v-if="finiquito.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('finiquito','actualizar',finiquito)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="finiquito.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarFiniquito(finiquito.id_finiquito)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarFiniquito(finiquito.id_finiquito)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha Aviso</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fechaAviso" class="form-control" placeholder="Ingrese Fecha de Avisoo">
                                    </div>
                                </div>    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha Termino Contrato</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fechaTermino" class="form-control" placeholder="Ingrese Fecha de Termino">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Articulo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="articulo" class="form-control" placeholder="Ingrese el Articulo Por El Cual Se Despide Al Trabajador">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="detalle" class="form-control" placeholder="Ingrese el Detalle u Obserbacion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Causa</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="causa" class="form-control" placeholder="Causa por Cual se despide al Trabajador">
                                    </div>
                                </div>
                                
                                <div v-show="errorFiniquito" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjFiniquito" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarFiniquito()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarFiniquito()">Actualizar</button>
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
                id_id_finiquito: 0,
                id_empleado : 0,
                causa : '',
                fechaAviso : 0,
                fechaTermino : 0,
                detalle : '',
                articulo : '',

                
                arrayFiniquito : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorFiniquito : 0,
                errorMostrarMsjFiniquito : [],
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
            
            listarFiniquito (page,buscar,criterio){
                let me=this;
                var url= '/finiquito?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayFiniquito = respuesta.finiquitos.data;
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
                me.listarFiniquito(page,buscar,criterio);
            },
            registrarFiniquito(){
                if (this.validarFiniquito()){
                    return;
                }
                
                let me = this;

                axios.post('/finiquito/registrar',{
                    'causa': this.causa,
                    'fechaAviso': this.fechaAviso,
                    'fechaTermino': this.fechaTermino,
                    'detalle': this.detalle,
                    'articulo': this.articulo,
                    'id_empleado': this.id_empleado,
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarFiniquito(1,'','fechaAviso');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarFiniquito(){
               if (this.validarFiniquito()){
                    return;
                }
                
                let me = this;

                axios.put('/finiquito/actualizar',{
                    'causa': this.causa,
                    'fechaAviso': this.fechaAviso,
                    'fechaTermino': this.fechaTermino,
                    'detalle': this.detalle,
                    'articulo': this.articulo,
                    'id_empleado': this.id_empleado,
                    'id_finiquito': this.id_id_finiquito
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarFiniquito(1,'','fechaAviso');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarFiniquito(id_finiquito){
               swal({
                title: 'Esta seguro de desactivar esta Finiquito?',
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

                    axios.put('/finiquito/desactivar',{
                        'id_finiquito': id_finiquito
                    }).then(function (response) {
                        me.listarFiniquito(1,'','id_finiquito');
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
            activarFiniquito(id_finiquito){
               swal({
                title: 'Esta seguro de activar esta Finiquito?',
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

                    axios.put('/finiquito/activar',{
                        'id_finiquito': id_finiquito
                    }).then(function (response) {
                        me.listarFiniquito(1,'','fechaAviso');
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
            validarFiniquito(){
                this.errorFiniquito=0;
                this.errorMostrarMsjFiniquito =[];

                if (!this.causa) this.errorMostrarMsjFiniquito.push("La Causa no puede estar vacío.");
                if (!this.articulo) this.errorMostrarMsjFiniquito.push("El Articulo no puede estar vacío.");
                if (!this.fechaAviso) this.errorMostrarMsjFiniquito.push("La Fecha de Inicio no puede estar vacío.");
                if (!this.fechaTermino) this.errorMostrarMsjFiniquito.push("La Fecha de Termino no puede estar vacío.");
                if (!this.detalle) this.errorMostrarMsjFiniquito.push("La Detalle no puede estar vacío.");
                if (!this.id_empleado) this.errorMostrarMsjFiniquito.push("Tiene que seleccionar un Empleado.");

                if (this.errorMostrarMsjFiniquito.length) this.errorFiniquito = 1;

                return this.errorFiniquito;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.causa= '';
                this.detalle= '';
                this.articulo= '';

                this.id_empleado= 0;
                this.fechaAviso= 0;
                this.fechaTermino= 0;
  
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "finiquito":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Finiquito';
                                this.causa= '';
                                this.detalle= '';
                                this.articulo= '';

                                this.id_empleado= 0;
                                this.fechaAviso= 0;
                                this.fechaTermino= 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar Finiquito';
                                this.tipoAccion = 2;
                                this.id_id_finiquito = data['id_finiquito'];
                                this.causa= data['causa'];
                                this.detalle = data['detalle'];
                                this.articulo = data['articulo'];

                                this.id_empleado= data['id_empleado'];
                                this.fechaAviso= data['fechaAviso'];
                                this.fechaTermino= data['fechaTermino'];
                                break;
                            }
                        }
                    }
                }
                this.selectEmpleado();
                
            }
        },
        mounted() {
            this.listarFiniquito(1,this.buscar,this.criterio);
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
