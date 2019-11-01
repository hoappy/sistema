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
                        <i class="fa fa-align-justify"></i> Provision de Salud
                        <button type="button" @click="abrirModal('salud','registrar')" class="btn btn-secondary">
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
                                      <!--<option value="provision">Provision</option>-->
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarSalud(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarSalud(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Provision</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="salud in arraySalud" :key="salud.id_salud">
                                    <td v-text="salud.nombre"></td>
                                    <td v-text="salud.descripcion"></td>
                                    <td>
                                        <div v-if="salud.provision">
                                            Fonasa
                                        </div>
                                        <div v-else>
                                            Isapre
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <div v-if="salud.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('salud','actualizar',salud)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="salud.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarSalud(salud.id_salud)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarSalud(salud.id_salud)">
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
                                    <label class="col-md-3 form-control-label" for="num-input">Provision</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="provision">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="0">Isapre</option>
                                            <option value="1">Fonasa</option>
                                        </select> 
                                    </div>
                                </div>
                                <div v-if="provision === '0'">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre Isapre">
                                        </div>
                                    </div>
                                </div>
                                <div v-else>   
                                    <div v-if="provision === '1'"> 
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="text-input">Tramo</label>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="nombre">
                                                    <option value="" disabled>Seleccione</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="descripcion" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                    <div class="col-md-9">
                                        <input type="valor" v-model="valor" class="form-control" placeholder="Ingrese el Valor">
                                    </div>
                                </div>
                                <div v-show="errorSalud" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjSalud" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSalud()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSalud()">Actualizar</button>
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
                id_id_salud: 0,
                nombre : '',
                descripcion : '',
                provision : '',
                valor : 0,
                arraySalud : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorSalud : 0,
                errorMostrarMsjSalud : [],
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
            listarSalud (page,buscar,criterio){
                let me=this;
                var url= '/salud?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySalud = respuesta.saluds.data;
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
                me.listarSalud(page,buscar,criterio);
            },
            registrarSalud(){
                if (this.validarSalud()){
                    return;
                }
                
                let me = this;

                axios.post('/salud/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'provision': this.provision,
                    'valor': this.valor
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarSalud(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarSalud(){
               if (this.validarSalud()){
                    return;
                }
                
                let me = this;

                axios.put('/salud/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'provision': this.provision,
                    'valor': this.valor,
                    'id_salud': this.id_id_salud
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarSalud(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarSalud(id_salud){
               swal({
                title: 'Esta seguro de desactivar esta Provision de Salud?',
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

                    axios.put('/salud/desactivar',{
                        'id_salud': id_salud
                    }).then(function (response) {
                        me.listarSalud(1,'','nombre');
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
            activarSalud(id_salud){
               swal({
                title: 'Esta seguro de activar esta Provision de Salud?',
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

                    axios.put('/salud/activar',{
                        'id_salud': id_salud
                    }).then(function (response) {
                        me.listarSalud(1,'','nombre');
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
            validarSalud(){
                this.errorSalud=0;
                this.errorMostrarMsjSalud =[];

                if (!this.nombre) this.errorMostrarMsjSalud.push("El nombre de la Provision de Salud no puede estar vacío.");
                if (!this.descripcion) this.errorMostrarMsjSalud.push("la descripcion de la Provision de Salud no puede estar vacío.");
                if (!this.provision) this.errorMostrarMsjSalud.push("El provision de la Provision de Salud no puede estar vacío.");
                if (!this.provision) this.errorMostrarMsjSalud.push("El vampo Valor no puede estar vacío.");

                if (this.errorMostrarMsjSalud.length) this.errorSalud = 1;

                return this.errorSalud;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.provision='';
                this.valor=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "salud":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Provision de Salud';
                                this.nombre= '';
                                this.descripcion = '';
                                this.provision= '';
                                this.provision = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Provision de Salud';
                                this.tipoAccion=2;
                                this.id_id_salud=data['id_salud'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                this.provision= data['provision'];
                                this.provision=data['valor'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarSalud(1,this.buscar,this.criterio);
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
