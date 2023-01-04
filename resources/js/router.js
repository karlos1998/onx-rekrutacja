import {
	createRouter,
	createWebHistory
} from 'vue-router'
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
	routes: [{
			path: '/',
			component: Table,
			name: 'dashboard',
			meta: {
				middleware: "auth",
				title: `Default page :)`
			}
		},
		{
			path: '/signup',
			component: Signup,
			meta: {
				middleware: "guest",
				title: `Register`
			},
			children: [{
					path: '/signup',
					name: 'signup',
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
				}
			]
		},
		{
			path: '/signin',
			component: Signin,
			name: 'signin',
			meta: {
				middleware: "guest",
				title: `Sigin`
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


import {
	useUserStore
} from '@/stores/user'


router.beforeEach(async (to, from, next) => {

	const user = useUserStore()
	if(!user.initiated) {
    await user.init()
    if(user.logged) {
      //HELLO AGAIN
    }
  }

	console.log('user logged', user.logged, user.data)



	document.title = `Page: ${to.meta.title}`

	console.log('before each', to.meta.middleware, to.meta.middleware == "guest")

	if (to.meta.middleware == "guest") {
    /* when the user enters the login or registration page  */
    console.log('guest page...')
		if (user.logged) {
			next({name: "dashboard"})
		} else {
		  next()
    }
	} else {
		if (user.logged) {
			next()
		} else {
			next({name: "signin"})
		}
	}

})

export default router;