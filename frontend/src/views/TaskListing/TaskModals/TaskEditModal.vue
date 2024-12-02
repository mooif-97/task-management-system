<script setup>
import { NModal, NInput, NSpace, NDatePicker, NButton } from 'naive-ui';
import { useStore } from 'vuex';
import { computed, defineProps, ref, defineEmits, watch } from 'vue'

const props = defineProps({
    taskAction: {
        type: String,
        required: true
    },
    selectedTask: {
        type: Object
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
const taskForm = ref({ ...baseForm, ...props.selectedTask })

const showModal = computed(() => store.getters.getModal('taskEditModal'));
const modalTitle = computed(() => props.taskAction === 'CREATE' ? 'Create new task' : 'Edit existing task')
const formInvalid = computed(() => !taskForm.value?.title || !taskForm.value.description)

watch(() => props.selectedTask, (newVal) => {
    // patch edit task form when edit button is clicked
    populateFormValues(newVal);
}, { deep: true });


function closeModal() {
    store.dispatch('hideModal', 'taskEditModal')
}

function resetForm() {
    populateFormValues(baseForm)
}

function populateFormValues(selectedTaskForm) {
    taskForm.value = { ...selectedTaskForm }
}

// Confirm and emit form data
function emitTaskEditDetails() {
    emit(`task-${props.taskAction}`, taskForm.value)
    resetForm()
    closeModal()
}
</script>

<template>
    <n-modal v-model:show="showModal" preset="dialog" title="Dialog" @update:show="closeModal()">
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
                <n-button type="primary" @click="emitTaskEditDetails()" :disabled="formInvalid">
                    Confirm
                </n-button>
                <n-button @click="closeModal()">
                    Cancel
                </n-button>
            </n-space>
        </template>
    </n-modal>
</template>
