<template>
  <div class="flex h-[100px] gap-4">
    <ActiveCard />
    <div
      class="flex bg-green-100 rounded-lg w-full dashboard_section p-2 justify-between gap-4"
    >
      <MentorCard />
      <MentorCard />
      <MentorCard />
      <MentorCard />
    </div>
  </div>
</template>

<script setup lang="ts">
import ActiveCard from "./ActiveCard.vue";
import MentorCard from "./MentorCard.vue";
</script>

<style scoped lang="scss"></style>
