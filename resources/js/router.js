import { createRouter, createWebHistory } from 'vue-router'
const routerHistory = createWebHistory()

import Signup from './pages/Signup.vue'
import Signin from './pages/Signin.vue'

import SignupPersonal from './partials/Signup/Personal.vue'
import SignupEmail from './partials/Signup/Email.vue'
import SignupPassword from './partials/Signup/Password.vue'
import SignupConfirmation from './partials/Signup/Confirmation.vue'


import Table from './pages/Table.vue'

const router = createRouter({
  history: routerHistory,
  routes: [
    {
        path: '/table',
        component: Table,
        name:'dashboard',
        meta:{
            middleware:"auth",
            title:`Default page :)`
        }
    },
    {
      path: '/signup/',
      component: Signup,
      name:'sigup',
      meta:{
          middleware:"guest",
          title:`Register`
      },
      children: [
        {
          path: '/signup/',
          //name: 'personal',
          component: SignupPersonal,
         },
        {
            path: '/signup/email',
            component: SignupEmail,
        },
        {
            path: '/signup/password',
            component: SignupPassword,
        },
        {
          path: '/signup/confirmation',
          component: SignupConfirmation,
        },
        //  {
        //    path: 'management',
        //    name: 'ComponentB',
        //    component: ComponentB
        //  }
      ]
    },
    {
      path: '/signin',
      component: Signin,
      name:'signin',
      meta:{
          middleware:"auth",
          title:`Sigin`
      }
  },
    
    // {
    //   path: '/signup',
    //   component: Signup,
    //   name: 'signup',
    //   meta:{
    //       middleware:"guest",
    //       title:`Register`
    //   }
    // },
]
});


router.beforeEach((to, from, next) => {
  document.title = `Page: ${to.meta.title}`

  // console.log('before each', to.meta.middleware, store.state.auth.authenticated)
  // if(to.meta.middleware=="guest"){
  //     if(store.state.auth.authenticated){
  //         next({name:"dashboard"})
  //     }
  //     next()
  // }else{
  //     if(store.state.auth.authenticated){
  //       socket.tryToLaunch()
  //       next()
  //     }else{
  //         next({name:"signin"})
  //     }
  // }
  console.log('beforeEach', to)
  next()
})

export default router;