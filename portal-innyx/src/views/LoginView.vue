
<template>
    <div class="container w-full">
        <div class="card border-round-sm bg-white w-10 md:w-5 mx-auto">
            <div class="flex flex-row">
                <div class="w-full flex flex-column align-items-center justify-content-center gap-3 py-5 px-3">
                    <div class="flex flex-wrap justify-content-center align-items-center gap-2">
                        <label class="w-6rem">Email:</label>
                        <InputText id="username" type="email" class="w-12rem md:w-19rem" v-model="email"
                            :class="{ 'p-invalid': errorEmail }" placeholder="Digite seu email" />
                    </div>
                    <div class="flex flex-wrap justify-content-center align-items-center gap-2">
                        <label class="w-6rem">Senha:</label>
                        <InputText id="password" type="password" class="w-12rem md:w-19rem" v-model="password"
                            :class="{ 'p-invalid': errorPassword }" placeholder="Digite sua senha" />
                    </div>
                    <Button label="Login" icon="pi pi-user" class="w-10rem md:w-19rem mt-5" :loading="loading"
                        @click="login"></Button>
                    <Toast />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.container {
    position: absolute;
    top: 30%;
}
</style>

<script setup lang="ts">
import InputText from "primevue/inputtext"
import Button from "primevue/button"
import Toast from 'primevue/toast';

import { ref, watch, onBeforeMount } from "vue";
import { useToast } from 'primevue/usetoast';

import { validaFormLogin } from '@/utils/vaildaForm'
import { LoginService } from "@/services/login";
import { useJwtStore } from "@/stores/jwt";
import router from "@/router";
import { useUserStore } from "@/stores/user";

const toast = useToast();
const email = ref('')
const password = ref('')
const errorEmail = ref(false)
const errorPassword = ref(false)
const jwtStore = useJwtStore()
const userStore = useUserStore()

const loading = ref(false)

watch(email, () => errorEmail.value = false)
watch(password, () => errorPassword.value = false)

onBeforeMount(() => {
    if (userStore.isLoggedIn)
        router.push({ name: 'home' })
})

const login = () => {
    const { error, message, invalidEmail, invalidPassword } = validaFormLogin(email.value, password.value)
    loading.value = true

    if (invalidEmail)
        errorEmail.value = true
    if (invalidPassword)
        errorPassword.value = true

    if (error) {
        loading.value = false
        return toast.add({ severity: 'error', summary: 'Alerta', detail: message, life: 3000 });
    }

    LoginService.login(email.value, password.value).then(({ data: { access_token, user } }) => {
        userStore.setUser(user)
        jwtStore.setJwt(access_token)
        toast.add({ severity: 'success', summary: 'Bem vindo', detail: 'Logado com sucesso!', life: 3000 })
        router.push({ name: 'home' })
    }).catch(({ response: { status } }) => {
        loading.value = false
        if (status === 401)
            return toast.add({ severity: 'error', summary: 'Alerta', detail: 'Credenciais incorretas!', life: 3000 })

        return toast.add({ severity: 'error', summary: 'Alerta', detail: 'Erro interno!', life: 3000 })
    })

}
</script>
