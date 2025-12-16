<script setup lang="ts">
import { getCookie, formatDate, isDateToday } from '~/lib/utils';
import type { TaskResponseType, TaskType } from '~/types/types';
import { useTaskStore } from '~/stores/task';

const taskStore = useTaskStore();
const showTasks = async () => {
    const response = await fetch('http://localhost/api/tasks', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        credentials: "include"
    })

    return await response.json();
}

const updateCurrentTask = (task: TaskType) => {
    task.active = true;
    taskStore.currentTask = task;
}

onMounted(() => {
    showTasks().then((result: TaskResponseType) => {
        taskStore.tasks = result.tasks.map((task) => {
            return {
                ...task,
                active: false,
                created_at: formatDate(task.created_at)
            }
        })
    });
})
</script>

<template>
    <Sidebar v-if="taskStore.tasks.length" class="h-[calc(100vh-60px)] top-15 sticky w-[18rem]" collapsible="none">
        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem v-for="task in taskStore.tasks" :key="task.id">
                            <SidebarMenuButton 
                                :class="{ 'bg-primary text-white hover:bg-primary hover:text-white' : task.active }"
                                @click.prevent="updateCurrentTask(task)"
                            >
                                {{ task.created_at }}
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>