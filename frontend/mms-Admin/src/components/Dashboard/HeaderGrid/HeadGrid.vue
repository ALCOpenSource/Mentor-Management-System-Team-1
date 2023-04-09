<template>
  <div class="flex h-[100px] mx-4 gap-4">
    <ActiveCard />
    <div class="grid">
      <MentorCard />
    </div>
  </div>
</template>

<script setup lang="ts">
import ActiveCard from "./ActiveCard.vue";
import MentorCard from "./MentorCard.vue";
</script>

<style scoped lang="scss">
.grid {
  padding: 12px;
  width: 100%;
  display: flex;
  gap: 15px;
  justify-content: space-between;
  background-color: var(--light-grid-background);
  border-radius: 10px;
}
</style>
