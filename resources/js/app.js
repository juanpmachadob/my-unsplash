window.Vue = require('vue').default;
import App from './App.vue'
import vuetify from './vuetify'; 
import VueAxios from "vue-axios";
import axios from "axios";


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('app-bar', require('./components/AppBar.vue').default);
Vue.component('image-container', require('./components/ImageContainer.vue').default);
// Vue.component('app-bar', require('./components/AppBar.vue'));

Vue.use(VueAxios, axios);

const app = new Vue({
    el: '#app',
    vuetify,
    render: h => h(App)
});