<script setup>
import { NButton, NCard, NSpace } from 'naive-ui';
import TaskListingTable from './TaskListingTable/TaskListingTable.vue';
import TaskEditModal from './TaskModals/TaskEditModal.vue';
import TaskFilterPanel from './TaskFilter/TaskFilterPanel.vue'
import { useStore } from 'vuex';
import { ref, computed, onMounted } from 'vue';
import taskApi from '../../api/task-api';

const store = useStore()

const isLoading = computed(() => store.getters.isLoading)

// task edit modal refs
const taskAction = ref('CREATE')
const selectedTask = ref({})

// task filter refs
const taskFilterForm = ref({})

// table refs
const tableData = ref([])
const pageDetails = ref({})

function showEditModal(_taskAction, _selectedTask = {}) {
  store.dispatch('showModal', 'taskEditModal')
  taskAction.value = _taskAction
  selectedTask.value = {
    ..._selectedTask, due_date: convertIsoToDate(_selectedTask?.due_date)
  }
  console.log('emit new formatted', selectedTask.value, _taskAction)
}

function convertIsoToDate(isoDate) {
  // do conversion into timestamp because naive-ui cannot accept iso date string
  return isoDate ? new Date(isoDate).getTime() : null
}

// task APIS
async function handleTaskCreation(taskForm) {
  const res = await taskApi.createTask(taskForm)
  if (res.status === 201) (
    // do a fetch after create/update
    getTaskByFilterAndPagination()
  )
}

async function handleTaskEdit(taskForm) {
  // only send 'title', 'description', 'due_date' for update reqbody
  const requestBody = ['title', 'description', 'due_date'].reduce((reqBody, key) => {
    return { ...reqBody, [key]: taskForm[key] }
  }, {})
  const taskId = selectedTask.value?.task_id;
  const res = await taskApi.updateTask(taskId, requestBody);
  if (res.status === 200) (
    // do a fetch after create/update
    getTaskByFilterAndPagination()
  )
}

async function getTaskByFilterAndPagination() {
    const res = await taskApi.getTasksByFilterAndPagination(taskFilterForm.value)
  // get success
  if (res.status === 200) {
    const { data, page_details } = res?.data ?? {}
    const description = `Query success. Returned ${page_details?.total ?? 0} items.`
    tableData.value = data
    pageDetails.value = page_details
    store.dispatch("triggerMessage", {
      description,
      actionType: "info",
    });
  }
}

async function handlePaginationChanged(pageDetails) {
  // merge with pageDetails to get latest 'page' and 'page_size'
  taskFilterForm.value = { ...taskFilterForm.value, ...pageDetails }
  await getTaskByFilterAndPagination()
}

async function handleApplyFilterEvent(searchFilterForm) {
  // merge with searchFilterForm emmited from filter panel by clicking 'Apply filter' button
  taskFilterForm.value = { ...taskFilterForm.value, ...searchFilterForm }
  await getTaskByFilterAndPagination()
}

// lifecycle
onMounted(() => {
  getTaskByFilterAndPagination()
})
</script>

<template>
  <!--Action panel-->
  <n-card>
    <n-space horizontal>
      <n-button strong type="primary" :disabled="isLoading" @click="showEditModal('CREATE')">Create New Task</n-button>
      <task-filter-panel @apply-search-filter="handleApplyFilterEvent" />
    </n-space>
  </n-card>

  <!--Table-->
  <!--When edit button is clicked, it will pass the selectedTask object into task-edit-modal as props, then populate the selectedTask values-->
  <task-listing-table :table-data="tableData" @edit-row="(e) => showEditModal('EDIT', e)" :page-details="pageDetails"
    @pagination-changed="handlePaginationChanged" />

  <!--Modals-->
  <task-edit-modal :task-action="taskAction" v-model:selected-task="selectedTask" @task-CREATE="handleTaskCreation"
    @task-EDIT="handleTaskEdit" />
</template>

<style scoped></style>