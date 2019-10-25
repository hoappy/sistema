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
                        <i class="fa fa-align-justify"></i> Empresa
                        <button type="button" @click="abrirModal('empresa','registrar')" class="btn btn-secondary">
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarEmpresa(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEmpresa(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                <tr v-for="empresa in arrayEmpresa" :key="empresa.id_empresa">
                                    <td v-text="empresa.rut + '-' + empresa.dv"></td>
                                    <td v-text="empresa.razonSocial"></td>
                                    <td v-text="empresa.giro"></td>
                                    <td v-text="empresa.representanteNombre + ' ' + empresa.representanteAp1 + ' ' + empresa.representanteAp2"></td>
                                    <td v-text="empresa.mutual"></td>
                                    <td v-text="empresa.cdc"></td>
                                    <td v-text="empresa.correo"></td>
                                    <td v-text="empresa.telefono"></td>
                                    <td v-text="empresa.direccion"></td>
                                    <td v-text="empresa.region"></td>
                                    <td v-text="empresa.comuna"></td>
                                    <td v-text="empresa.ciudad"></td>
                                    <td>
                                        <div v-if="empresa.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('empresa','actualizar',empresa)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="empresa.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEmpresa(empresa.id_empresa)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarEmpresa(empresa.id_empresa)">
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
                                        <input type="number" v-model="rut" class="form-control" placeholder="Ingrese RUT del Empresa">
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
                                        <input type="text" v-model="razonSocial" class="form-control" placeholder="Ingrese Razon Social de la Empresa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Giro</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="giro" class="form-control" placeholder="Ingrese Giro de la Empresa">
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
                                        <input type="text" v-model="correo" class="form-control" placeholder="Ingrese el Correo de la Empresa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">telefono</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="telefono" class="form-control" placeholder="Ingrese Telefono o cCelular de la Empresa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese la Direccion de la Empresa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Region</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="region" class="form-control" placeholder="Ingrese la Region de la Empresa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Comuna</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="comuna" class="form-control" placeholder="Ingrese la Comuna de la Empresa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ciudad</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="ciudad" class="form-control" placeholder="Ingrese la Ciudad de la Empresa">
                                    </div>
                                </div>
                                <div v-show="errorEmpresa" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEmpresa" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEmpresa()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEmpresa()">Actualizar</button>
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
                id_id_empresa: 0,
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
                arrayEmpresa : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEmpresa : 0,
                errorMostrarMsjEmpresa : [],
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
            selectRepresentante(){
                let me=this;
                var url= '/representante/selectRepresentante';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayRepresentante = respuesta.representantes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
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
            listarEmpresa (page,buscar,criterio){
                let me=this;
                var url= '/empresa?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEmpresa = respuesta.empresas.data;
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
                me.listarEmpresa(page,buscar,criterio);
            },
            registrarEmpresa(){
                if (this.validarEmpresa()){
                    return;
                }
                
                let me = this;

                axios.post('/empresa/registrar',{
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
                    me.listarEmpresa(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarEmpresa(){
               if (this.validarEmpresa()){
                    return;
                }
                
                let me = this;

                axios.put('/empresa/actualizar',{
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
                    'id_empresa': this.id_id_empresa
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEmpresa(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarEmpresa(id_empresa){
               swal({
                title: 'Esta seguro de desactivar esta Empresa?',
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

                    axios.put('/empresa/desactivar',{
                        'id_empresa': id_empresa
                    }).then(function (response) {
                        me.listarEmpresa(1,'','nombre');
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
            activarEmpresa(id_empresa){
               swal({
                title: 'Esta seguro de activar esta Empresa?',
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

                    axios.put('/empresa/activar',{
                        'id_empresa': id_empresa
                    }).then(function (response) {
                        me.listarEmpresa(1,'','nombre');
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
            validarEmpresa(){
                this.errorEmpresa=0;
                this.errorMostrarMsjEmpresa =[];

                if (!this.rut) this.errorMostrarMsjEmpresa.push("El RUT del Empresa no puede estar vacío.");
                if (!this.dv) this.errorMostrarMsjEmpresa.push("El Digito  Verificador no puede estar vacío.");
                if (!this.razonSocial) this.errorMostrarMsjEmpresa.push("El campo Razon Social no puede estar vacío.");
                if (!this.giro) this.errorMostrarMsjEmpresa.push("El campo Giro no puede estar vacío.");
                if (!this.id_mutual) this.errorMostrarMsjEmpresa.push("Tiene que seleccionar un Representante para la Empresa.");
                if (!this.id_mutual) this.errorMostrarMsjEmpresa.push("Tiene que seleccionar una Mutual para la Empresa.");
                if (!this.id_cdc) this.errorMostrarMsjEmpresa.push("Tiene que seleccionar una Caja de Compensacion para la Empresa.");
                if (!this.correo) this.errorMostrarMsjEmpresa.push("El campo Razon Social no puede estar vacío.");
                if (!this.telefono) this.errorMostrarMsjEmpresa.push("El campo Telefono no puede estar vacío.");
                if (!this.direccion) this.errorMostrarMsjEmpresa.push("El campo Direccion no puede estar vacío.");
                if (!this.region) this.errorMostrarMsjEmpresa.push("El campo Region no puede estar vacío.");
                if (!this.comuna) this.errorMostrarMsjEmpresa.push("El campo Comuna no puede estar vacío.");
                if (!this.ciudad) this.errorMostrarMsjEmpresa.push("El campo Ciudad no puede estar vacío.");

                if (this.errorMostrarMsjEmpresa.length) this.errorEmpresa = 1;

                return this.errorEmpresa;
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
                    case "empresa":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Empresa';
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
                                this.tituloModal = 'Actualizar Empresa';
                                this.tipoAccion = 2;
                                this.id_id_empresa = data['id_empresa'];
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
            this.listarEmpresa(1,this.buscar,this.criterio);
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
