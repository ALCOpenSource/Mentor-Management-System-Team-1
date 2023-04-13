<template>
  <div class="mt-3">
    <v-form v-model="valid" @submit.prevent="handleSubmit">
      <v-row no-gutters class="mb-2">
        <v-col cols="4"
          ><h1 class="font-semibold pt-4">Current Password</h1></v-col
        >
        <v-col cols="8" class="pr-8">
          <v-text-field
            v-model="currentpassword"
            :rules="[rules.required, rules.min]"
            type="password"
            hint="At least 8 characters"
            variant="solo"
            placeholder="Your current password"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row no-gutters class="mb-2">
        <v-col cols="4"><h1 class="font-semibold pt-4">New Password</h1></v-col>
        <v-col cols="8" class="pr-8">
          <v-text-field
            v-model="password"
            :rules="[rules.required, rules.min]"
            type="password"
            hint="At least 8 characters"
            variant="solo"
            placeholder="Must be at least 8 characters"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row no-gutters class="mb-2">
        <v-col cols="4"
          ><h1 class="font-semibold pt-4">Confirm New Password</h1></v-col
        >
        <v-col cols="8" class="pr-8">
          <v-text-field
            v-model="newPassword"
            :rules="[rules.required, rules.min, rules.confirm]"
            type="password"
            hint="At least 8 characters"
            variant="solo"
            placeholder="Must match your new password"
          ></v-text-field>
        </v-col>
      </v-row>
      <div class="w-[215px] mb-10 ml-auto mr-8">
        <PrimaryBtn title="Save new Password" type="submit" />
      </div>
    </v-form>
    <div class="mb-5">
      <router-link to="/reset-password"
        ><p
          class="text-center text-[#023C40] underline decoration-[#058b94] hover:scale-105 transition-all"
        >
          Forgot Password?
        </p></router-link
      >
    </div>
  </div>
  <Modal
    title="Password Changed Successfully"
    :src="profileSuccess"
    :is-modal-open="isModalOpen"
    primary-text="Done"
    @toggle-modal="toggleModal"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";

import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import Modal from "../../components/Forms/Modal.vue";
import { profileSuccess } from "../../assets/images";

const valid = ref(false);
const currentpassword = ref("");
const password = ref("");
const newPassword = ref("");
const isModalOpen = ref(false);

const rules = {
  required: (value: string) => Boolean(value) || "Required.",
  min: (value: string) => value.length >= 8 || "Min 8 characters",
  confirm: (value: string) =>
    value === password.value || "Passwords must match",
};

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleSubmit = () => {
  if (valid.value) {
    toggleModal();
    // Do something
  }
};
</script>

<style scoped lang="scss"></style>
