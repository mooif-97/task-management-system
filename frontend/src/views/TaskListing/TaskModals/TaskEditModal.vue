<script setup>
import { NModal, NInput, NSpace, NDatePicker, NButton } from 'naive-ui';
import { useStore } from 'vuex';
import { computed, defineProps, ref, defineEmits } from 'vue'

const props = defineProps({
    taskAction: {
        type: String,
        required: true
    }
})

const store = useStore()
const emit = defineEmits()

const baseForm = Object.freeze({
    title: '',
    description: '',
    due_date: null,
    created_by: store.getters.getUserId || 'unknown_user'
})
const taskForm = ref({ ...baseForm })

const showModal = computed(() => store.getters.getModal('taskEditModal'));
const modalTitle = computed(() => props.taskAction === 'CREATE' ? 'Create new task' : 'Edit current task')

function handleModalClose(value) {
    store.commit('toggleModal', { modalName: 'taskEditModal', show: false });
};

function closeModal() {
    store.dispatch('hideModal', 'taskEditModal')
}

function resetForm() {
    taskForm.value = { ...baseForm }
}

// Confirm and emit form data
function emitTaskEditDetails() {
    emit(`task-${props.taskAction}`, taskForm.value)
    resetForm()
    closeModal()
}
</script>

<template>
    <n-modal v-model:show="showModal" preset="dialog" title="Dialog" @update:show="handleModalClose()">
        <template #header>
            <span>{{ modalTitle }}</span>
        </template>
        <n-space vertical :style="{ 'grid-row-gap': '1rem', 'padding-top': '1rem' }">
            <n-input v-model:value="taskForm.title" type="text" placeholder="Task Title" />
            <n-input v-model:value="taskForm.description" type="textarea" placeholder="Task Description" />
            <n-date-picker v-model:value="taskForm.due_date" type="datetime" clearable />
        </n-space>
        <template #action>
            <n-space>
                <n-button type="primary" @click="emitTaskEditDetails()">
                    Confirm
                </n-button>
                <n-button @click="closeModal()">
                    Cancel
                </n-button>
            </n-space>
        </template>
    </n-modal>
</template>
