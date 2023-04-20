<template>
  <div class="my-8 bg-green-100 dashboard_section rounded-md flex flex-col p-4">
    <SectionTitle title="Programs overview" extraInfo="8 Active" />
    <div class="flex justify-between gap-4">
      <ProgramCard />
      <ProgramCard />
      <ProgramCard />
    </div>
    <div class="flex justify-end mt-6">
      <PrimaryBtn title="View All" />
    </div>
  </div>
</template>

<script setup lang="ts">
import ProgramCard from "./ProgramCard.vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import SectionTitle from "../common/SectionTitle.vue";
</script>

<style>
.dashboard_section {
  border: 2px solid var(--btn-secondary-hover);
}
</style>
