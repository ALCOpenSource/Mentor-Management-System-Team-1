<template>
  <div class="mx-auto flex h-full w-3/5 flex-col justify-center">
    <div>
      <h1 class="mb-1">Welcome!</h1>
      <h3>Login to continue</h3>
    </div>
    <form class="mt-14 mb-5">
      <Email @update:email="(value) => (loginData.email = value)" />
      <Password @update:password="(value) => (loginData.password = value)" />
      <PrimaryBtn title="Login" type="submit" class="mt-5" />
    </form>
    <p class="flex justify-end font-semibold underline">Forgot Password?</p>
    <button class="gBtn my-10">
      <img src="../../assets/images/google.png" alt="" />
      <span>Signin with Google</span>
    </button>
    <p class="text-center">New User? <span class="underline">Signup</span></p>
  </div>
</template>

<script setup lang="ts">
import {ref} from "vue";

import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import Email from "../../components/Forms/Email.vue";
import Password from "../../components/Forms/Password.vue";

const loginData = ref({
  email: "",
  password: "",
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
