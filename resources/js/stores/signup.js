import { defineStore } from 'pinia'

export const useSignupStore = defineStore('signup', {
    persist: true,

  state: () => {
    return { 
        inputs: {},
        validationErrors: {},
        indexValidator: {}
    }
  },
  // state: () => ({ count: 0 })
  actions: {
    ifIndexValid(index) {
        console.log('index validator', this.indexValidator )
      return this.indexValidator && this.indexValidator[index]
    },
    pageIndexValid(index, success) {
        this.indexValidator[index] = success
    }
  },
})