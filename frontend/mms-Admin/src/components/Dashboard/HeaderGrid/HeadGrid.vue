<template>
  <div class="flex h-[100px] w-full gap-4">
    <ActiveCard />
    <div
      class="flex bg-green-100 rounded-lg w-full dashboard_section p-2 gap-4 justify-between"
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
