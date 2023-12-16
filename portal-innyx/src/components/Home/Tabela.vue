<template>
    <div class="card m-2">
        <DataTable :value="customers" paginator :rows="5" :rowsPerPageOptions="[5, 10, 15, 20]"
            tableStyle="min-width: 50rem" :loading="loading">
            <template #header>
                <div class="flex justify-content-end">
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="search" placeholder="Keyword Search" />
                    </span>
                </div>
            </template>
            <template #empty> Nenhum produto encontrado. </template>
            <template #loading> Produtos estão sendo carregados. Aguarde! </template>
            <Column field="nome" header="Nome" style="width: 10%"></Column>
            <Column field="descricao" header="Descrição" style="width: 20%"></Column>
            <Column field="preco" header="Preço" style="width: 10%"></Column>
            <Column field="data_validade" header="Data de Validade" style="width: 10%"></Column>
            <Column field="categoria.nome" header="Categoria" style="width: 10%"></Column>
            <Column field="imagem" header="Imagem" style="width: 20%"></Column>
            <Column header="Ações" style="width: 10%">
                <template #body="{ data }">
                    <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="" />
                    <Button icon="pi pi-trash" outlined rounded severity="danger" @click="deleteAction(data)" />
                </template>
            </Column>
        </DataTable>
    </div>
    <DeleteDialog v-if="deleteProductDialog" :show="deleteProductDialog" :product="selectedProduct" @close="closeDelete"
        @confirm="confirmDelete" />

    <EditDialog v-if="deleteProductDialog" :show="deleteProductDialog" :product="selectedProduct" @close="closeDelete"
        @confirm="confirmDelete" />
    <Toast />
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';

import DataTable from "primevue/datatable"
import Column from "primevue/column"
import InputText from "primevue/inputtext"
import { ProdutoService } from '@/services/produtos';
import Button from 'primevue/button';
import DeleteDialog from '@/components/Home/DeleteDialog.vue';
import Toast from 'primevue/toast';

import { useToast } from 'primevue/usetoast';
const toast = useToast();


const customers = ref()
const search = ref('')
const loading = ref(false)
const deleteProductDialog = ref(false)
const selectedProduct = ref({})


watch(search, () => collet())
onMounted(() => collet())

const collet = async () => {
    loading.value = true
    ProdutoService.getData(search.value, false).then(({ data: { data } }) => {
        customers.value = data
        loading.value = false
    })
}

const deleteAction = (product: object) => {
    deleteProductDialog.value = true
    selectedProduct.value = product
}

const closeDelete = () => {
    deleteProductDialog.value = false
    selectedProduct.value = {}
}

const confirmDelete = () => {
    deleteProductDialog.value = false
    loading.value = true
    ProdutoService.deleteData(selectedProduct.value)
        .then(() => {
            toast.add({ severity: 'success', summary: 'Notificação', detail: 'Produto excluído com sucesso!', life: 3000 })
            collet()
        })
        .catch(() => {
            toast.add({ severity: 'error', summary: 'Alerta', detail: 'Falha ao excluir produto!', life: 3000 })
            loading.value = false
        })
}









</script>
