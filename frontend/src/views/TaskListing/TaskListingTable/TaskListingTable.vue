<script>
import { NButton, NTag, useMessage, NDataTable } from "naive-ui";
import { defineComponent, ref, h } from 'vue'

export default defineComponent({
  name: 'TaskListingTable',
  components: {
    NDataTable,
    NButton
  },
  setup() {
    return {
      tableColumns: Object.freeze([
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
              'Due soon': 'warning',
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
                onClick: () => sendMail(row)
              },
              { default: () => "Send Email" }
            );
          }
        }
      ]),
      tableData: [
        {
          task_id: 0,
          title: "John Brown",
          description: "John Brown",
          status: "Overdue",
          created_date: "2024-11-29T08:42:29.505Z",
          due_date: "2024-11-29T08:42:29.505Z"
        },
        {
          task_id: 1,
          title: "John Brown",
          description: "John Hello",
          status: "Not Urgent",
          created_date: "2024-11-29T08:42:29.505Z",
          due_date: "2024-11-29T08:42:29.505Z"
        },
        {
          key: 2,
          title: "John Black",
          description: "John Hello",
          status: "Not Urgent",
          created_date: "2024-11-29T08:42:29.505Z",
          due_date: "2024-11-29T08:42:29.505Z"
        }
      ],
      pagination: {
        pageSize: 10
      }
    }
  },
});
</script>

<template>
  <n-data-table :single-line="false" :columns="tableColumns" :data="tableData" :pagination="pagination" />
</template>

<style scoped>
.read-the-docs {
  color: #888;
}
</style>
