<template>
  <div class="relative min-h-[75vh]">
    <h1 class="font-bold text-2xl mb-8">Create Criteria</h1>
    <div v-if="notice" class="bg-green-100 rounded-lg py-8 px-10 mb-8">
      <p class="text-[#666666] text-xl mb-4 text-justify leading-10">
        To be accepted as a mentor or a mentor manager, an applicant must
        provide relevant information and documents regarding their past
        experience(s). The criteria setup lets you create input fields for these
        information.
      </p>
      <div class="flex justify-end">
        <SmallPrimaryBtn
          title="OK"
          class="px-6 py-1 text-lg font-semibold"
          @click="() => (notice = false)"
        />
      </div>
    </div>
    <div>
      <PrimaryBtn title="Add Criteria" :disabled="notice" />
    </div>
    <div></div>
    <div class="absolute bottom-0 right-0">
      <PrimaryBtn title="Create Criteria" :disabled="!criterias" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";

const notice = ref(true);
const criterias = ref(null);
</script>

<style scoped></style>
