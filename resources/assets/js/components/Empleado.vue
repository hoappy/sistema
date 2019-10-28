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
                        <i class="fa fa-align-justify"></i> Empleado
                        <button type="button" @click="abrirModal('empleado','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="rut">RUT</option>
                                      <option value="razonSocial">Razon Social</option>
                                      <option value="giro">giro</option>
                                      <option value="representante">Representannte</option>
                                      <option value="direccion">Direccion</option>
                                      <option value="region">Region</option>
                                      <option value="comuna">Comuna</option>
                                      <option value="ciudad">Ciudad</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEmpleado(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEmpleado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>RUT</th>
                                    <th>Razon Social</th>
                                    <th>Giro</th>
                                    <th>Representante</th>
                                    <th>Mutual</th>
                                    <th>Caja de Compensacion</th>
                                    <th>Correo</th>
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
                                <tr v-for="empleado in arrayEmpleado" :key="empleado.id_empleado">
                                    <td v-text="empleado.rut + '-' + empleado.dv"></td>
                                    <td v-text="empleado.razonSocial"></td>
                                    <td v-text="empleado.giro"></td>
                                    <td v-text="empleado.representanteNombre + ' ' + empleado.representanteAp1 + ' ' + empleado.representanteAp2"></td>
                                    <td v-text="empleado.mutual"></td>
                                    <td v-text="empleado.cdc"></td>
                                    <td v-text="empleado.correo"></td>
                                    <td v-text="empleado.telefono"></td>
                                    <td v-text="empleado.direccion"></td>
                                    <td v-text="empleado.region"></td>
                                    <td v-text="empleado.comuna"></td>
                                    <td v-text="empleado.ciudad"></td>
                                    <td>
                                        <div v-if="empleado.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('empleado','actualizar',empleado)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="empleado.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEmpleado(empleado.id_empleado)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarEmpleado(empleado.id_empleado)">
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
                                        <input type="number" v-model="rut" class="form-control" placeholder="Ingrese RUT del Empleado">
                                    </div>
                                </div>    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Digito  Verificador</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="dv" class="form-control" placeholder="Ingrese Digito  Verificador del RUT">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Razon Social</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="razonSocial" class="form-control" placeholder="Ingrese Razon Social de la Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Giro</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="giro" class="form-control" placeholder="Ingrese Giro de la Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Representante</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_representante">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="representante in arrayRepresentante" :key="representante.id_representante" :value="representante.id_representante" v-text="representante.nombre + ' ' + representante.apellido1 + ' ' + representante.apellido2"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Mutual</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_mutual">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="mutual in arrayMutual" :key="mutual.id_mutual" :value="mutual.id_mutual" v-text="mutual.nombre"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">cdc</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_cdc">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="cdc in arrayCdc" :key="cdc.id_cdc" :value="cdc.id_cdc" v-text="cdc.nombre"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Correo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="correo" class="form-control" placeholder="Ingrese el Correo de la Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">telefono</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="telefono" class="form-control" placeholder="Ingrese Telefono o cCelular de la Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese la Direccion de la Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Region</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="region" class="form-control" placeholder="Ingrese la Region de la Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Comuna</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="comuna" class="form-control" placeholder="Ingrese la Comuna de la Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ciudad</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="ciudad" class="form-control" placeholder="Ingrese la Ciudad de la Empleado">
                                    </div>
                                </div>
                                <div v-show="errorEmpleado" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEmpleado" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEmpleado()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEmpleado()">Actualizar</button>
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
                id_id_empleado: 0,
                id_mutual : 0,
                id_representante : 0,
                id_cdc : 0,
                rut : 0,
                dv : '',
                razonSocial : '',
                giro : '',
                correo : '',
                telefono : 0,
                direccion : '',
                ciudad : '',
                comuna  : '',
                region : '',
                arrayEmpleado : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEmpleado : 0,
                errorMostrarMsjEmpleado : [],
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
                arrayRepresentante : [],
                arrayCdc :[],
                arrayMutual: []
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
            selectCdc(){
                let me=this;
                var url= '/cdc/selectCdc';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCdc = respuesta.cdcs;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectMutual(){
                let me=this;
                var url= '/mutual/selectMutual';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayMutual = respuesta.mutuals;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarEmpleado (page,buscar,criterio){
                let me=this;
                var url= '/empleado?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEmpleado = respuesta.empleados.data;
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
                me.listarEmpleado(page,buscar,criterio);
            },
            registrarEmpleado(){
                if (this.validarEmpleado()){
                    return;
                }
                
                let me = this;

                axios.post('/empleado/registrar',{
                    'rut': this.rut,
                    'dv': this.dv,
                    'razonSocial': this.razonSocial,
                    'giro': this.giro,
                    'id_representante': this.id_representante,
                    'id_mutual': this.id_mutual,
                    'id_cdc': this.id_cdc,
                    'correo': this.correo,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'region': this.region,
                    'comuna': this.comuna,
                    'ciudad': this.ciudad,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarEmpleado(){
               if (this.validarEmpleado()){
                    return;
                }
                
                let me = this;

                axios.put('/empleado/actualizar',{
                    'rut': this.rut,
                    'dv': this.dv,
                    'razonSocial': this.razonSocial,
                    'giro': this.giro,
                    'id_representante': this.id_representante,
                    'id_mutual': this.id_mutual,
                    'id_cdc': this.id_cdc,
                    'correo': this.correo,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'region': this.region,
                    'comuna': this.comuna,
                    'ciudad': this.ciudad,
                    'id_empleado': this.id_id_empleado
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarEmpleado(id_empleado){
               swal({
                title: 'Esta seguro de desactivar esta Empleado?',
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

                    axios.put('/empleado/desactivar',{
                        'id_empleado': id_empleado
                    }).then(function (response) {
                        me.listarEmpleado(1,'','nombre');
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
            activarEmpleado(id_empleado){
               swal({
                title: 'Esta seguro de activar esta Empleado?',
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

                    axios.put('/empleado/activar',{
                        'id_empleado': id_empleado
                    }).then(function (response) {
                        me.listarEmpleado(1,'','nombre');
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
            validarEmpleado(){
                this.errorEmpleado=0;
                this.errorMostrarMsjEmpleado =[];

                if (!this.rut) this.errorMostrarMsjEmpleado.push("El RUT del Empleado no puede estar vacío.");
                if (!this.dv) this.errorMostrarMsjEmpleado.push("El Digito  Verificador no puede estar vacío.");
                if (!this.razonSocial) this.errorMostrarMsjEmpleado.push("El campo Razon Social no puede estar vacío.");
                if (!this.giro) this.errorMostrarMsjEmpleado.push("El campo Giro no puede estar vacío.");
                if (!this.id_mutual) this.errorMostrarMsjEmpleado.push("Tiene que seleccionar un Representante para la Empleado.");
                if (!this.id_mutual) this.errorMostrarMsjEmpleado.push("Tiene que seleccionar una Mutual para la Empleado.");
                if (!this.id_cdc) this.errorMostrarMsjEmpleado.push("Tiene que seleccionar una Caja de Compensacion para la Empleado.");
                if (!this.correo) this.errorMostrarMsjEmpleado.push("El campo Razon Social no puede estar vacío.");
                if (!this.telefono) this.errorMostrarMsjEmpleado.push("El campo Telefono no puede estar vacío.");
                if (!this.direccion) this.errorMostrarMsjEmpleado.push("El campo Direccion no puede estar vacío.");
                if (!this.region) this.errorMostrarMsjEmpleado.push("El campo Region no puede estar vacío.");
                if (!this.comuna) this.errorMostrarMsjEmpleado.push("El campo Comuna no puede estar vacío.");
                if (!this.ciudad) this.errorMostrarMsjEmpleado.push("El campo Ciudad no puede estar vacío.");

                if (this.errorMostrarMsjEmpleado.length) this.errorEmpleado = 1;

                return this.errorEmpleado;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.rut= 0;
                this.dv= '';
                this.razonSocial= '';
                this.giro= '';
                this.id_representante= 0;
                this.id_mutual= 0;
                this.id_cdc= 0;
                this.correo= '';
                this.telenofo= 0;
                this.direccion= '';
                this.region= '';
                this.comuna= '';
                this.ciudad= '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "empleado":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Empleado';
                                this.rut= 0;
                                this.dv= '';
                                this.razonSocial= '';
                                this.giro= '';
                                this.id_representante= 0;
                                this.id_mutual= 0;
                                this.id_cdc= 0;
                                this.correo= '';
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
                                this.tituloModal = 'Actualizar Empleado';
                                this.tipoAccion = 2;
                                this.id_id_empleado = data['id_empleado'];
                                this.rut = data['rut'];
                                this.dv = data['dv'];
                                this.razonSocial = data['razonSocial'];
                                this.giro = data['giro'];
                                this.id_representante = data['id_representante'];
                                this.id_mutual = data['id_mutual'];
                                this.id_cdc = data['id_cdc'];
                                this.correo = data['correo'];
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
                this.selectRepresentante();
                this.selectCdc();
                this.selectMutual();
            }
        },
        mounted() {
            this.listarEmpleado(1,this.buscar,this.criterio);
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
