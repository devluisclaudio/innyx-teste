<template>
  <main>
    <TabMenu @tab-selected="changeTab" />
    <Tabela v-if="selectedTab" />
    <Card v-else />
  </main>
</template>

<script setup lang="ts">
import Tabela from "@/components/Home/Tabela.vue"
import TabMenu from "@/components/Home/TabMenu.vue"
import Card from "@/components/Home/Card.vue"
import { ref, onBeforeMount } from "vue";
import { useUserStore } from "@/stores/user";
import router from "@/router";

const storeUser = useUserStore()
onBeforeMount(() => {
  if (!storeUser.isLoggedIn)
    router.push({ name: 'login' })
})

const selectedTab = ref(0)
const changeTab = (value: number) => selectedTab.value = value
</script>
