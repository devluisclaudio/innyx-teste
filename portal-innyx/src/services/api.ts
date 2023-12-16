import { jwtStore } from "@/stores/jwt"
import axios from "axios"

const api = axios.create({
    baseURL: 'http://localhost:81/api'
})

api.interceptors.request.use(async function (config) {
    const store = jwtStore()
    if (store.jwt)
        config.headers.Authorization = `Bearer ${store.jwt}`

    return config;
}, error => {
    return Promise.reject(error)
})

api.interceptors.response.use(
    (response) => response,
    (error) => {
        console.log(error)

        if (error?.response?.status !== 401 || error.code === "ERR_NETWORK") {
            return Promise.reject(error);
        }

        const store = jwtStore()

        if (store.jwt && store.countRetest < 3)
            return store.refreshJwt().then(({ data }) => {
                store.setJwt(data.authorisation.token)
                return api(error.config)
            }).catch(() => {
                return Promise.reject(error)
            })

        return Promise.reject(error);
    }
);
export default api