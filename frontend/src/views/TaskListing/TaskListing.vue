<script setup>
import { NButton, NCard, NSpace } from 'naive-ui';
import TaskListingTable from './TaskListingTable/TaskListingTable.vue';
import TaskFilterModal from './TaskModals/TaskFilterModal.vue';
import TaskEditModal from './TaskModals/TaskEditModal.vue';
import TaskFilterPanel from './TaskFilter/TaskFilterPanel.vue'
import { useStore } from 'vuex';
import { ref, computed, onMounted } from 'vue';
import taskApi from '../../api/task-api';

const store = useStore()

const isLoading = computed(() => store.getters.isLoading)

const taskAction = ref('CREATE')
const taskFilterForm = ref({})
const tableData = ref([])
const pageDetails = ref({})

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
  const requestBody = ['title', 'description', 'due_date'].reduce((reqBody, key) => {
    return { ...reqBody, [key]: taskForm[key] }
  }, {})
  await taskApi.updateTask(requestBody)
}

async function getTaskByFilterAndPagination() {
  const res = await taskApi.getTasksByFilterAndPagination(taskFilterForm.value)
  // get success
  if (res.status === 200) {
    const { data, page_details } = res?.data ?? {}
    tableData.value = data
    pageDetails.value = page_details
  }
}

async function handlePaginationChanged(pageDetails) {
  // merge with pageDetails to get latest 'page' and 'page_size'
  taskFilterForm.value = { ...taskFilterForm.value, ...pageDetails }
  await getTaskByFilterAndPagination()
}

// lifecycle
onMounted(async () => {
  const taskListing = await getTaskByFilterAndPagination()
})
</script>

<template>
  <!--Action panel-->
  <n-card>
    <n-space horizontal>
      <n-button strong type="primary" :disabled="isLoading" @click="showEditModal('CREATE')">Create New Task</n-button>
      <task-filter-panel />
    </n-space>
  </n-card>

  <!--Table-->
  <task-listing-table :table-data="tableData" :edit-function="showEditModal" :page-details="pageDetails"
    @pagination-changed="handlePaginationChanged" />

  <!--Modals-->
  <task-edit-modal :task-action="taskAction" @task-CREATE="handleTaskCreation" @task-EDIT="handleTaskEdit" />
  <task-filter-modal />
</template>

<style scoped></style>
