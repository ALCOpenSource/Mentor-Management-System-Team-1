<template>
  <div class="m-4">
    <h1>Tasks overview</h1>
    <div class="flex my-4">
      <Status title="In Progress" />
      <TaskCard />
    </div>
    <div class="flex">
      <Status title="Completed" />
    </div>
  </div>
</template>

<script setup lang="ts">
import Status from "./Status.vue";
import TaskCard from "./TaskCard.vue";
</script>

<style scoped></style>
