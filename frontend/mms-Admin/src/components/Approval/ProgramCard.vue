<template>
  <div class="card">
    <div class="flex gap-12 items-center">
      <UserAvatar />
      <h1
        class="text-xl font-semibold cursor-pointer hover:underline transition-all"
      >
        Google Africa Scholarship Program
      </h1>
    </div>
    <div class="flex items-center justify-center bg-[#CC000E] text-[#fff] text-base font-semibold px-1">{{count}}</div>
  </div>
</template>

<script setup lang="ts">
import UserAvatar from "../Common/UserAvatar.vue";

defineProps<Props>();

interface Props {
  count?: number;
}
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8rem;
  padding: 10px 40px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;

  &:hover {
    background-color: var(--light-grid-background);
  }
}
</style>
