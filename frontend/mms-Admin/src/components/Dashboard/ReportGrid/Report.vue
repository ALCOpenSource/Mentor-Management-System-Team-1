<template>
  <div class="my-5 dashboard_section rounded-md bg-green-100 p-4">
    <SectionTitle title="Reports" extraInfo="10 Reports Submitted" />
    <div class="flex justify-between gap-4">
      <ReportCard />
      <ReportCard />
      <ReportCard />
    </div>
    <div class="flex justify-end mt-4">
      <SmallPrimaryBtn title="View All" class="px-6"/>
    </div>
  </div>
</template>

<script setup lang="ts">
import ReportCard from "./ReportCard.vue";
import SectionTitle from "../common/SectionTitle.vue";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
</script>

<style scoped></style>
