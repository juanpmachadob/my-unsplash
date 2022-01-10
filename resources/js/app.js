window.Vue = require("vue").default;
import App from "./App.vue";
import vuetify from "./vuetify";
import VueAxios from "vue-axios";
import axios from "axios";
import VueMasonry from 'vue-masonry-css'

Vue.use(VueAxios, axios);
Vue.use(VueMasonry);

const app = new Vue({
    el: "#app",
    vuetify,
    render: (h) => h(App),
});
