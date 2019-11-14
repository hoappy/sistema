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
                        <i class="fa fa-align-justify"></i> Haber
                        <button type="button" @click="abrirModal('haber','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      
                                      <option value="tipo">Tipo</option>
                                      <option value="descripcion">Descripcion</option>
                                      <option value="valor">Valor</option>
                                      <option value="estado">Estado</option>
                                      
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarHaber(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarHaber(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    
                                    <th>Tipo</th>
                                    <th>Descripcion</th>
                                    <th>Valor</th>
                                    
                                    <th>Rut Trabajador</th>
                                    <th>Fecha Liquidacion</th>
                                    
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="haber in arrayHaber" :key="haber.id_haber">
                                    
                                    
                                    <td v-text="haber.tipo"></td>
                                    <td v-text="haber.descripcion"></td>
                                    <td v-text="haber.valor"></td>

                                    
                                    <td v-text="haber.rut + '-' + haber.dv"></td>
                                    <td v-text="haber.fecha"></td>

                                    <td>
                                        <div v-if="haber.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('haber','actualizar',haber)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="haber.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarHaber(haber.id_haber)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarHaber(haber.id_haber)">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Seleccione Fecha Lquidacion</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_liquidacion">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="liquidacion in arrayLiquidacion" :key="liquidacion.id_liquidacion" :value="liquidacion.id_liquidacion" v-text="liquidacion.fecha"></option>
                                        </select> 
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tipo" class="form-control" placeholder="Ingrese el Tipo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese el Detalle u Obserbacion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="valor" class="form-control" placeholder="Ingrece el Valor">
                                    </div>
                                </div>
                                
                                <div v-show="errorHaber" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjHaber" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarHaber()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarHaber()">Actualizar</button>
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
                id_id_haber: 0,
                
                valor : 0,
                tipo : '',
                descripcion : '',
                id_liquidacion : 0,
                arrayHaber : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorHaber : 0,
                errorMostrarMsjHaber : [],
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
                arrayLiquidacion: [],
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
            selectLiquidacion(){
                let me=this;
                var url= '/liquidacion/selectLiquidacion';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayLiquidacion = respuesta.liquidacions;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarHaber (page,buscar,criterio){
                let me=this;
                var url= '/haber?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayHaber = respuesta.habers.data;
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
                me.listarHaber(page,buscar,criterio);
            },
            registrarHaber(){
                if (this.validarHaber()){
                    return;
                }
                
                let me = this;

                axios.post('/haber/registrar',{
                    'valor': this.valor,
                    'id_liquidacion': this.id_liquidacion,
                    
                    'tipo': this.tipo,
                    'descripcion': this.descripcion
                    
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHaber(1,'','id_haber');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarHaber(){
               if (this.validarHaber()){
                    return;
                }
                
                let me = this;

                axios.put('/haber/actualizar',{
                    'valor': this.valor,
                    'id_liquidacion': this.id_liquidacion,
                    'tipo': this.tipo,
                    'descripcion': this.descripcion,
                    'id_haber': this.id_id_haber

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHaber(1,'','id_haber');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarHaber(id_haber){
               swal({
                title: 'Esta seguro de desactivar este Valor?',
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

                    axios.put('/haber/desactivar',{
                        'id_haber': id_haber
                    }).then(function (response) {
                        me.listarHaber(1,'','id_haber');
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
            activarHaber(id_haber){
               swal({
                title: 'Esta seguro de activar este Vaalor?',
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

                    axios.put('/haber/activar',{
                        'id_haber': id_haber
                    }).then(function (response) {
                        me.listarHaber(1,'','id_haber');
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
            validarHaber(){
                this.errorHaber=0;
                this.errorMostrarMsjHaber =[];

               
                if (!this.tipo) this.errorMostrarMsjHaber.push("El Tipo no puede estar vacío.");
                if (!this.valor) this.errorMostrarMsjHaber.push("El Valor no puede estar vacío.");
                if (!this.descripcion) this.errorMostrarMsjHaber.push("La Descripcion no puede estar vacío.");
                if (!this.id_liquidacion) this.errorMostrarMsjHaber.push("Seleccione una Fecha de Liquidacion.");
                

                if (this.errorMostrarMsjHaber.length) this.errorHaber = 1;

                return this.errorHaber;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.tipo= '';
                this.descripcion= '';
                this.id_liquidacion= '';
                
                this.valor= 0;

  
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "haber":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Haber';
                                this.tipo= '';
                                this.descripcion= '';
                                this.id_liquidacion= '';
                                
                                this.valor= 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar Haber';
                                this.tipoAccion = 2;
                                this.id_id_haber = data['id_haber'];
                                this.tipo  = data['tipo'];
                                this.id_liquidacion  = data['id_liquidacion'];
                                this.descripcion  = data['descripcion'];
                                
                                this.valor  = data['valor'];
                                break;
                            }
                        }
                    }
                }
                this.selectLiquidacion();
                
            }
        },
        mounted() {
            this.listarHaber(1,this.buscar,this.criterio);
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
