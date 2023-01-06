import {
	defineStore
}
from 'pinia'
export const useAddressesStore = defineStore('addresses', {
	state: () => {
		return {
			list: [],
            loading:true,
			selected: [],
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
        },

		deleteSelected(callback) {

			const item = this.selected.shift()

			if(!item) return callback(true)

			api
            .delete(`/address/${item.id}`)
            .then((data) => {
				const removeIndex = this.list.findIndex((obj) => obj.id == item.id)
				if(removeIndex > -1) this.list.splice(removeIndex, 1)
                this.deleteSelected(callback)
            })
			.catch(() => {
				callback(false)
			})
		},

	},
})