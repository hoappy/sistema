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
                        <i class="fa fa-align-justify"></i> Liquidacions
                        <button type="button" @click="abrirModal('liquidacion','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      
                                      <!--<option value="fecha">Fecha</option>-->
                                      
                                      <!--<option value="sucursal">Sucursal</option>-->
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarLiquidacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarLiquidacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    
                                    <th>Fecha</th>
                                    <th>RUT Trabajador</th>
                                    <th>Nombres y Apellidos del Trabajador</th>
                                    <th>RUT Empresa</th>
                                    <th>Empresa (Razon Social)</th>
                                    <th>direccion</th>
                                    <th>Total Imponible</th>
                                    <th>Movilizacion</th>
                                    <th>Dias Trabajados</th>
                                    <th>Horas Extra</th>
                                    <th>ahorro Voluntario</th>
                                    <th>Total Impuesto</th>
                                    <th>Total Descuento</th>
                                    <th>Total Liquido</th>
                                    <th>Total Colacion</th>
                                    <th>Total Liquidaion</th>
                                    <th>Total Haberes</th>
                                    <th>Gratificacion</th>
                                    <th>detalle</th>

                                    
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="liquidacion in arrayLiquidacion" :key="liquidacion.id_liquidacion">
                                    <td v-text="liquidacion.fecha"></td>
                                    <td v-text="liquidacion.rutT + '-' + liquidacion.dvT"></td>
                                    <td v-text="liquidacion.nombre + ' ' + liquidacion.apellido1 + ' ' + liquidacion.apellido2"></td>
                                    <td v-text="liquidacion.rutE + '-' + liquidacion.dvE"></td>
                                    <td v-text="liquidacion.razonSocial"></td>
                                    <td v-text="liquidacion.direccionE"></td>
                                    <td v-text="liquidacion.totalImponible"></td>
                                    <td v-text="liquidacion.movilizacion"></td>
                                    <td v-text="liquidacion.diasTrabajados"></td>
                                    <td v-text="liquidacion.horasExtra"></td>
                                    <td v-text="liquidacion.ahorroVoluntario"></td>
                                    <td v-text="liquidacion.totalImpuesto"></td>
                                    <td v-text="liquidacion.totalDescuento"></td>
                                    <td v-text="liquidacion.totalLiquido"></td>
                                    <td v-text="liquidacion.totalColacion"></td>
                                    <td v-text="liquidacion.totalLiquidacion"></td>
                                    <td v-text="liquidacion.totalHaberes"></td>
                                    <td v-text="liquidacion.gratificacion"></td>
                                    <td v-text="liquidacion.detalle"></td>

                                    <td>
                                        <div v-if="liquidacion.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('liquidacion','actualizar',liquidacion)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="liquidacion.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarLiquidacion(liquidacion.id_liquidacion)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarLiquidacion(liquidacion.id_liquidacion)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="detalle" class="form-control" placeholder="Ingrese un detalle u obserbacion">
                                    </div>
                                </div>    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha Liquidacion</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fecha" class="form-control" placeholder="Ingrese Fecha">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Total Imponible</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="totalImponible" class="form-control" placeholder="Total Imponible">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Movilizacion</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="movilizacion" class="form-control" placeholder="Movilizacion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Dias Trbajados</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="diasTrabajados" class="form-control" placeholder="Dias Trbajados">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Horas Extra</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="horasExtra" class="form-control" placeholder="Horas Extra">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ahorro Voluntario</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="ahorroVoluntario" class="form-control" placeholder="Ahorro Voluntario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Total Impuestos</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="totalImpuesto" class="form-control" placeholder="Total Impuestos">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Total Descuento</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="totalDescuento" class="form-control" placeholder="Total Descuento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Total Liquido</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="totalLiquido" class="form-control" placeholder="Total Liquido">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Total Colacion</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="totalColacion" class="form-control" placeholder="Total Colacion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Total Liquidacion</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="totalLiquidacion" class="form-control" placeholder="Total Liquidacion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Total Haberes</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="totalHaberes" class="form-control" placeholder="Total Haberes">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Gratificacion</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="gratificacion" class="form-control" placeholder="Gratificacion">
                                    </div>
                                </div>

                                
                                <div v-show="errorLiquidacion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjLiquidacion" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarLiquidacion()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarLiquidacion()">Actualizar</button>
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
                id_id_liquidacion: 0,
                id_empleado : 0,
                fecha : '0',
                totalImponible : '0',
                movilizacion : '0',
                diasTrabajados : '0',
                totalImpuesto : '0',
                totalDescuento : '0',
                totalLiquido : '0',
                totalColacion : '0',
                totalLiquidacion : '0',
                totalHaberes : '0',
                gratificacion : '0',
                horasExtra : '0',
                ahorroVoluntario : '0',
                detalle : '',
                
                arrayLiquidacion : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorLiquidacion : 0,
                errorMostrarMsjLiquidacion : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'fecha',
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
            
            
            listarLiquidacion (page,buscar,criterio){
                let me=this;
                var url= '/liquidacion?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayLiquidacion = respuesta.liquidacions.data;
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
                me.listarLiquidacion(page,buscar,criterio);
            },
            registrarLiquidacion(){
                if (this.validarLiquidacion()){
                    return;
                }
                
                let me = this;

                axios.post('/liquidacion/registrar',{
                    
                    'id_empleado': this.id_empleado,
                    'detalle': this.detalle,
                    'fecha': this.fecha,
                    'totalImponible': this.totalImponible,
                    'movilizacion': this.movilizacion,
                    'diasTrabajados': this.diasTrabajados,
                    'horasExtra': this.horasExtra,
                    'ahorroVoluntario': this.ahorroVoluntario,
                    'totalImpuesto': this.totalImpuesto,
                    'totalDescuento': this.totalDescuento,
                    'totalLiquido': this.totalLiquido,
                    'totalColacion': this.totalColacion,
                    'totalLiquidacion': this.totalLiquidacion,
                    'totalHaberes': this.totalHaberes,
                    'gratificacion': this.gratificacion,

                    
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarLiquidacion(1,'','id_liquidacion');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarLiquidacion(){
               if (this.validarLiquidacion()){
                    return;
                }
                
                let me = this;

                axios.put('/liquidacion/actualizar',{
                    'id_empleado': this.id_empleado,
                    'detalle': this.detalle,
                    'fecha': this.fecha,
                    'totalImponible': this.totalImponible,
                    'movilizacion': this.movilizacion,
                    'diasTrabajados': this.diasTrabajados,
                    'horasExtra': this.horasExtra,
                    'ahorroVoluntario': this.ahorroVoluntario,
                    'totalImpuesto': this.totalImpuesto,
                    'totalDescuento': this.totalDescuento,
                    'totalLiquido': this.totalLiquido,
                    'totalColacion': this.totalColacion,
                    'totalLiquidacion': this.totalLiquidacion,
                    'totalHaberes': this.totalHaberes,
                    'gratificacion': this.gratificacion,

                    'id_liquidacion': this.id_liquidacion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarLiquidacion(1,'','id_liquidacion');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarLiquidacion(id_liquidacion){
               swal({
                title: 'Esta seguro de desactivar esta Liquidacion?',
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

                    axios.put('/liquidacion/desactivar',{
                        'id_liquidacion': id_liquidacion
                    }).then(function (response) {
                        me.listarLiquidacion(1,'','id_liquidacion');
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
            activarLiquidacion(id_liquidacion){
               swal({
                title: 'Esta seguro de activar esta Liquidacion?',
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

                    axios.put('/liquidacion/activar',{
                        'id_liquidacion': id_liquidacion
                    }).then(function (response) {
                        me.listarLiquidacion(1,'','id_liquidacion');
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
            validarLiquidacion(){
                this.errorLiquidacion=0;
                this.errorMostrarMsjLiquidacion =[];

                if (!this.detalle) this.errorMostrarMsjLiquidacion.push("El Detalle no puede estar vacío.");
                if (!this.fecha) this.errorMostrarMsjLiquidacion.push("La Fecha no puede estar vacío.");
                if (!this.totalImponible) this.errorMostrarMsjLiquidacion.push("El Total Imponible no puede estar vacío.");
                if (!this.movilizacion) this.errorMostrarMsjLiquidacion.push("La Movilizacion no puede estar vacío.");
                if (!this.diasTrabajados) this.errorMostrarMsjLiquidacion.push("Los Dias Trabajados no puede estar vacío.");
                if (!this.horasExtra) this.errorMostrarMsjLiquidacion.push("Las Horas Extra no puede estar vacío.");
                if (!this.ahorroVoluntario) this.errorMostrarMsjLiquidacion.push("El Ahorro Voluntario no puede estar vacío.");
                if (!this.totalImpuesto) this.errorMostrarMsjLiquidacion.push("El Total Impuesto no puede estar vacío.");
                if (!this.totalDescuento) this.errorMostrarMsjLiquidacion.push("El Total Descuento no puede estar vacío.");
                if (!this.totalLiquido) this.errorMostrarMsjLiquidacion.push("El Total Liquido no puede estar vacío.");
                if (!this.totalColacion) this.errorMostrarMsjLiquidacion.push("El Total Colacion no puede estar vacío.");
                if (!this.totalLiquidacion) this.errorMostrarMsjLiquidacion.push("El Total Liquidacion no puede estar vacío.");
                if (!this.totalHaberes) this.errorMostrarMsjLiquidacion.push("El Total Haberes no puede estar vacío.");
                if (!this.gratificacion) this.errorMostrarMsjLiquidacion.push("La Gratificacion no puede estar vacío.");
                
                if (!this.id_empleado) this.errorMostrarMsjLiquidacion.push("Tiene que seleccionar un Empleado.");

                if (this.errorMostrarMsjLiquidacion.length) this.errorLiquidacion = 1;

                return this.errorLiquidacion;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.id_empleado = 0;
                this.fecha = '0';
                this.totalImponible = '0';
                this.movilizacion = '0';
                this.diasTrabajados = '0';
                this.totalImpuesto = '0';
                this.totalDescuento = '0';
                this.totalLiquido = '0';
                this.totalColacion = '0';
                this.totalLiquidacion = '0';
                this.totalHaberes = '0';
                this.gratificacion = '0';
                this.horasExtra = '0';
                this.ahorroVoluntario = '0';
                this.detalle = '';
  
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "liquidacion":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Liquidacion';
                                this.tipoAccion = 1;

                                this.id_empleado = 0;
                                this.fecha = '0';
                                this.totalImponible = '0';
                                this.movilizacion = '0';
                                this.diasTrabajados = '0';
                                this.totalImpuesto = '0';
                                this.totalDescuento = '0';
                                this.totalLiquido = '0';
                                this.totalColacion = '0';
                                this.totalLiquidacion = '0';
                                this.totalHaberes = '0';
                                this.gratificacion = '0';
                                this.horasExtra = '0';
                                this.ahorroVoluntario = '0';
                                this.detalle = '';
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar Liquidacion';
                                this.tipoAccion = 2;

                                this.id_id_liquidacion = data['id_liquidacion'];
                                this.id_empleado =data['id_liquidacion'];
                                this.fecha = data['id_empleado'];
                                this.totalImponible = data['totalImponible'];
                                this.movilizacion = data['movilizacion'];
                                this.diasTrabajados = data['diasTrabajados'];
                                this.totalImpuesto = data['totalImpuesto'];
                                this.totalDescuento = data['totalDescuento'];
                                this.totalLiquido = data['totalLiquido'];
                                this.totalColacion = data['totalColacion'];
                                this.totalLiquidacion = data['totalLiquidacion'];
                                this.totalHaberes = data['totalHaberes'];
                                this.gratificacion = data['gratificacion'];
                                this.horasExtra = data['horasExtra'];
                                this.ahorroVoluntario = data['ahorroVoluntario'];
                                this.detalle = data['detalle'];
                                break;
                            }
                        }
                    }
                }
                this.selectEmpleado();

                
            }
        },
        mounted() {
            this.listarLiquidacion(1,this.buscar,this.criterio);
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
