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
                        <i class="fa fa-align-justify"></i> TablaDeValores
                        <button type="button" @click="abrirModal('tablaDeValores','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tipoValor">Haber o Descuento</option>
                                      <option value="tipo">Tipo</option>
                                      <option value="descripcion">Descripcion</option>
                                      <option value="valor">Valor</option>
                                      <option value="estado">Estado</option>
                                      
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarTablaDeValores(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarTablaDeValores(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Haber / Descuento</th>
                                    <th>Tipo</th>
                                    <th>Descripcion</th>
                                    <th>Valor</th>
                                    
                                    
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tablaDeValores in arrayTablaDeValores" :key="tablaDeValores.id_tablaValor">
                                    <td>
                                        <div v-if="tablaDeValores.tipoValor">
                                           Haber
                                        </div>
                                        <div v-else>
                                            Descuento    
                                        </div>
                                    </td>
                                    <td v-text="tablaDeValores.tipo"></td>
                                    <td v-text="tablaDeValores.descripcion"></td>
                                    <td v-text="tablaDeValores.valor"></td>
                                    <td>
                                        <div v-if="tablaDeValores.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('tablaDeValores','actualizar',tablaDeValores)" class="btn btn-primary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="tablaDeValores.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarTablaDeValores(tablaDeValores.id_tablaValor)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarTablaDeValores(tablaDeValores.id_tablaValor)">
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
                                    <label class="col-md-3 form-control-label" for="num-input">tipoValor</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="tipoValor">
                                            <option value="" disabled>Seleccione</option>
                                            <option value="1">Haber</option>
                                            <option value="0">Descuento</option>
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
                                
                                <div v-show="errorTablaDeValores" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjTablaDeValores" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTablaDeValores()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTablaDeValores()">Actualizar</button>
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
                id_id_tablaValor: 0,
                tipoValor : '',
                valor : 0,
                tipo : '',
                descripcion : '',
                
                arrayTablaDeValores : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorTablaDeValores : 0,
                errorMostrarMsjTablaDeValores : [],
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
            
            listarTablaDeValores (page,buscar,criterio){
                let me=this;
                var url= '/tablaDeValores?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTablaDeValores = respuesta.tablaDeValoress.data;
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
                me.listarTablaDeValores(page,buscar,criterio);
            },
            registrarTablaDeValores(){
                if (this.validarTablaDeValores()){
                    return;
                }
                
                let me = this;

                axios.post('/tablaDeValores/registrar',{
                    'valor': this.valor,
                    'tipoValor': this.tipoValor,
                    'tipo': this.tipo,
                    'descripcion': this.descripcion
                    
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarTablaDeValores(1,'','fechaInicio');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarTablaDeValores(){
               if (this.validarTablaDeValores()){
                    return;
                }
                
                let me = this;

                axios.put('/tablaDeValores/actualizar',{
                    'valor': this.valor,
                    'tipoValor': this.tipoValor,
                    'tipo': this.tipo,
                    'descripcion': this.descripcion,
                    'id_tablaValor': this.id_id_tablaValor

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarTablaDeValores(1,'','id_tablaValor');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarTablaDeValores(id_tablaValor){
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

                    axios.put('/tablaDeValores/desactivar',{
                        'id_tablaValor': id_tablaValor
                    }).then(function (response) {
                        me.listarTablaDeValores(1,'','id_tablaValor');
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
            activarTablaDeValores(id_tablaValor){
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

                    axios.put('/tablaDeValores/activar',{
                        'id_tablaValor': id_tablaValor
                    }).then(function (response) {
                        me.listarTablaDeValores(1,'','id_tablaValor');
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
            validarTablaDeValores(){
                this.errorTablaDeValores=0;
                this.errorMostrarMsjTablaDeValores =[];

                if (!this.tipoValor) this.errorMostrarMsjTablaDeValores.push("Tiene que seleccionar un Tipo (Haber/Descuento).");
                if (!this.tipo) this.errorMostrarMsjTablaDeValores.push("El Tipo no puede estar vacío.");
                if (!this.valor) this.errorMostrarMsjTablaDeValores.push("El Valor no puede estar vacío.");
                if (!this.descripcion) this.errorMostrarMsjTablaDeValores.push("La Descripcion no puede estar vacío.");
                

                if (this.errorMostrarMsjTablaDeValores.length) this.errorTablaDeValores = 1;

                return this.errorTablaDeValores;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.tipo= '';
                this.descripcion= '';
                this.tipoValor= '';
                this.valor= 0;

  
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "tablaDeValores":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar TablaDeValores';
                                this.tipo= '';
                                this.descripcion= '';
                                this.tipoValor= '';
                                this.valor= 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal = 'Actualizar TablaDeValores';
                                this.tipoAccion = 2;
                                this.id_id_tablaValor = data['id_tablaValor'];
                                this.tipo  = data['tipo'];
                                this.descripcion  = data['descripcion'];
                                this.tipoValor  = data['tipoValor'];
                                this.valor  = data['valor'];
                                break;
                            }
                        }
                    }
                }
                
                
            }
        },
        mounted() {
            this.listarTablaDeValores(1,this.buscar,this.criterio);
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
