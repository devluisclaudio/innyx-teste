<template>
    <div class="card m-2">
        <DataTable :value="customers" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
            <Column field="name" header="Nome" style="width: 20%"></Column>
            <Column field="country.name" header="Descrição" style="width: 20%"></Column>
            <Column field="company" header="Preço" style="width: 20%"></Column>
            <Column field="company" header="Data de Validade" style="width: 20%"></Column>
            <Column field="categoria.nome" header="Categoria" style="width: 20%"></Column>
        </DataTable>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { CustomerService } from './data';

import DataTable from "primevue/datatable"
import Column from "primevue/column"

onMounted(() => {
    CustomerService.getCustomersMedium().then((data) => (customers.value = data));
});

const customers = ref();

</script>
