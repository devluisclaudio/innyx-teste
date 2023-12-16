<template>
    <Dialog v-model:visible="visible" :style="{ width: '450px' }" header="Editar Produto" :modal="true" :closable="false">
        <FormProdutos :product="productForm" @close="emit('close')" @confirm="emit('confirm')"/>
    </Dialog>
</template>

<script setup lang="ts">
import Dialog from 'primevue/dialog';
import { ref, onMounted } from 'vue';
import FormProdutos from './FormProdutos.vue';
const emit = defineEmits(['close', 'confirm'])

const { show, product} = defineProps({
  show: { type: Boolean, required: true },
  product :  { type: Object, required: true },
})

const visible = ref(false)
const productForm = ref({})
onMounted(() => {
    visible.value = show
    productForm.value = product
})






</script>