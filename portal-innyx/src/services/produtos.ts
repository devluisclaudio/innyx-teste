import api from "./api"

export const ProdutoService = {
    getData (search: string , page: boolean) {
        return api.get(`v1/produtos?search=${search}&page=${page}`)
    },
    deleteData(product : any){
        return api.delete(`v1/produtos/${product.id}`)
    }
}