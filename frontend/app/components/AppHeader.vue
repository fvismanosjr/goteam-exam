<script setup lang="ts">
import { getCookie } from '~/lib/utils';
import { useUserStore } from '~/stores/user';

const userStore = useUserStore();

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