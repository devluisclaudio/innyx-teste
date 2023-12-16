import axios from "axios"

const api = axios.create({
    baseURL: 'http://localhost:81/api'
})


export default api