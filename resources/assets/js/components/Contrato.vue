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
                        <i class="fa fa-align-justify"></i> Contratos
                        <button type="button" @click="abrirModal('contrato','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="rutT">Rut Trabajador</option>
                                      <option value="nombre">Nombre Trabajador</option>
                                      <option value="apellido1">Apellido Paterno</option>
                                      <option value="apellido2">Apellido Materno</option>
                                      <option value="razonSocial">Empresa (RazonZocial)</option>
                                      <option value="rutE">RUT Empresa</option>
                                      <!--<option value="sucursal">Sucursal</option>-->
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarContrato(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarContrato(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>RUT Trabajador</th>
                                    <th>Nombres y Apellidos del Trabajador</th>
                                    <th>RUT Empresa</th>
                                    <th>Empresa (Razon Social)</th>
                                    <th>Sucursal</th>
                                    <th>Sueldo Base</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>colacion</th>
                                    <th>detalle</th>
                                    
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contrato in arrayContrato" :key="contrato.id_contrato">
                                    <td v-text="contrato.rutT + '-' + contrato.dvT"></td>
                                    <td v-text="contrato.nombre + ' ' + contrato.apellido1 + ' ' + contrato.apellido2"></td>
                                    <td v-text="contrato.rutE + '-' + contrato.dvE"></td>
                                    <td v-text="contrato.razonSocial"></td>
                                    <td v-text="contrato.sucursal"></td>
                                    <td v-text="contrato.sueldoBase"></td>
                                    <td v-text="contrato.fechaInicio"></td>
                                    <td v-text="contrato.fechaFin"></td>
                                    <td v-text="contrato.colacion"></td>
                                    <td v-text="contrato.detalle"></td>

                                    <td>
                                        <div v-if="contrato.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('contrato','actualizar',contrato)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="contrato.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarContrato(contrato.id_contrato)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarContrato(contrato.id_contrato)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_empresa">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="empresa in arrayEmpresa" :key="empresa.id_empresa" :value="empresa.id_empresa" v-text="empresa.razonSocial"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sucursal</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_sucursal">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="sucursal in arraySucursal" :key="sucursal.id_sucursal" :value="sucursal.id_sucursal" v-text="sucursal.nombre"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sueldo Base</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="sueldoBase" class="form-control" placeholder="Ingrese Sueldo Base">
                                    </div>
                                </div>    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha Inicio</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fechaInicio" class="form-control" placeholder="Ingrese Fecha Inicio">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha Fin</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fechaFin" class="form-control" placeholder="Ingrese Fecha Fin">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Colacion</label>
                                    <div class="col-md-9">
                                        <input type="numb" v-model="colacion" class="form-control" placeholder="Ingrese un Valor Colacion Diaria">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="detalle" class="form-control" placeholder="Ingrese un detalle">
                                    </div>
                                </div>

                                
                                <div v-show="errorContrato" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjContrato" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarContrato()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarContrato()">Actualizar</button>
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
                id_id_contrato: 0,
                id_empleado : 0,
                id_empresa : 0,
                id_sucursal : 0,
                sueldoBase : 0,
                colacion : 0,
                fechaInicio : 0,
                fechaFin : 0,
                detalle : '',
                
                arrayContrato : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorContrato : 0,
                errorMostrarMsjContrato : [],
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
                arrayEmpleado : [],
                arraySucursal : [],
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
            selectSucursal(){
                let me=this;
                var url= '/sucursal/selectSucursal';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraySucursal = respuesta.sucursals;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            listarContrato (page,buscar,criterio){
                let me=this;
                var url= '/contrato?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayContrato = respuesta.contratos.data;
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
                me.listarContrato(page,buscar,criterio);
            },
            registrarContrato(){
                if (this.validarContrato()){
                    return;
                }
                
                let me = this;

                axios.post('/contrato/registrar',{
                    'sueldoBase': this.sueldoBase,
                    'fechaInicio': this.fechaInicio,
                    'fechaFin': this.fechaFin,
                    'detalle': this.detalle,
                    'colacion': this.colacion,
                    'id_sucursal': this.id_sucursal,
                    'id_empresa': this.id_empresa,
                    'id_empleado': this.id_empleado,
                    
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarContrato(1,'','id_contrato');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarContrato(){
               if (this.validarContrato()){
                    return;
                }
                
                let me = this;

                axios.put('/contrato/actualizar',{
                    'sueldoBase': this.sueldoBase,
                    'fechaInicio': this.fechaInicio,
                    'fechaFin': this.fechaFin,
                    'detalle': this.detalle,
                    'colacion': this.colacion,
                    'id_sucursal': this.id_sucursal,
                    'id_empresa': this.id_empresa,
                    'id_empleado': this.id_empleado,
                    'id_contrato': this.id_contrato
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarContrato(1,'','id_contrato');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarContrato(id_contrato){
               swal({
                title: 'Esta seguro de desactivar esta Contrato?',
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

                    axios.put('/contrato/desactivar',{
                        'id_contrato': id_contrato
                    }).then(function (response) {
                        me.listarContrato(1,'','id_contrato');
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
            activarContrato(id_contrato){
               swal({
                title: 'Esta seguro de activar esta Contrato?',
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

                    axios.put('/contrato/activar',{
                        'id_contrato': id_contrato
                    }).then(function (response) {
                        me.listarContrato(1,'','id_contrato');
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
            validarContrato(){
                this.errorContrato=0;
                this.errorMostrarMsjContrato =[];

                if (!this.sueldoBase) this.errorMostrarMsjContrato.push("El Suedo Base no puede estar vacío.");
                if (!this.fechaInicio) this.errorMostrarMsjContrato.push("La Fechao de Inicio no puede estar vacío.");
                if (!this.fechaFin) this.errorMostrarMsjContrato.push("La Fecha de Fin no puede estar vacío.");
                if (!this.detalle) this.errorMostrarMsjContrato.push("El Detalle no puede estar vacío.");
                if (!this.colacion) this.errorMostrarMsjContrato.push("La Colacion no puede estar vacío.");
                if (!this.id_empresa) this.errorMostrarMsjContrato.push("Tiene que seleccionar una Empresa.");
                if (!this.id_sucursal) this.errorMostrarMsjContrato.push("Tiene que seleccionar una Sucursal.");
                if (!this.id_empleado) this.errorMostrarMsjContrato.push("Tiene que seleccionar un Empleado.");

                if (this.errorMostrarMsjContrato.length) this.errorContrato = 1;

                return this.errorContrato;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.sueldobase= 0;
                this.colacion= 0;
                this.detalle= '';
                this.id_empleado= 0;
                this.id_empresa= 0;
                this.id_sucursal= 0;
                this.fechaInicio= 0;
                this.fechaFin= 0;
  
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "contrato":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Contrato';
                                this.sueldobase= 0;
                                this.colacion= 0;
                                this.detalle= '';
                                this.id_empleado= 0;
                                this.id_empresa= 0;
                                this.id_sucursal= 0;
                                this.fechaInicio= 0;
                                this.fechaFin= 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar Contrato';
                                this.tipoAccion = 2;
                                this.id_id_contrato = data['id_contrato'];
                                this.sueldobase = data['sueldobase'];
                                this.colacion = data['colacion'];
                                this.detalle = data['detalle'];
                                this.id_empleado = data['id_empleado'];
                                this.id_empresa = data['id_empresa'];
                                this.id_sucursal = data['id_sucursal'];
                                this.fechaInicio = data['fechaInicio'];
                                this.fechaFin = data['fechaFin'];
                                break;
                            }
                        }
                    }
                }
                this.selectEmpleado();
                this.selectEmpresa();
                this.selectSucursal();
                
            }
        },
        mounted() {
            this.listarContrato(1,this.buscar,this.criterio);
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
