import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => {
    return { 
        data:{}
    }
  },
  actions: {
    init() {
        console.log('init user store.')
        api
        .get("/user", this.inputs)
        .then((response) => {
            console.log(response) 
        })
        .catch((err) => {
            console.warn(err.response.data.message)
        })
        .finally(() => {
            this.processing = false
        });
    }
  },
})