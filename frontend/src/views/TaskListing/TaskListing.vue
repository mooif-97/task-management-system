<script setup>
import { NButton, NCard, NSpace } from 'naive-ui';
import TaskListingTable from './TaskListingTable/TaskListingTable.vue';
import TaskFilterModal from './TaskModals/TaskFilterModal.vue';
import TaskEditModal from './TaskModals/TaskEditModal.vue';
import { useStore } from 'vuex';
import { ref, computed, onMounted } from 'vue';
import taskApi from '../../api/task-api';

const store = useStore()

const isLoading = computed(() => store.getters.isLoading)

const taskAction = ref('CREATE')
const taskFilterForm = ref({})
const tableData = ref([])

function showFilterModal() {
  store.dispatch('showModal', 'taskFilterModal')
}

function showEditModal(_taskAction) {
  store.dispatch('showModal', 'taskEditModal')
  taskAction.value = _taskAction
}

// task APIS
async function handleTaskCreation(taskForm) {
  console.log('create', taskForm)
  await taskApi.createTask(taskForm)
}

async function handleTaskEdit(taskForm) {
  // only send 'title', 'description', 'due_date' for update reqbody
  const requestBody = ['title', 'description', 'due_date'].reduce((reqBody, key)=> {
    return {...reqBody, [key]: taskForm[key]}
  }, {})
  await taskApi.updateTask(requestBody)
}

async function getTaskByFilterAndPagination() {
  const taskListing = await taskApi.getTasksByFilterAndPagination(taskFilterForm.value)
  if(taskListing){
    tableData.value = taskListing
  }
}

async function handlePaginationChanged(pageDetails){
  // merge with pageDetails to get latest 'page' and 'page_size'
  taskFilterForm.value = {...taskFilterForm.value, ...pageDetails}
  await getTaskByFilterAndPagination()
}

// lifecycle
onMounted(async () => {
  const taskListing = await getTaskByFilterAndPagination()
  console.log(taskListing)
})
</script>

<template>
  <!--Action panel-->
  <n-card>
    <n-space horizontal>
      <n-button strong type="primary" :disabled="isLoading" @click="showEditModal('CREATE')">Create New Task</n-button>
      <n-button strong :disabled="isLoading" @click="showFilterModal()">Filter Tasks</n-button>
    </n-space>
  </n-card>

  <!--Table-->
  <task-listing-table :table-data="tableData" :edit-function="showEditModal" @pagination-changed="handlePaginationChanged"/>

  <!--Modals-->
  <task-edit-modal :task-action="taskAction" @task-CREATE="handleTaskCreation" @task-EDIT="handleTaskEdit" />
  <task-filter-modal />
</template>

<style scoped></style>
