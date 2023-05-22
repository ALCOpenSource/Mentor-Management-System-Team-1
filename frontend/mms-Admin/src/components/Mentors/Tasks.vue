<template>
  <div class="programs">
    <div class="flex justify-between items-center mb-3">
      <div>
        <PlainDropdown :options="options" title="All Tasks" />
      </div>
      <SearchBox placeholder="Search for Tasks" />
    </div>
    <div class="archive-card">
      <div class="mb-3" v-for="n in 10" :key="n">
        <ProgramDropdown :tabData="tabData" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import SearchBox from "../Common/SearchBox.vue";
import PlainDropdown from "../Common/PlainDropdown.vue";
import ProgramDropdown from "./ProgramDropdown.vue";
import { Task } from "@/assets/icons";

const options = [
  { text: "This Week" },
  { text: "This Month" },
  { text: "This Year" },
];

const tabData = {
  category: "Tasks",
  title: "Room liberary article write...",
  date: "3 days from now",
  mainIcon: Task,
  content:
    "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id nibh nibh, at maximus ante fermentum sit amet. Pellentesque",
  numberOfReports: 18,
  isProgram: false,
};
</script>

<style scoped lang="scss">
.archive-card {
  height: 56vh;
  overflow-y: scroll;
  padding-right: 0.5rem;
  padding-bottom: 3rem;

  &::-webkit-scrollbar {
    width: 5px;
    transition: all 0.5s ease-in-out;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: #06b9c6;
    border-radius: 50px;
  }
}
</style>
