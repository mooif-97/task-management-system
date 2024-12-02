<script setup>
import { NButton, NTag, NDataTable, NSpace, NPagination } from "naive-ui";
import { h, ref, watch, computed } from "vue";

const emit = defineEmits()

const props = defineProps({
  editFunction: {
    type: Function,
    required: true
  },
  tableData: {
    type: Array,
    required: true
  },
  pageDetails: {
    type: Object
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
    key: "created_at"
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
              props.editFunction('EDIT', row)
            }
          }
        },
        { default: () => "Edit" }
      );
    }
  }
]);

const totalItemCount = computed(() => props.pageDetails?.total ?? 0)
const currentPage = ref(1)
const pageSize = ref(10)

function emitPaginationChanged(data) {
  emit('pagination-changed', data)
}

watch([currentPage, pageSize], (newValues) => {
  // emit new page details for search tasks again
  emitPaginationChanged({ page: newValues[0], page_size: newValues[1] })
});
</script>

<template>
  <n-space vertical>
    <n-data-table :single-line="false" :columns="tableColumns" :data="tableData" />
    <n-space>
      <n-pagination v-model:page="currentPage" v-model:page-size="pageSize" :item-count="totalItemCount"
        :page-sizes="[5, 10, 20, 30, 40]" :disabled="$store.getters.isLoading" show-size-picker />
      <div>Total Item: {{ totalItemCount }}</div>
    </n-space>
  </n-space>
</template>

<style scoped></style>
