    @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==1">
            <cdc></cdc>
        </template>

        <template v-if="menu==2">
            <mutual></mutual>
        </template>

        <template v-if="menu==3">
            <representante></representante>
        </template>

        <template v-if="menu==4">
            <empresa></empresa>
        </template>

        <template v-if="menu==5">
            <contrato></contrato>
        </template>

        <template v-if="menu==6">
            <empleado></empleado>
        </template>

        <template v-if="menu==7">
            <afp></afp>
        </template>

        <template v-if="menu==8">
            <salud></salud>
        </template>

        <template v-if="menu==9">
            <sucursal></sucursal>
        </template>

        <template v-if="menu==10">
            
            <carga></carga>
        </template>

        <template v-if="menu==11">
           
            <licencia></licencia>
        </template>

        <template v-if="menu==12">
            
            <finiquito></sucursal>
        </template>

        <template v-if="menu==13">
            
            <liquidacion></liquidacion>
        </template>

        <template v-if="menu==18">
            
            <tabla></tabla>
        </template>

        <template v-if="menu==14">
            
            <descuento></descuento>
        </template>

        <template v-if="menu==15">
            
            <haber></haber>
        </template>

        <template v-if="menu==16">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 17 / ayuda</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==17">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 18 / acerca de</h1>
                </div>
            </main>
        </template>
        
    @endsection