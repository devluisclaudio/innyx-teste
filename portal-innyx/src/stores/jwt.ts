import api from '@/services/api'
import { defineStore } from 'pinia'

export const useJwtStore = defineStore('jwt', {
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
            return api.get('v1/auth/refresh')
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