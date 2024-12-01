<script setup>
import { NButton, NTag, NDataTable, NSpace, NPagination } from "naive-ui";
import { h, ref, watch } from "vue";

const emit = defineEmits()

const props = defineProps({
  editFunction: {
    type: Function,
    required: true
  },
  tableData: {
    type: Array,
    required: true
  }
})

const tableColumns = Object.freeze([
  {
    title: "Task Title",
    key: "title"
  },
  {
    title: "Task Description",
    key: "description"
  },
  {
    title: "Created Date",
    key: "created_date"
  },
  {
    title: "Due Date",
    key: "due_date"
  },
  {
    title: "Status",
    key: "status",
    render(row) {
      const statusColorMap = {
        'Not Urgent': 'success',
        'Due Soon': 'warning',
        'Overdue': 'error',
        'default': 'info'
      }
      return h(
        NTag,
        {
          style: {
            marginRight: '6px'
          },
          type: statusColorMap[row?.status ?? 'default'],
          bordered: true,
          round: true
        },
        {
          default: () => row?.status
        }
      );
    }
  },
  {
    title: "Action",
    key: "actions",
    render(row) {
      return h(
        NButton,
        {
          size: "small",
          onClick: () => {
            if (props.editFunction) {
              props.editFunction('EDIT')
            }
          }
        },
        { default: () => "Edit" }
      );
    }
  }
]);

const totalItemCount = ref(190)
const currentPage = ref(1)
const pageSize = ref(10)

function emitPaginationChanged(data){
  emit('pagination-changed', data)
}

watch([currentPage, pageSize], (newValues) => {
  console.log('Page changed to:', newValues);
  // emit new page details for search tasks again
  emitPaginationChanged({page: newValues[0], page_size: newValues[1]})
});

// const tableData = [
//   {
//     task_id: 0,
//     title: "John Brown",
//     description: "John Brown",
//     status: "Overdue",
//     created_date: "2024-11-29T08:42:29.505Z",
//     due_date: "2024-11-29T08:42:29.505Z"
//   },
//   {
//     task_id: 1,
//     title: "John Brown",
//     description: "John Hello",
//     status: "Not Urgent",
//     created_date: "2024-11-29T08:42:29.505Z",
//     due_date: "2024-11-29T08:42:29.505Z"
//   },
//   {
//     key: 2,
//     title: "John Black",
//     description: "John Hello",
//     status: "Due Soon",
//     created_date: "2024-11-29T08:42:29.505Z",
//     due_date: "2024-11-29T08:42:29.505Z"
//   }
// ]
</script>

<template>
  <n-space vertical>
    <n-data-table :single-line="false" :columns="tableColumns" :data="tableData" />
    <n-space>
      <n-pagination v-model:page="currentPage" v-model:page-size="pageSize" :item-count="totalItemCount"
        :page-sizes="[10, 20, 30, 40]" :disabled="$store.getters.isLoading" show-size-picker />
      <div>Total Item: {{ totalItemCount }}</div>
    </n-space>
  </n-space>
</template>

<style scoped></style>
