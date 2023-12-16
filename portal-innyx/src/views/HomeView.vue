<template>
  <main>
    <TabMenu @tab-selected="changeTab"/>
    <Tabela v-if="selectedTab"/>
    <Card v-else/>
  </main>
</template>

<script setup lang="ts">
import Tabela from "@/components/Home/Tabela.vue"
import TabMenu from "@/components/Home/TabMenu.vue"
import Card from "@/components/Home/Card.vue"
import { ref } from "vue";

const selectedTab = ref(0)

const changeTab = (value: number) => selectedTab.value = value
</script>
