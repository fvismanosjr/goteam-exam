<template>
    <div class="bg-background relative flex min-h-svh flex-col">
        <AppHeader />
        <main class="flex flex-1 flex-col">
            <SidebarProvider class="min-h-auto">
                <TaskList />
                <slot />
            </SidebarProvider>
        </main>
    </div>
</template>