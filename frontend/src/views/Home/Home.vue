<script setup>
import { NSpace, NInput, NButton } from "naive-ui";
import { defineComponent, ref, onMounted, watch } from "vue";
import { useStore } from "vuex";
import router from "../../router";
import authentication from "../../api/authenticatation-api";

const store = useStore();

const userId = ref("");
const password = ref("");
const authenticated = ref(false)

onMounted(() => {
  authenticated.value = !!localStorage.getItem('authToken')
})

// auto redirect if token is found and valid..
watch(authenticated, (newValues) => {
  if (authenticated) {
    router.push('task-listing');
  }
});

// Login API
async function authenticate() {
  const res = await authentication.loginAndGetToken({
    user_id: userId.value,
    password: password.value,
  });

  if (res.status === 200) {
    // should return .token if authentication is success
    const successToken = res.data?.token;
    // store.commit("setToken", successToken);
    // store.commit("setUserId", userId.value);

    localStorage.setItem('authToken', successToken);
    localStorage.setItem('userId', userId);

    authenticated.value = true;
  }
}
</script>

<template>
  <n-space vertical>
    <h2>Welcome to Task Management System</h2>
    <n-space vertical :style="{ 'grid-row-gap': '1rem' }">
      <n-input v-model:value="userId" type="text" placeholder="User ID" />
      <n-input v-model:value="password" type="password" placeholder="Password" />
      <n-button type="primary" @click="authenticate()" :disabled="!userId || !password">Authorize</n-button>
    </n-space>
  </n-space>
</template>
