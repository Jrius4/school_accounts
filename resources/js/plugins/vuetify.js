import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify)


export default new Vuetify({
    icons:{
        iconfont:'mdi' || 'fa'
    },
    theme: {
        dark: false
      },
    themes:{
        light:{
            primary: '#4CAF50',
            secondary: '#9C27b0',
            accent: '#9C27b0',
            info: '#00CAE3',
        }
    }
})
