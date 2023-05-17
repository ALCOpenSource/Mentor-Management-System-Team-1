import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";
import { createToaster } from "@meforma/vue-toaster"

import "./axios";
import "./pusher"
import App from "./App.vue";
import router from "./router";
import { plugin, defaultConfig } from "@formkit/vue";

import "./assets/main.scss";
import "@formkit/themes/genesis";
import "emoji-mart-vue-fast/css/emoji-mart.css";

import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
  components,
  directives,
});
const pinia = createPinia();
const toaster = createToaster({ 
  position: "top-right",
});
pinia.use(({store}) => {
  store.router = markRaw(router);
  store.toaster = markRaw(toaster);
})
const app = createApp(App);

app.use(plugin, defaultConfig);
app.use(pinia);
app.use(router);
app.use(vuetify);

app.mount("#app");
