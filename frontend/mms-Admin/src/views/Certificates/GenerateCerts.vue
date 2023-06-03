<template>
  <div class="flex justify-between gap-5">
    <div class="w-full transition-all">
      <h1 class="text-xl 2xl:text-2xl font-semibold mb-10">
        Generate Certificate
      </h1>
      <div class="transition-all">
        <div class="gen-card mb-7">
          <div
            v-if="!addedRef"
            class="w-full flex items-center justify-between mx-10 py-2"
          >
            <h2 class="text-xl 2xl:text-2xl">Select a Beneficiary</h2>
            <SmallPrimaryBtn title="Select" @click="showList('mentors')" />
          </div>
          <Beneficiary v-else :on-click="undoAdd" />
        </div>
        <div class="gen-card mb-7">
          <div
            v-if="!programRef"
            class="w-full flex items-center justify-between mx-10 py-2"
          >
            <h2 class="text-xl 2xl:text-2xl">Select a Program</h2>
            <SmallPrimaryBtn title="Select" @click="showList('programs')" />
          </div>
          <SelectedProgram v-else :on-click="undoProgram" />
        </div>
        <div class="gen-card mb-10">
          <div
            class="w-full h-[400px] flex items-center justify-center mx-10 py-2"
          >
            <p v-if="!showPreview" class="text-2xl text-[#cccccc]">
              Certificate Preview
            </p>
            <div v-else class="w-full h-full flex items-center justify-center">
              <img
                :src="largeCertificate"
                class="w-3/4 h-[380px]"
                alt=""
                srcset=""
              />
            </div>
          </div>
        </div>
        <div class="mb-5">
          <PrimaryBtn title="Generate" />
        </div>
      </div>
    </div>
    <div v-if="isList" class="max-w-[450px] min-w-[330px] transition-all">
      <div class="flex justify-between items-center gap-5 mb-5">
        <div class="relative w-full">
          <span class="search_icon absolute top-[10px] left-4">
            <IconSearch color="#058b94" />
          </span>
          <input
            class="bg-[#F7FEFF] p-4 py-2 pl-14 rounded-md w-full focus:outline-[#058b94] placeholder:text-[14px]"
            type="text"
            placeholder="Search for beneficiary..."
          />
        </div>
        <Close class="cursor-pointer" @click="hideList" />
      </div>
      <div v-if="toShow === 'mentors'">
        <MentorItem
          v-for="(item, index) in 15"
          :key="item"
          is-mentor-manager
          :added="addedRef === index"
          :on-click="() => setAdded(index)"
        />
      </div>
      <div v-if="toShow === 'programs'">
        <ProgramCard
          v-for="(item, index) in 15"
          :key="item"
          :added="programRef === index"
          :on-click="() => setProgram(index)"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import { Close, IconSearch } from "@/assets/icons";
import MentorItem from "@/components/Programs/MentorItem.vue";
import ProgramCard from "@/components/Certificates/ProgramCard.vue";
import Beneficiary from "@/components/Certificates/Beneficiary.vue";
import SelectedProgram from "@/components/Certificates/SelectedProgram.vue";
import { largeCertificate } from "@/assets/images";

const isList = ref(false);
const addedRef = ref<number>();
const programRef = ref<number>();
const toShow = ref("mentors");
const showPreview = ref(false);

const setAdded = (index: number) => {
  addedRef.value = index;
};
const setProgram = (index: number) => {
  programRef.value = index;
};
const setPreview = () => {
  if (addedRef.value !== undefined && programRef.value !== undefined) {
    showPreview.value = true;
  } else {
    showPreview.value = false;
  }
};

watch([addedRef, programRef], () => {
  setPreview();
});

const showList = (val: string) => {
  isList.value = true;
  toShow.value = val;
};

const hideList = () => {
  isList.value = false;
};

const undoAdd = () => {
  addedRef.value = undefined;
};
const undoProgram = () => {
  programRef.value = undefined;
};

// get the list of beneficiaries from the backend and when selected, get the user details with the addedRef value
// also get the list of programs from the backend and when selected, get the program details with the addedRef value
</script>

<style scoped lang="scss">
.gen-card {
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
