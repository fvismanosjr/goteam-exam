<script setup lang="ts">
import { getCookie, formatDate, isDateToday } from '~/lib/utils';
import { useUserStore } from '~/stores/user';
import { useTaskStore } from '~/stores/task';
import { useTaskItemStore } from '~/stores/taskItem';
import type { TaskItemResponseType, TaskItemType } from '~/types/types';

const props = defineProps<{
    id: number,
}>()

const taskStore = useTaskStore();
const taskItemStore = useTaskItemStore();
const user = useUserStore();
const taskOrItemForm = ref({
    user_id: user.user.id,
    task_id: props.id,
    task_item_id: 0,
    description: ""
})

if (props.id) {
    const showTaskItems = async () => {
        const response = await fetch(`http://localhost/api/tasks/${props.id}/items`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
            },
            credentials: "include"
        })

        return await response.json();
    }

    showTaskItems().then((result: TaskItemResponseType) => {
        taskItemStore.taskItems = result.taskItems;
    })
}

const clear = () => {
    taskOrItemForm.value = {
        user_id: user.user.id,
        task_id: props.id,
        task_item_id: 0,
        description: ""
    }
}

const createTask = async () => {
    const response = await fetch('http://localhost/api/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        body: JSON.stringify(taskOrItemForm.value),
        credentials: "include"
    })

    const result = await response.json();

    taskStore.addItem(
        {
            ...result,
            active: isDateToday(result.created_at),
            created_at: formatDate(result.created_at)
        }
    );
}

const createTaskItem = async () => {
    const response = await fetch(`http://localhost/api/tasks/${props.id}/items`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        body: JSON.stringify(taskOrItemForm.value),
        credentials: "include"
    })

    const result = await response.json();
    taskItemStore.addItem(result);
}

const updateTaskItem = async () => {
    const response = await fetch(`http://localhost/api/tasks/${props.id}/items/${taskOrItemForm.value.task_item_id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        body: JSON.stringify(taskOrItemForm.value),
        credentials: "include"
    })

    const result = await response.json();
    taskItemStore.updateItem(result);
}

const createTaskOrTaskItem = async () => {
    if (props.id) {

        if (taskOrItemForm.value.task_item_id) {
            await updateTaskItem();
        } else {
            // create task item
            await createTaskItem();
        }
        
    } else {
        // create task
        await createTask();
    }

    clear();
}

const deleteTaskItem = async (taskItemId: number) => {
    await fetch(`http://localhost/api/tasks/${props.id}/items/${taskItemId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        credentials: "include",
    })

    taskItemStore.removeItem(taskItemId);

    clear();
}

const updateTaskOrItemForm = async (taskItem: TaskItemType) => {
    taskOrItemForm.value.description = taskItem.description;
    taskOrItemForm.value.task_item_id = taskItem.id;
}

const completeTaskItem = async (val: string | boolean, taskItem: TaskItemType) => {
    const response = await fetch(`http://localhost/api/tasks/${props.id}/items/${taskItem.id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        body: JSON.stringify({
            task_id: props.id,
            description: taskItem.description,
            is_done: val ? 1 : 0
        }),
        credentials: "include"
    })

    const result = await response.json();
    taskItemStore.updateItem(result);
}

const toBoolean = (num: number) => {
    return Boolean(num);
}
</script>

<template>
    <div class="h-full w-full p-4 min-h-[calc(100vh-60px)] flex flex-col relative"
        :class="[(props.id && taskItemStore.taskItems.length) ? 'justify-start' : 'justify-center']">
        <div v-if="props.id" class="flex flex-col items-stretch gap-3 pb-17.5">
            <template v-for="item in taskItemStore.taskItems">
                <Label class="group relative flex items-center gap-3 rounded-lg border px-4 py-2 hover:bg-accent/50">
                    <!-- Checkbox -->
                    <Checkbox class="data-[state=checked]:text-white" :model-value="toBoolean(item.is_done)" @update:model-value="(value) => completeTaskItem(value, item)"/>

                    <!-- Text -->
                    <p class="text-sm leading-none font-normal">{{ item.description }}</p>

                    <div class="ml-auto flex">
                        <Button 
                            variant="ghost" 
                            size="icon" 
                            class="opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                            @click.prevent="updateTaskOrItemForm(item)"
                        >
                            <LucidePencil />
                        </Button>
                        <Button 
                            variant="ghost" 
                            size="icon" 
                            class="ml-auto opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                            @click.prevent="deleteTaskItem(item.id)"
                        >
                            <LucideTrash2 />
                        </Button>
                    </div>
                </Label>
            </template>
        </div>

        <div :class="[(props.id && taskItemStore.taskItems.length) ? 'fixed bottom-2 w-[calc(100%-17rem)]' : '-mt-15']">
            <p v-if="!props.id || !taskItemStore.taskItems.length" class="text-2xl font-medium mb-4 text-center">What’s on your mind today?</p>
            <InputGroup>
                <InputGroupTextarea v-model="taskOrItemForm.description" class="bg-white rounded-md" placeholder="Ask, Search or Chat..." />
                <InputGroupAddon align="inline-end" class="bg-white rounded-b-md mr-0!">
                    <InputGroupButton variant="default" class="rounded-full ml-auto" size="icon-sm" @click.prevent="createTaskOrTaskItem">
                        <LucideArrowUp class="size-5" />
                    </InputGroupButton>
                </InputGroupAddon>
            </InputGroup>
        </div>
    </div>
</template>