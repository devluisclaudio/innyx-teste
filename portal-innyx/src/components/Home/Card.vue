<template>
    <div class="card m-2">
        <Card>
            <template #title> Portal Innyx </template>
            <template #content>
                <p class="m-0">
                    Olá, {{ userName }}. Bem vindo ao nosso portal!
                </p>
            </template>
        </Card>
    </div>
</template>

<script setup lang="ts">
import { useUserStore } from "@/stores/user";
import Card from "primevue/card"
import { ref } from "vue";
const userStore = useUserStore()
const userName = ref('')


userName.value = userStore.user?.name ?? ''

</script>