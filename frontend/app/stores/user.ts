import type { UserType } from "~/types/types";

export const useUserStore = defineStore("user", {
    state: () => {
        const user = ref<UserType>({
            id: 0,
            name: "",
            email: "",
            avatar: "https://www.shadcn-vue.com/avatars/shadcn.jpg",
        });

        return { user }
    },
    actions: {
        destroy() {
            this.user.id = 0;
            this.user.name = "";
            this.user.email = "";
        }
    },
    persist: {
        storage: piniaPluginPersistedstate.cookies(),
    },
})