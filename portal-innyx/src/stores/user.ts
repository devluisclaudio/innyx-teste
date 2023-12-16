import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
      user: {} as object,
      isLoggedIn: false as boolean,
    }
  ),
  actions: {
    async setUser(payload: object) {
      this.user = payload
      await this.setIsLoggedIn(true)
    },
    async setIsLoggedIn(payload: boolean) {
      this.isLoggedIn = payload
    },
    async userLogout() {
      await this.setUser({})
      await this.setIsLoggedIn(false)
      localStorage.removeItem('user');
    }
  },
  persist: {
    storage: localStorage,
    paths: ['user'],
  },
})