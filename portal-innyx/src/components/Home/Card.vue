<template>
    <div class="card m-2">
        <Card>
            <template #title> Portal Innyx </template>
            <template #content>
                <p class="m-0">
                    Olá, {{ user }}. Bem vindo ao nosso portal!
                </p>
            </template>
        </Card>
    </div>
</template>

<script setup lang="ts">
import Card from "primevue/card"
import { ref } from "vue";

const user = ref('')


user.value = 'Luis Cláudio'
</script>