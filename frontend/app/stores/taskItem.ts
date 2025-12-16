import type { TaskItemType } from "~/types/types";

export const useTaskItemStore = defineStore("taskItems", () => {
    const taskItems = ref<TaskItemType[]>([]);

    const addItem = (payload: TaskItemType) => {
        taskItems.value.push(payload);
    }

    const updateItem = (payload: TaskItemType) => {
        taskItems.value = taskItems.value.map((item) => {
            return item.id == payload.id ? {
                ...item,
                description: payload.description,
                is_done: payload.is_done,
            } : item
        })
    }

    const removeItem = (id: number) => {
        taskItems.value = taskItems.value.filter((item: TaskItemType) => {
            return item.id != id;
        })
    }

    return {
        taskItems,
        addItem,
        updateItem,
        removeItem,
    }
}, {
    persist: false
})