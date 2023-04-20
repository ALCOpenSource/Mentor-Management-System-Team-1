<template>
  <div class="my-5 dashboard_section rounded-md bg-green-100 p-4">
    <h2 class="font-semibold text-lg pb-2">Tasks overview</h2>
    <div class="mb-12">
      <div class="flex my-4 gap-8 justify-between">
        <Status title="In Progress" />
        <TaskCard />
        <TaskCard />
        <TaskCard />
      </div>
      <div class="flex justify-end">
        <PrimaryBtnVue title="View All" class="w-12" />
      </div>
    </div>
    <div>
      <div class="flex my-4 gap-8 justify-between">
        <Status title="Completed" />
        <TaskCard />
        <TaskCard />
        <TaskCard />
      </div>
      <div class="flex justify-end">
        <PrimaryBtnVue title="View All" class="w-12" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import Status from "./Status.vue";
import TaskCard from "./TaskCard.vue";
import PrimaryBtnVue from "@/components/Buttons/PrimaryBtn.vue";
</script>

<style scoped></style>
