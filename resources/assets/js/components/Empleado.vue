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
                                      <option value="nombre">Nombre</option>
                                      <option value="apellido1">Apellido Paterno</option>
                                      <option value="apellido2">Apellido Materno</option>
                                      <option value="direccion">Direccion</option>
                                      <!--<option value="sexo">sexo</option>-->
                                      <option value="cargo">cargo</option>
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
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Provision</th>
                                    <th>Valor Provision</th>
                                    <th>AFP</th>
                                    <th>Valor AFP</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Sexo</th>
                                    <th>Direccion</th>
                                    <th>Seguro de cesantia</th>
                                    <th>descuentos Salud</th>
                                    <th>Estado Civil</th>
                                    <th>Jornada</th>
                                    <th>Cargo</th>
                                    <th>Tipo</th>
                                    <th>Dias de Vacaciones</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="empleado in arrayEmpleado" :key="empleado.id_empleado">
                                    <td v-text="empleado.rut + '-' + empleado.dv"></td>
                                    <td v-text="empleado.nombre"></td>
                                    <td v-text="empleado.apellido1 + ' ' + empleado.apellido2"></td>
                                    <td>
                                        <div v-if="empleado.provision">
                                            <div v-text="empleado.salud + ' / Fonasa'"></div>
                                        </div>
                                        <div v-else>
                                            <div v-text="empleado.salud + ' / Isapre'"></div>
                                        </div>
                                    </td>
                                    <td v-text="empleado.valorSalud"></td>
                                    <td v-text="empleado.afp"></td>
                                    <td v-text="empleado.valorAfp"></td>
                                    <td v-text="empleado.fechaNnaci"></td>
                                    <td>
                                        <div v-if="empleado.sexo">
                                           Hombre
                                        </div>
                                        <div v-else>
                                            Mujer
                                        </div>
                                    </td>
                                    <td v-text="empleado.direccion"></td>
                                    <td v-text="empleado.seguriCesantia"></td>
                                    <td v-text="empleado.descuentosSalud"></td>
                                    <td v-text="empleado.estaoCivil"></td>
                                    <td v-text="empleado.jornada"></td>
                                    <td v-text="empleado.cargo"></td>
                                    <td v-text="empleado.tipo"></td>
                                    <td v-text="empleado.diasVacas"></td>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Ingrese Nombres del Empleado">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido Paterno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido1" class="form-control" placeholder="Ingrese Apellido Paterno del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido Materno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido2" class="form-control" placeholder="Ingrese Materno Paterno del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Provision (Salud: Fonasa/Isapre</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_salud">
                                            <option value="0" disabled>Seleccione</option>
                                               <option v-for="salud in arraySalud" :key="salud.id_salud" :value="salud.id_salud" v-text="salud.nombre"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">AFP</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_afp">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="afp in arrayAfp" :key="afp.id_afp" :value="afp.id_afp" v-text="afp.nombre"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="date-input">Fecha de Nacimiento</label>
                                    <div class="col-md-9">
                                        <input type="date(yyyy-mm-dd)"  v-model="fechaNnaci" class="form-control" placeholder="Ingrese Fecha de Nacimiento del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="num-input">Sexo</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="sexo">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="0">Hombre</option>
                                            <option value="1">Mujer</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Dias de Vacaciones</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="diasVacas" class="form-control" placeholder="Ingrese dias de Vacaciones del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese la direccion del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Seguro de Cesantia</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="seguriCesantia" class="form-control" placeholder="Ingrese Seguro de Cesantia del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descuentos de Salud</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="descuentosSalud" class="form-control" placeholder="Ingrese los Descuentos de Salud del Empleado">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Estado Civil</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="estaoCivil">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Separado(a) judicialmente">Separado(a) judicialmente</option>
                                            <option value="Divorciado(a)">Divorciado(a)</option>
                                            <option value="Viudo(a)">Viudo(a)</option>
                                            <option value="Conviviente Civil">Conviviente Civil</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Jornada</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="jornada">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="Completa">Completa</option>
                                            <option value="Mañana">Mañana</option>
                                            <option value="Tarde">Tarde</option>
                                            <option value="Noche">Noche</option>
                                            <option value="Horario Libre????">Horario Libre????</option>
                                            <option value="Por Turnos???">Por Turnos???</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cargo</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="cargo">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="Jefe">Jefe</option>
                                            <option value="Director">Director</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Gerente">Gerente</option>
                                            <!--<option value="Perkin">Conviviente Civil</option>-->
                                            <option value="Obrero">Obrero</option>
                                            <option value="Temporero">Temporero</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">tipo</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="tipo">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="Pasivo">Pasivo</option>
                                            <option value="Activo">Activo</option>
                                        </select> 
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
                id_salud : 0,
                id_afp : 0,
                rut : 0,
                dv : '',
                nombre : '',
                apellido1 : '',
                apellido2 : '',
                fechaNnaci : '',
                sexo : 0,
                diasVacas : 0,
                direccion : '',
                seguriCesantia  : 0,
                descuentosSalud : 0,
                estaoCivil : '',
                jornada : '',
                cargo : '',
                tipo : '',
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
                arrayAfp :[],
                arraySalud: []
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
            selectAfp(){
                let me=this;
                var url= '/afp/selectAfp';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayAfp = respuesta.afps;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectSalud(){
                let me=this;
                var url= '/salud/selectSalud';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraySalud = respuesta.saluds;
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
                    'nombre': this.nombre,
                    'apellido1': this.apellido1,
                    'apellido2': this.apellido2,
                    'fechaNnaci': this.fechaNnaci,
                    'sexo': this.sexo,
                    'diasVacas': this.diasVacas,
                    'direccion': this.direccion,
                    'seguriCesantia': this.seguriCesantia,
                    'descuentosSalud': this.descuentosSalud,
                    'estaoCivil': this.estaoCivil,
                    'jornada': this.jornada,
                    'cargo': this.cargo,
                    'tipo': this.tipo,
                    'id_salud': this.id_salud,
                    'id_afp': this.id_afp
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
                    'nombre': this.nombre,
                    'apellido1': this.apellido1,
                    'apellido2': this.apellido2,
                    'fechaNnaci': this.fechaNnaci,
                    'sexo': this.sexo,
                    'diasVacas': this.diasVacas,
                    'direccion': this.direccion,
                    'seguriCesantia': this.seguriCesantia,
                    'descuentosSalud': this.descuentosSalud,
                    'estaoCivil': this.estaoCivil,
                    'jornada': this.jornada,
                    'cargo': this.cargo,
                    'tipo': this.tipo,
                    'id_salud': this.id_salud,
                    'id_afp': this.id_afp,
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
                title: 'Esta seguri de desactivar esta Empleado?',
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
                title: 'Esta seguri de activar esta Empleado?',
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
                if (!this.nombre) this.errorMostrarMsjEmpleado.push("El campo Nombre no puede estar vacío.");
                if (!this.apellido1) this.errorMostrarMsjEmpleado.push("El campo Apellido Paterno no puede estar vacío.");
                if (!this.apellido2) this.errorMostrarMsjEmpleado.push("El campo Apellido Materno no puede estar vacío.");
                if (!this.id_salud) this.errorMostrarMsjEmpleado.push("Tiene que seleccionar la Provision para la Empleado.");
                if (!this.id_afp) this.errorMostrarMsjEmpleado.push("Tiene que seleccionar la AFP del Empleado.");
                if (!this.fechaNnaci) this.errorMostrarMsjEmpleado.push("El Fecha Nacimiento no puede estar vacío.");
                if (!this.sexo) this.errorMostrarMsjEmpleado.push("El campo Sexo no puede estar vacío.");
                if (!this.diasVacas) this.errorMostrarMsjEmpleado.push("El campo Dias Vacaciones no puede estar vacío.");
                if (!this.direccion) this.errorMostrarMsjEmpleado.push("El campo Direccion no puede estar vacío.");
                if (!this.seguriCesantia) this.errorMostrarMsjEmpleado.push("El campo Seguro de Cesantia no puede estar vacío.");
                if (!this.descuentosSalud) this.errorMostrarMsjEmpleado.push("El campo Descuento Salud no puede estar vacío.");
                if (!this.estaoCivil) this.errorMostrarMsjEmpleado.push("El campo Estado Civil no puede estar vacío.");
                if (!this.jornada) this.errorMostrarMsjEmpleado.push("El campo Jornada no puede estar vacío.");
                if (!this.cargo) this.errorMostrarMsjEmpleado.push("El campo Cargo no puede estar vacío.");
                if (!this.tipo) this.errorMostrarMsjEmpleado.push("El campo Tipo no puede estar vacío.");

                if (this.errorMostrarMsjEmpleado.length) this.errorEmpleado = 1;

                return this.errorEmpleado;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.id_salud = 0;
                this.id_afp = 0;
                this.rut = 0;
                this.dv = '';
                this.nombre = '';
                this.apellido1 = '';
                this.apellido2 = '';
                this.fechaNnaci = '';
                this.sexo = 0;
                this.diasVacas = 0;
                this.direccion = '';
                this.seguriCesantia  = 0;
                this.descuentosSalud = 0;
                this.estaoCivil = '';
                this.jornada = '';
                this.cargo = '';
                this.tipo = ''
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
                                this.id_salud = 0;
                                this.id_afp = 0;
                                this.rut = 0;
                                this.dv = '';
                                this.nombre = '';
                                this.apellido1 = '';
                                this.apellido2 = '';
                                this.fechaNnaci = '';
                                this.sexo = 0;
                                this.diasVacas = 0;
                                this.direccion = '';
                                this.seguriCesantia  = 0;
                                this.descuentosSalud = 0;
                                this.estaoCivil = '';
                                this.jornada = '';
                                this.cargo = '';
                                this.tipo = ''
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
                                this.id_salud = data['id_salud'];
                                this.id_afp = data['id_afp'];
                                this.rut = data['rut'];
                                this.dv = data['dv'];
                                this.nombre = data['nombre'];
                                this.apellido1 = data['apellido1'];
                                this.apellido2 = data['apellido2'];
                                this.fechaNnaci = 'fechaNnaci';
                                this.sexo = data['sexo'];
                                this.diasVacas = data['diasVacas'];
                                this.direccion = data['direccion'];
                                this.seguriCesantia  = data['seguriCesantia'];
                                this.descuentosSalud = data['descuentosSalud'];
                                this.estaoCivil = data['estaoCivil'];
                                this.jornada = data['jornada'];
                                this.cargo = data['cargo'];
                                this.tipo = data['tipo'];
                                break;
                            }
                        }
                    }
                }
                this.selectAfp();
                this.selectSalud();
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
