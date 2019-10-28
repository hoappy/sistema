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
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 5</h1>
                </div>
            </main>
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
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 9</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==10">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 10</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==11">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 11</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==12">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 12</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==13">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 13</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==14">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 14</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==15">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 15</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==16">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 16</h1>
                </div>
            </main>
        </template>

        <template v-if="menu==17">
            <main class="main">
                <div class="container-fluid">
                    <h1>Inicio 17</h1>
                </div>
            </main>
        </template>
        
    @endsection