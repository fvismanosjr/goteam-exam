<script setup lang="ts">
import { useTaskStore } from '~/stores/task';

definePageMeta({
    layout: "default",
    middleware: "auth"
})

useHead({
    title: "Dashboard"
})

const taskStore = useTaskStore();
const taskItemListKey = ref(0);
const taskId = ref(0);

const showTaskList = (val: number) => {
    taskId.value = val;
    taskItemListKey.value++;
}

watch(() => taskStore.currentTask, (newvalue, oldvalue) => {

    if (oldvalue) {
        oldvalue.active = false;
    }

    taskItemListKey.value++;
})
</script>

<template>
    <TaskItemList :id="taskStore.currentTask?.id" :key="taskItemListKey"/>
</template>