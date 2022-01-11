import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: "#0277BD",
                secondary: "#696969",
                success: "#3DB46D",
                danger: "#eb5757",
            },
        },
    },
});
