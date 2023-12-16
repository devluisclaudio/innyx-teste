import api from "./api"

export const ProdutoService = {
    getData () {
        return api.get('v1/produtos')
    }
}