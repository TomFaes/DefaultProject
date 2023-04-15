import './bootstrap';
import {createApp} from "vue";

import router from './services/router';
import store from '../js/services/store';

import '../sass/app.scss';
import * as bootstrap from 'bootstrap';

//import App from './pages/IndexPages/index.vue';
import App from './pages/IndexPages/main.vue';
const app = createApp(App);

app.use(router);
app.use(store);

app.mount('#app');
