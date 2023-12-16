import { defineStore } from 'pinia'

type Iuser =  {
  name?: string;
  email?: string;
}

export const useUserStore = defineStore('user', {
  state: () => ({
    user: {} as Iuser,
    isLoggedIn: false as boolean,
  }
  ),
  actions: {
    async setUser(payload: Iuser) {
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
    paths: ['user', 'isLoggedIn'],
  },
})