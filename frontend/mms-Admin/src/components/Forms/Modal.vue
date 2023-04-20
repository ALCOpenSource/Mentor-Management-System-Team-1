<template>
  <v-row justify="center">
    <v-dialog v-model="isModalOpen" width="600" persistent>
      <div class="flex bg-white py-6 rounded-xl gap-8 flex-col items-center">
        <h2 class="font-bold text-2xl">{{ title }}</h2>
        <v-card-text>
          <img v-if="src" :src="src" alt="img" />
          <p class="text-center text-lg px-16">{{ cardText }}</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <SecondaryBtn
            v-if="secondaryText"
            class="mr-6"
            :title="secondaryText"
            @click="toggleModal"
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

interface Props {
  title: string;
  isModalOpen: boolean;
  src?: string;
  cardText?: string;
  primaryText: string;
  secondaryText?: string;
  inputText?: string;
}

const props = defineProps<Props>();

const emit = defineEmits(["toggleModal"]);

const isModalOpen = ref(props.isModalOpen);

const toggleModal = () => {
  emit("toggleModal");
};

watch(
  () => props.isModalOpen,
  (val) => {
    isModalOpen.value = val;
  }
);
</script>

<style scoped></style>
