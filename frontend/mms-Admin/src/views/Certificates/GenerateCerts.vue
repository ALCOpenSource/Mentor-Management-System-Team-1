<template>
  <div class="flex justify-between gap-5">
    <div class="w-full transition-all">
      <h1 class="text-2xl font-semibold mb-10">Generate Certificate</h1>
      <div class="transition-all">
        <div class="card mb-7">
          <div class="w-full flex items-center justify-between mx-10 py-2">
            <h2 class="text-2xl">Select a Beneficiary</h2>
            <SmallPrimaryBtn title="Select" @click="showList" />
          </div>
        </div>
        <div class="card mb-7">
          <div class="w-full flex items-center justify-between mx-10 py-2">
            <h2 class="text-2xl">Select a Program</h2>
            <SmallPrimaryBtn title="Select" @click="showList" />
          </div>
        </div>
        <div class="card mb-10">
          <div
            class="w-full h-[400px] flex items-center justify-center mx-10 py-2"
          >
            <p class="text-2xl text-[#cccccc]">Certificate Preview</p>
          </div>
        </div>
        <div class="mb-5">
          <PrimaryBtn title="Generate" />
        </div>
      </div>
    </div>
    <div v-if="isList" class="max-w-[450px] min-w-[330px] transition-all">
      <div class="flex justify-between items-center">
        <p>sjsjs</p>
        <Close class="cursor-pointer" @click="hideList" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import { Close } from "@/assets/icons";

const isList = ref(false);

const showList = () => {
  isList.value = true;
};

const hideList = () => {
  isList.value = false;
};
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8rem;
  padding: 10px 40px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;

  &:hover {
    background-color: var(--light-grid-background);
  }
}
</style>
