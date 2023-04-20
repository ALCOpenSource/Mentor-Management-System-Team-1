<template>
  <div class="card">
    <div class="flex gap-3 items-center">
      <UserAvatar />
      <div>
        <h1 class="text-md font-semibold">John Doe</h1>
        <p class="text-xs">Can we go ahead to join ...</p>
      </div>
    </div>
    <div class="flex flex-col items-center justify-center">
      <p>30m</p>
      <small
        class="flex justify-center items-center bg-[#FF5964] text-white rounded w-[15px] h-[15px]"
        >3</small
      >
    </div>
  </div>
</template>

<script setup lang="ts">
import UserAvatar from "../Common/UserAvatar.vue";
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 15px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;
  margin-bottom: 10px;
  cursor: pointer;

  &:hover {
    background-color: var(--light-grid-background);
  }

  &.active {
    background-color: var(--light-grid-background);
    border: none !important;
  }
}
</style>
