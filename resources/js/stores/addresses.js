import {
	defineStore
}
from 'pinia'
export const useAddressesStore = defineStore('addresses', {
	state: () => {
		return {
			list: [],
            loading:true
		}
	},
	actions: {
		init() {
			api
            .get('/addresses')
            .then((data) => {
                console.log('addresses', data.data.data)
                this.list = data.data.data
                this.loading = false;
            })
		},

        push(d) {
            this.list.push(d)
        }
	},
})