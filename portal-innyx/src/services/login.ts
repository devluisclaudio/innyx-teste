import api from "./api"

export const LoginService = {
    login (email: string, password: string) {
        return api.post('v1/auth/login', { email, password})
    }
}