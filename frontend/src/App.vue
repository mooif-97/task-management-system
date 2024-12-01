<script setup>
import { ref } from 'vue';
import { NConfigProvider } from 'naive-ui';
import Toaster from './components/Toaster.vue';

const theme = ref({
});
</script>

<template>
  <n-config-provider :theme="theme">
    <router-view />
    <!-- <toaster/> -->
  </n-config-provider>
</template>

<style scoped>
</style>
