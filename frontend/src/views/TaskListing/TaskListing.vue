<script setup>
import { defineComponent, ref } from 'vue';
import TaskListingTable from './TaskListingTable.vue';

defineProps({
  msg: String,
})

defineComponent({
  TaskListingTable
})

const count = ref(0)
</script>

<template>
  <task-listing-table/>
</template>

<style scoped>
</style>
