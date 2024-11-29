<script>
import { NSpace, NInput, NButton } from 'naive-ui';
import { defineComponent, ref } from 'vue';

export default defineComponent({
  components: {
    NSpace,
    NInput,
    NButton,
  },
  setup() {
    return {
      userId: ref(null),
      password: ref(null)
    };
  }
});
</script>

<template>
  <n-space vertical>
    <h2>Welcome to Task Management System</h2>
    <n-space vertical :style="{'grid-row-gap': '1rem'}">
      <n-input v-model:value="userId" type="text" placeholder="User ID" />
      <n-input v-model:value="password" type="password" placeholder="Password" />
      <n-button type="primary" @click="$store.dispatch('authorize', {userId, password})" :disabled="!userId || !password">Authorize</n-button>
    </n-space>
  </n-space>
</template>