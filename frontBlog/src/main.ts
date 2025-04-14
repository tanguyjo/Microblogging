import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "./style.css";
import axios from "axios";

// Configuration d'axios
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.headers.common['Accept'] = 'application/json';

createApp(App).use(router).mount("#app");
