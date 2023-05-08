<template>
  <div class="programs">
    <div class="archive-card">
      <div class="mb-3" v-for="n in 10" :key="n">
        <CertDropdown :tabData="tabData" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import CertDropdown from "./CertDropdown.vue";
import { Task } from "@/assets/icons";

const tabData = {
  category: "Tasks",
  title: "GADS CLOUD 2022 - COMPLETION",
  date: "3 days from now",
  mainIcon: Task,
  content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id nibh nibh, at maximus ante fermentum sit amet. Pellentesque",
  numberOfReports: 18,
  isProgram: false
}
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
