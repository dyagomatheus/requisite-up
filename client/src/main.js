// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import Vuex from 'vuex'
import Vuetify from 'vuetify'
import swal from 'sweetalert'
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})
 
Vue.use(Vuetify)
Vue.use(Vuex)

Vue.prototype.$http = axios
Vue.config.productionTip = false
Vue.prototype.$api = 'http://127.0.0.1:8000/api/'

var store = {
  state:{
    user: sessionStorage.getItem('user') ? JSON.parse(sessionStorage.getItem('user')) : null,
    projectsList:[],
    tasksList:[],
    addMember:[]
  },
  getters:{
    getUser: state=>{
      return state.user
    },
    getCount: state=>{
      return state.user.count
    },
    getCount2: state=>{
      return state.user.count2
    },
    getCount3: state=>{
      return state.user.count - state.user.count2
    },
    getToken: state=>{
      return state.user.token
    },
    getProjectsList: state=>{
      return state.projectsList
    },
    getTasksList: state=>{
      return state.tasksList
    }
  },
  mutations:{
    setUser(state, u){
      state.user = u
    },
    setprojectList(state, u){
      state.projectsList = u
    },
    setTasksList(state, u){
      state.tasksList = u
    },
    setAddMember(state, u){
      state.addMember = u
    },
    setNoDone(state, u){
      state.Count2 = u
    }
  }
}

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store: new Vuex.Store(store),
  router,
  components: { App },
  template: '<App/>'
})
