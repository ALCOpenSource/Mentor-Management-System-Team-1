<template>
  <div class="flex gap-7">
    <div class="flex flex-col w-[309px] gap-5 mt-3">
      <div class="flex justify-between items-center">
        <h1 class="font-semibold text-xl 2xl:text-2xl">Programs</h1>
        <div class="flex items-center gap-5">
          <IconSearch color="#058B94" size="20" class="cursor-pointer" />
          <Filter class="cursor-pointer" />
        </div>
      </div>
      <div class="mentor-cards scrollbar">
        <ProgramCard
          v-for="(item, index) in 10"
          :key="item"
          :on-click="() => goToProgram(index, index)"
          :is-selected="selectedProgram === index"
          title="Google Africa Scholarship Program"
          date="Oct 10, 2021"
          time="10:00am"
          :days-due="2"
        />
      </div>
    </div>
    <div
      v-if="selectedProgram === null"
      class="w-full h-[78vh] flex flex-col justify-center items-center border rounded-md"
    >
      <NoPrograms />
      <h1 class="text-base 2xl:text-lg my-2">No item selected yet</h1>
      <p class="text-[#808080] text-sm 2xl:text-base">
        Select an item from the list to view program details
      </p>
    </div>
    <div v-else class="w-full">
      <div class="flex justify-end mb-4">
        <router-link :to="{ name: 'new-program' }">
          <PrimaryBtn title="Create New Program" />
        </router-link>
      </div>
      <div
        class="w-full h-[70vh] border rounded-md overflow-y-scroll scrollbar"
      >
        <ProgramDetails :id="programId" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { IconSearch, Filter, NoPrograms } from "@/assets/icons";
import { ProgramCard, ProgramDetails } from "@/components/Programs";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";

const router = useRouter();
const route = useRoute();

const selectedProgram = ref<Number | null>(null);
const programId = ref<Number>(0);

// index is the id of the program, when id is available from the backend, use it instead
const goToProgram = (index: Number, id: Number) => {
  selectedProgram.value = index;
  programId.value = id;
  router.push({ name: "program", params: { id: `${index}` } });

  // use the index/id to fetch the program details from the backend
};

watch(
  () => route.params.id,
  (id) => {
    if (id === "all") {
      selectedProgram.value = null;
    } else {
      selectedProgram.value = Number(id);
    }
  }
);

onMounted(() => {
  if (route.params.id === "all") {
    selectedProgram.value = null;
  } else {
    selectedProgram.value = Number(route.params.id);
  }
});
</script>

<style scoped lang="scss">
.mentor-cards {
  min-width: 317px;
  height: 70vh;
  overflow-y: scroll;
  overflow-x: hidden;
  padding-right: 5px;
}
</style>
