import {
	defineStore
}
from 'pinia'
export const useUserStore = defineStore('user', {
	state: () => {
		return {
			data: {},
			logged: false,
			initiated: false,
		}
	},
	actions: {
		async init() {
			this.initiated = true
			console.log('init user store.')
			await api.get("/user", this.inputs).then((response) => {
				this.data = response.data.data
				this.logged = true
			}).catch((err) => {
				console.warn(err.response.data.message)
				this.data = {}
				this.logged = false
			}).finally(
				() => {});
			console.log('user data downloaded.')
		},
		logout(callback) {

			api.post("/logout").then((response) => {
				this.data = {}
				this.logged = false
				callback(true)
			}).catch((err) => {
				callback(false)
			}).finally(
				() => {}
			);

		}
	},
})