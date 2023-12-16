import api from '@/services/api'
import { defineStore } from 'pinia'

export const jwtStore = defineStore('jwt', {
    state: () => ({
        jwt: '' as string,
        countRetest: 0 as number
    }),
    actions: {
        async setJwt(payload: string) {
            this.jwt = payload
            this.countRetest = 0
        },
        refreshJwt() {
            this.countRetest++
            return api.get('auth/refreshJwt')
        },
        async jwtLogout() {
            await this.setJwt('');
            localStorage.removeItem('jwt');
        }
    },
    persist: {
        storage: localStorage,
        paths: ['jwt'],
      },
})