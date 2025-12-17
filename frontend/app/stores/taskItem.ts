import type { TaskItemType } from "~/types/types";

export const useTaskItemStore = defineStore("taskItems", () => {
    const taskItems = ref<TaskItemType[]>([]);

    const searchString = ref("");

    const filteredItems = computed(() => {
        const query = searchString.value.toLowerCase().trim();

        if (!query) return taskItems.value;

        return taskItems.value.filter(item =>
            item.description.toLowerCase().includes(query)
        );
    });

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

    const reOrderItems = (newOrder: TaskItemType[]) => {
        taskItems.value = newOrder
    }

    return {
        taskItems,
        searchString,
        filteredItems,
        addItem,
        updateItem,
        removeItem,
        reOrderItems,
    }
}, {
    persist: false
})