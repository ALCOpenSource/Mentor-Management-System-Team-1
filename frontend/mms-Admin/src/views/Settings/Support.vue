<template>
  <div class="mx-3 mt-10 mb-12">
    <h1 class="text-xl font-semibold mb-5">How can we help you?</h1>
    <v-form ref="form" v-model="valid" @submit.prevent="handleSubmit">
      <v-text-field
        v-model="supportDetails.name"
        :rules="[rules.required]"
        type="text"
        hint="Enter your name"
        variant="solo"
        placeholder="Name"
      ></v-text-field>
      <Email @update:email="(value) => (supportDetails.email = value)" />
      <v-text-field
        v-model="supportDetails.title"
        :rules="[rules.required]"
        type="text"
        hint="Enter your title"
        variant="solo"
        placeholder="Title"
      ></v-text-field>
      <textarea
        v-model="supportDetails.message"
        class="input"
        placeholder="Body"
        rows="5"
      ></textarea>
      <div class="flex justify-between items-center mt-8 mb-5">
        <Docs class="cursor-pointer"/>
        <div class="w-[115px]">
          <PrimaryBtn title="Send" type="submit" />
        </div>
      </div>
    </v-form>
  </div>
  <Modal
    title="Message Sent Successfully"
    :src="profileSuccess"
    :is-modal-open="isModalOpen"
    primary-text="Done"
    @toggle-modal="toggleModal"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";

import Email from "../../components/Forms/Email.vue";
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import Modal from "../../components/Forms/Modal.vue";
import { profileSuccess } from "../../assets/images";
import { Docs } from "@/assets/icons"
import {useSupportStore} from "../../store/support"

const supportStore = useSupportStore();

const supportDetails = ref({
  name: "",
  email: "",
  message: "",
  title: "",
});
const isModalOpen = ref(false);
const valid = ref(false);

const rules = {
  required: (value: string) => Boolean(value) || "Required.",
};

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleSubmit = async() => {
  if (valid.value) {
    // Handle the Form submission
  const response = await supportStore.createTicket(supportDetails);
  
  if (response && response.data && response.data.success) {
    toggleModal();
    // Handle the success here, toggle modal
    return;
  }
  }
};
</script>

<style scoped lang="scss">
.input {
  border: 1.6px solid var(--border);
  border-radius: 5px;
  padding: 10px 15px;
  width: 100%;
}

.input:focus {
  outline: 2px solid var(--btn-primary);
}

.input::placeholder {
  color: #b3b3b3;
  font-size: 18px;
  font-weight: 300;
}
</style>
