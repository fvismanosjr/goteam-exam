import type { TaskType } from "~/types/types";

export const useTaskStore = defineStore("tasks", () => {
    const currentTask = ref<TaskType>({
        id: 0,
        user_id: 0,
        created_at: "",
        updated_at: "",
        deleted_at: "",
        active: false,
    });

    const tasks = ref<TaskType[]>([]);

    const addItem = (payload: TaskType) => {
        tasks.value.unshift(payload);
    }

    return {
        tasks,
        addItem,
        currentTask,
    }
}, {
    persist: false
})