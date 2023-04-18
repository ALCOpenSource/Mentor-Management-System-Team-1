<template>
  <div class="my-5 dashboard_section rounded-md bg-green-100 p-4">
    <SectionTitle title="Reports" extraInfo="10 Reports Submitted" />
    <div class="flex justify-between">
      <ReportCard />
      <ReportCard />
      <ReportCard />
    </div>
    <div class="flex justify-end mt-6">
      <PrimaryBtn title="View All" />
    </div>
  </div>
</template>

<script setup lang="ts">
import ReportCard from "./ReportCard.vue";
import SectionTitle from "../common/SectionTitle.vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
</script>

<style scoped></style>
