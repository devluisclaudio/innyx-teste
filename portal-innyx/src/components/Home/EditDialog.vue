<template>
    <Dialog v-model:visible="visible" :style="{ width: '450px' }" header="Confirmação" :modal="true" :closable="false">
        <div class="confirmation-content">
            <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
            <span v-if="product">Certeza que deseja excluir o produto <b>{{ product.nome }}</b>?</span>
        </div>
        <template #footer>
            <Button label="No" icon="pi pi-times" text @click="emit('close')" />
            <Button label="Yes" icon="pi pi-check" text @click="emit('confirm')" />
        </template>
    </Dialog>
</template>

<script setup lang="ts">
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { ref, onMounted } from 'vue';
const emit = defineEmits(['close', 'confirm'])

const { show, product} = defineProps({
  show: { type: Boolean, required: true },
  product :  { type: Object, required: true },
})

const visible = ref(false)
onMounted(() => {
    visible.value = show
})





</script>