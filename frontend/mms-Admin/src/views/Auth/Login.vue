<template>
  <div class="mx-auto flex h-full w-3/5 flex-col justify-center">
    <div>
      <h1 class="mb-1">Welcome!</h1>
      <h3>Login to continue</h3>
    </div>
    <v-form v-model="valid" class="mt-14 mb-5" @submit.prevent="handleLogin">
      <Email @update:email="(value) => (loginData.email = value)" />
      <Password @update:password="(value) => (loginData.password = value)" />
      <PrimaryBtn
        title="Login"
        type="submit"
        class="mt-5"
        :full-width="true"
        :disabled="!loginData.email || !loginData.password"
      />
    </v-form>
    <router-link to="/reset-password"
      ><p class="flex justify-end font-semibold underline">
        Forgot Password?
      </p></router-link
    >
    <button @click="socialLoginRedirect" class="gBtn my-10">
      <img src="../../assets/images/google.png" alt="" />
      <span>Signin with Google</span>
    </button>
    <p class="text-center">New User? <span class="underline">Signup</span></p>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, computed, onMounted } from "vue";
import { useAuthStore } from "../../store/auth";
import { useRoute } from "vue-router";

import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import Email from "../../components/Forms/Email.vue";
import Password from "../../components/Forms/Password.vue";

const loginData = ref({
  email: "",
  password: "",
});

const valid = ref(false);
const isAdmin = ref(true);

const authStore = useAuthStore();

const handleLogin = async () => {
  if (valid.value && isAdmin.value) {
    await authStore.handleLogin(loginData.value);
  }
};

const socialLoginRedirect = async () => {
  await authStore.socialLoginRedirect();
};

const router = useRoute();

const handleSocialLogin = async () => {
  const access_token = router.query.access_token as string;
  if (access_token) {
    await authStore.handleSocialLogin(access_token);
  }
};

onMounted(() => {
  handleSocialLogin();
});
</script>

<style scoped lang="scss">
h1 {
  font-weight: 700;
  font-size: 32px;
}

h3 {
  font-weight: 400;
  font-size: 22px;
  color: var(--text-inactive);
}

p {
  cursor: pointer;

  &:hover {
    color: var(--btn-primary);
  }
}

.gBtn {
  border-radius: 10px;
  border: 1px solid var(--btn-primary);
  background-color: var(--btn-secondary);
  color: #023c40;
  color: #023c40;
  width: 100%;
  padding: 5px 40px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;

  &:hover {
    background-color: var(--btn-secondary-hover);
  }
}
</style>
