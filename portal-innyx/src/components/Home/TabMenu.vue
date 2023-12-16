<template>
    <div class="card">
        <TabMenu :model="items" @tab-change="change" />
    </div>
</template>


<script setup lang="ts">
import { ref } from "vue";
import TabMenu, { type TabMenuChangeEvent } from "primevue/tabmenu"

const emit = defineEmits(['tabSelected'])

const items = ref([
    { label: 'Dashboard', icon: 'pi pi-home' },
    { label: 'Produtos', icon: 'pi pi-list' }
]);



const change = ({ index }: TabMenuChangeEvent) => emit('tabSelected', index)
</script>