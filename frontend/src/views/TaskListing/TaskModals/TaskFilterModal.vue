<script setup>
import { NModal, NInput, NSpace, NButton } from 'naive-ui';
import { useStore } from 'vuex';
import { computed, ref } from 'vue'

const store = useStore()
const emit = defineEmits()

const baseFilterForm = Object.freeze({
    title_search: '',
    page: 1,
    page_size: 10,
    order_by: '',
    order: 'desc'
})
const taskFilterForm = ref({})

const showModal = computed(() => store.getters.getModal('taskFilterModal'));
const handleModalClose = (value) => {
    store.commit('toggleModal', {modalName: 'taskFilterModal', show: value}); // Update Vuex store when the modal is closed
};

// Confirm and emit filter form data
function emitTaskSearchDetails() {
    emit(`task-SEARCH`, taskForm.value)
    resetForm()
    closeModal()
}
</script>

<template>
    <n-modal v-model:show="showModal" preset="dialog" title="Dialog"  @update:show="handleModalClose">
        <template #header>
            <span>Fitler and search tasks</span>
        </template>
        <n-space vertical :style="{ 'grid-row-gap': '1rem', 'padding-top': '1rem' }">
            <n-input v-model:value="taskFilterForm.title" type="text" placeholder="Task Title" />
        </n-space>
        <template #action>
            <n-space>
                <n-button type="primary" @click="emitTaskSearchDetails()">
                    Apply Filters
                </n-button>
                <n-button @click="closeModal()">
                    Cancel
                </n-button>
            </n-space>
        </template>
    </n-modal>
</template>
