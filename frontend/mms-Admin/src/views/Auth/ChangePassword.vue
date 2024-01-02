<script lang="ts" setup>
import { ref } from "vue";

import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import Password from "../../components/Forms/Password.vue";
import Modal from "../../components/Forms/Modal.vue";
import { profileSuccess } from "../../assets/images";

const password = ref("");
const isModalOpen = ref(false);

const onPasswordChange = () => {
  // handle on password change
};

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};
</script>

<template>
  <div class="w-3/5 mx-auto flex flex-col justify-center h-full">
    <div>
      <h1 class="mb-1 font-semibold text-2xl 2xl:text-3xl 2xl:font-bold">
        Set new password
      </h1>
      <h3 class="font-normal text-xl 2xl:text-[22px]">
        Put in the email attached to this account
      </h3>
    </div>
    <form class="mt-14 mb-5" @submit.prevent="onPasswordChange">
      <Password
        placeholder="Email"
        @update:password="(value: string) => (password = value)"
      />
      <PrimaryBtn
        :disabled="!password.length"
        title="Reset Password"
        class="mt-5"
        :full-width="true"
        type="submit"
        @click="toggleModal"
      />
    </form>
    <router-link :to="{ name: 'login' }">
      <p class="flex justify-end font-semibold underline">
        Remember Password? Login
      </p>
    </router-link>
  </div>
  <Modal
    title="Password Changed Successfully"
    :src="profileSuccess"
    :is-modal-open="isModalOpen"
    primary-text="Done"
    @toggle-modal="toggleModal"
  />
</template>

<style scoped lang="scss">
h3 {
  color: var(--text-inactive);
}

p {
  cursor: pointer;

  &:hover {
    color: var(--btn-primary);
  }
}
</style>
