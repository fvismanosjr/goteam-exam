<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { cn, getCookie } from "@/lib/utils"
import { useUserStore } from "~/stores/user";

const props = defineProps<{
    class?: HTMLAttributes["class"]
}>()

const loginForm = ref({
    email: "",
    password: "",
})

const login = async () => {
    const user = useUserStore();

    await fetch('http://localhost/sanctum/csrf-cookie', {
        method: "GET",
        credentials: "include",
    }).then(async () => {
        await fetch('http://localhost/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
            },
            body: JSON.stringify(loginForm.value),
            credentials: "include"
        }).then(async (response) => {
            return response.json();
        }).then((result) => {
            user.user = {
                ...result.user,
                avatar: "https://www.shadcn-vue.com/avatars/shadcn.jpg"
            };
            
            navigateTo("/task")
        });
    });
}
</script>

<template>
    <div :class="cn('flex flex-col gap-5', props.class)">
        <a href="#" class="flex items-center self-center">
            <div class="bg-primary text-primary-foreground flex size-12 items-center justify-center rounded-md">
                <LucideShell class="size-8" />
            </div>
        </a>
        <Card>
            <CardHeader>
                <CardTitle>Login to your account</CardTitle>
                <CardDescription>
                    Enter your email below to login to your account
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form>
                    <FieldGroup>
                        <Field>
                            <FieldLabel for="email">
                                Email
                            </FieldLabel>
                            <Input v-model="loginForm.email" id="email" type="email" placeholder="m@example.com"
                                required />
                        </Field>
                        <Field>
                            <div class="flex items-center">
                                <FieldLabel for="password">
                                    Password
                                </FieldLabel>
                                <a href="#" class="ml-auto inline-block text-sm underline-offset-4 hover:underline">
                                    Forgot your password?
                                </a>
                            </div>
                            <Input v-model="loginForm.password" id="password" type="password" required />
                        </Field>
                        <Field>
                            <Button type="submit" @click.prevent="login">
                                Login
                            </Button>
                        </Field>
                    </FieldGroup>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
