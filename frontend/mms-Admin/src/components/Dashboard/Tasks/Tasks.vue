<template>
  <div class="my-5 dashboard_section rounded-md bg-green-100 p-4">
    <h2 class="font-[500] 2xl:font-semibold text-base 2xl:text-lg pb-2">
      Tasks overview
    </h2>
    <div class="mb-6">
      <div class="flex my-4 gap-4 justify-between">
        <Status title="In Progress" />
        <TaskCard />
        <TaskCard />
        <TaskCard />
      </div>
      <div class="flex justify-end">
        <router-link :to="{ name: 'tasks' }">
          <SmallPrimaryBtn title="View All" class="px-6" />
        </router-link>
      </div>
    </div>
    <div>
      <div class="flex my-4 gap-4 justify-between">
        <Status title="Completed" />
        <TaskCard />
        <TaskCard />
        <TaskCard />
      </div>
      <div class="flex justify-end">
        <router-link :to="{ name: 'tasks' }">
          <SmallPrimaryBtn title="View All" class="px-6" />
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import Status from "./Status.vue";
import TaskCard from "./TaskCard.vue";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
</script>

<style scoped></style>
