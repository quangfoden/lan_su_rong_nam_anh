require('./bootstrap');
import { createApp } from 'vue';
import App from './App.vue';
import SimpleTypeahead from 'vue3-simple-typeahead';
import 'vue3-simple-typeahead/dist/vue3-simple-typeahead.css'; //Optional default CSS
import mitt from 'mitt';
import BootstrapVue3 from 'bootstrap-vue-3';
import 'bootstrap/scss/bootstrap.scss';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';
import router from './router/index';
import config from './config';
import VueAxios from 'vue-axios';
import axios from 'axios';
import { store } from './store/store';
import Swal from 'sweetalert2';

const emitter = mitt();
const app = createApp(App);
app.config.globalProperties.emitter = emitter;
app.use(SimpleTypeahead);
app.config.globalProperties.$swal = Swal;
app.config.globalProperties.$config = config;
app.use(VueAxios, axios, BootstrapVue3);
app.use(store);
app.use(BootstrapVue3);

// config languages
import { createI18n } from 'vue-i18n';
if (localStorage.getItem('lang') === null) {
    localStorage.setItem('lang', 'vi');
}
export const i18n = createI18n({
    locales: config.languages, // vi|en
    locale: localStorage.getItem('lang') ?? 'vi',
    defaultLocale: 'vi',
    messages: {
        vi: require('./locales/vi.json'),
        en: require('./locales/en.json')
    },
    silentTranslationWarn: true,
    silentFallbackWarn: true
});
app.use(i18n);
// config languages

app.use(router).mount('#app');
