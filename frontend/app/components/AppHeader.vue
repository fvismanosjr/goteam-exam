<script setup lang="ts">
import { getCookie } from '~/lib/utils';
import { useUserStore } from '~/stores/user';
import { useTaskItemStore } from '~/stores/taskItem';

const userStore = useUserStore();
const taskItemStore = useTaskItemStore();

const logout = async () => {
    await fetch('http://localhost/logout', {
        method: 'POST',
        credentials: "include"
    });

    userStore.destroy();

    navigateTo("/login");
}
</script>

<template>
    <header class="bg-white flex z-50 h-15 items-center justify-between border-b px-3 sticky top-0">
        <div class="">
            <LucideShell class="size-8" />
        </div>
        <div class="w-1/4">
            <InputGroup>
                <InputGroupInput placeholder="Search..." v-model="taskItemStore.searchString"/>
                <InputGroupAddon>
                    <LucideSearch />
                </InputGroupAddon>
                <InputGroupAddon align="inline-end">
                    12 results
                </InputGroupAddon>
            </InputGroup>
        </div>
        
        <div class="relative">
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button size="icon" variant="ghost">
                        <Avatar>
                            <AvatarImage :src="userStore.user.avatar" :alt="userStore.user.name" />
                        </Avatar>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuLabel>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ userStore.user.name }}</span>
                            <span class="truncate text-xs">{{ userStore.user.email }}</span>
                        </div>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem @click.prevent="logout">
                        <LucideLogOut/>
                        Logout
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    </header>
</template>