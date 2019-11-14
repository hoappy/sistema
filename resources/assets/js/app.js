
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('cdc', require('./components/Cdc.vue'));
Vue.component('mutual', require('./components/Mutual.vue'));
Vue.component('representante', require('./components/Representante.vue'));
Vue.component('empresa', require('./components/Empresa.vue'));
Vue.component('afp', require('./components/Afp.vue'));
Vue.component('salud', require('./components/Salud.vue'));
Vue.component('empleado', require('./components/Empleado.vue'));
Vue.component('sucursal', require('./components/Sucursal.vue'));
Vue.component('finiquito', require('./components/Finiquito.vue'));
Vue.component('licencia', require('./components/Licencia.vue'));
Vue.component('carga', require('./components/Carga.vue'));
Vue.component('haber', require('./components/Haber.vue'));
Vue.component('descuento', require('./components/Descuento.vue'));
Vue.component('liquidacion', require('./components/Liquidacion.vue'));
Vue.component('contrato', require('./components/Contrato.vue'));
Vue.component('tabla', require('./components/Tabla.vue'));


const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});
