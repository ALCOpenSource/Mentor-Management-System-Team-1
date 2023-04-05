import { createApp } from 'vue'
import { createPinia } from 'pinia'
import VueFormulate from '@braid/vue-formulate'

import App from './App.vue'
import router from './router'

import './assets/main.css'
import 'virtual:uno.css'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
})

const app = createApp(App)

app.use(VueFormulate)
app.use(createPinia())
app.use(router)
app.use(vuetify)

app.mount('#app')
