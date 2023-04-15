<template>
  <div class="overflow-hidden">
    <div class="flex justify-between items-center relative">
      <h1 class="text-2xl text-left font-bold mt-[1rem] mb-4">Dashboard</h1>
      <Dropdown :options="filterOptions" />
    </div>
    <HeadGrid />
    <Program />
    <Report />
    <Tasks />
  </div>
</template>

<script setup lang="ts">
import Program from "../../components/Dashboard/ProgramGrid/Program.vue";
import HeadGrid from "../../components/Dashboard/HeaderGrid/HeadGrid.vue";
import Report from "../../components/Dashboard/ReportGrid/Report.vue";
import Tasks from "../../components/Dashboard/Tasks/Tasks.vue";
import Dropdown from "../../components/Dropdowns/Dropdown.vue";

const filterOptions = [
  { text: "Tomorrow", urlParam: "tomorrow" },
  { text: "Today", urlParam: "today" },
  { text: "Past Week", urlParam: "past_week" },
];
</script>

<style scoped></style>
