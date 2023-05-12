<template>
  <v-row justify="center">
    <v-dialog v-model="isModalOpen" width="600" persistent>
      <div class="flex bg-white py-6 rounded-xl gap-8 flex-col items-center">
        <h2 class="font-bold text-2xl">{{ title }}</h2>
        <v-card-text>
          <img v-if="src" :src="src" alt="img" />
          <p class="text-center text-lg px-16">{{ cardText }}</p>
          <div v-if="email" class="min-w-[450px]">
            <Email @update:email="(value) => (emailData = value)" @vnode-updated="$emit('update:email', emailData)"/>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <SecondaryBtn
            v-if="secondaryText"
            class="mr-6"
            :title="secondaryText"
            @click="closeModal"
          />
          <PrimaryBtn :title="primaryText" @click="toggleModal" />
        </v-card-actions>
      </div>
    </v-dialog>
  </v-row>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";

import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import SecondaryBtn from "../Buttons/SecondaryBtn.vue";
import Email from "./Email.vue";

interface Props {
  title: string;
  isModalOpen: boolean;
  src?: string;
  cardText?: string;
  primaryText: string;
  secondaryText?: string;
  inputText?: string;
  email?: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits(["toggleModal", "update:email", "closeModal"]);

const isModalOpen = ref(props.isModalOpen);
const emailData = ref('');

const toggleModal = () => {
  emit("toggleModal");
  emit("update:email", emailData.value);
};

const closeModal = () => {
  emit("closeModal");
}

watch(
  () => props.isModalOpen,
  (val) => {
    isModalOpen.value = val;
  }
);
</script>

<style scoped></style>
