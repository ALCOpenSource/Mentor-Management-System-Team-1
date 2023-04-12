<template>
  <div>
    <h1 class="text-2xl text-center font-semibold my-[4.5rem]">
      Welcome to the Dashboard
    </h1>
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
</script>

<style scoped></style>
