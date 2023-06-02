<template>
  <div class="my-6 bg-green-100 dashboard_section rounded-md flex flex-col p-4">
    <SectionTitle title="Programs overview" extraInfo="8 Active" />
    <div class="flex justify-between gap-4">
      <ProgramCard />
      <ProgramCard />
      <ProgramCard />
    </div>
    <div class="flex justify-end mt-4">
      <SmallPrimaryBtn title="View All" class="px-6"/>
    </div>
  </div>
</template>

<script setup lang="ts">
import ProgramCard from "./ProgramCard.vue";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
import SectionTitle from "../common/SectionTitle.vue";
</script>

<style>
.dashboard_section {
  border: 2px solid var(--btn-secondary-hover);
}
</style>
