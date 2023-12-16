import api from "./api"

export const ProdutoService = {
    getData(search: string, page: boolean) {
        return api.get(`v1/produtos?search=${search}&page=${page}`)
    },
    deleteData(product: any) {
        return api.delete(`v1/produtos/${product.id}`)
    },
    getCategorias(page = false) {
        return api.get(`v1/categorias?page=${page}`)
    },
    saveData(data: any, id = null) {
        if (!id)
            return api.post(`v1/produtos`, data)

        return api.put(`v1/produtos/${id}`, data)
    }
}