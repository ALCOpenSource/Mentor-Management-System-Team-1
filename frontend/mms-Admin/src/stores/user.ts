import { ref, computed } from "vue";
import { defineStore } from "pinia";

interface User {
  id: number;
  name: string;
  email: string;
  password: string;
  isAdmin: boolean;
}

export const useUserStore = defineStore("user", () => {
  const user = ref<User | null>(null);
  const userIsAdmin = computed(() => user.value?.isAdmin);
  function setUser(newUser: User) {
    user.value = newUser;
  }

  return { user, userIsAdmin, setUser };
});
