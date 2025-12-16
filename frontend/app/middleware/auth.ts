import { useUserStore } from "~/stores/user"

export default defineNuxtRouteMiddleware(() => {
    const user = useUserStore()

    if (!user.user.id) {
        return navigateTo('/login');
    }
})