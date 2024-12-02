<script setup>
import { NSpace, NDropdown, NButton, NCard, NInput, NCheckbox } from 'naive-ui'
import { useStore } from 'vuex';
import { ref, computed } from 'vue'

const store = useStore()
const emit = defineEmits()

const orderByOptions = [
    {
        label: 'None',
        key: ''
    },
    // {
    //     label: 'Task Title',
    //     key: 'title'
    // },
    // {
    //     label: 'Task Description',
    //     key: 'description'
    // },
    {
        label: 'Created Date',
        key: 'created_at'
    },
    {
        label: 'Due Date',
        key: 'due_date'
    }
]

const orderOptions = [
    {
        label: 'Ascending',
        key: 'asc'
    },
    {
        label: 'Descending',
        key: 'desc'
    }
]

const taskFilterForm = ref({
    order_by: 'created_at',
    order: 'descending',
    exact_title_search: false,
    title_search: ''
})

const isLoading = computed(() => store.getters.isLoading)

function handleSelect(formKey, value) {
    taskFilterForm.value[formKey] = value
}

function applyFilterAndEmitCriteria() {
    emit('apply-search-filter', taskFilterForm.value)
}
</script>

<template>
    <n-card size="small">
        <n-space>
            <!-- title search -->
            <n-space>
                <n-input v-model:value="taskFilterForm.title_search" type="text" size="small"
                    placeholder="Search By title" :disabled="isLoading" />
                <n-checkbox @click="taskFilterForm.exact_title_search = !taskFilterForm.exact_title_search"
                    :disabled="isLoading">
                    Exact match?
                </n-checkbox>
            </n-space>

            <!-- order by -->
            <n-space>
                <n-dropdown trigger="click" :options="orderByOptions" @select="(key) => handleSelect('order_by', key)">
                    <n-button size="tiny" :disabled="isLoading">Order By: {{ taskFilterForm.order_by }}</n-button>
                </n-dropdown>
                <n-dropdown trigger="click" :options="orderOptions" @select="(key) => handleSelect('order', key)">
                    <n-button size="tiny" :disabled="isLoading || !taskFilterForm.order_by">Order: {{
                        taskFilterForm.order
                    }}</n-button>
                </n-dropdown>
            </n-space>

            <n-space :style="{ 'padding-left': '2rem' }">
                <n-button type="primary" @click="applyFilterAndEmitCriteria" size="small" :disabled="isLoading"
                    round>Apply
                <n-button @click="applyFilterAndEmitCriteria" size="small" :disabled="isLoading" round>Apply
                    Filter</n-button>
            </n-space>
        </n-space>
    </n-card>
</template>