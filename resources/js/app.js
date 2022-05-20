import {createApp} from 'vue'

import App from './App.vue'

import router from '../router'

import axios from 'axios'
import VueAxios from 'vue-axios'

// bulma 
require('../scss/app.scss')



// font awesome 28 Jan 2022
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas)

// jodit 
// copy code from https://libraries.io/npm/jodit-vue3
import 'jodit/build/jodit.min.css'
//import JoditEditor from 'jodit-vue3'
import JoditEditor from 'jodit-vue3'

// moment 
import moment from 'moment'

// custom method
import Form from '../js/core/Form'
import CustomText from '../js/core/CustomText'

window.Form = Form 
window.CustomText = CustomText

// axios 
window.axios = require('axios')


// vue3-cookies
// copy code from https://www.npmjs.com/package/vue3-cookies
import VueCookies from 'vue3-cookies'

const app = createApp(App)

app.config.globalProperties.$axios = axios;

app.component('font-awesome-icon',FontAwesomeIcon)
app.use(router)
app.use(VueAxios,axios)
app.use(VueCookies)
app.use(JoditEditor)
app.mount('#app')
