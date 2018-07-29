import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Register from '@/pages/register/Register'
import Profile from '@/pages/profile/Profile'
import Detail from '@/pages/project/Detail'
import Member from '@/pages/project/Member'


Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/cadastro',
      name: 'Register',
      component: Register
    },
    {
      path: '/perfil',
      name: 'Profile',
      component: Profile
    },
    {
      path: '/project/:id/:title?',
      name: 'Detail',
      component: Detail,
    },
    {
      path: '/addmember/:id/project',
      name: 'Member',
      component: Member,
    }
  ]
})
