<template>
    <div class="card m-2">
        <DataTable :value="customers" paginator :rows="5" :rowsPerPageOptions="[5, 10, 15, 20]" tableStyle="min-width: 50rem"
            :loading="loading">
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
            <Column field="nome" header="Nome" style="width: 20%"></Column>
            <Column field="descricao" header="Descrição" style="width: 20%"></Column>
            <Column field="preco" header="Preço" style="width: 20%"></Column>
            <Column field="data_validade" header="Data de Validade" style="width: 20%"></Column>
            <Column field="categoria.nome" header="Categoria" style="width: 20%"></Column>
        </DataTable>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

import DataTable from "primevue/datatable"
import Column from "primevue/column"
import InputText from "primevue/inputtext"
import { ProdutoService } from '@/services/produtos';

const customers = ref()
const search = ref('')
const loading = ref(false)
const totalRecords = ref(0)
const template = ref({})
onMounted(() => {
    loading.value = true
    ProdutoService.getData(search.value, false).then(({ data: { data } }) => {
        customers.value = data
        loading.value = false
        console.log(totalRecords)
    })

})








</script>
