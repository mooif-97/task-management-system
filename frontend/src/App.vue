<script setup>
import { ref } from 'vue';
import { NConfigProvider } from 'naive-ui';

const theme = ref({
});
</script>

<template>
  <n-config-provider :theme="theme">
    <router-view />
  </n-config-provider>
</template>

<style scoped></style>
