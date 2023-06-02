<template>
  <div class="report w-full">
    <Reports />
    <div>
      <h1 class="font-normal text-lg">Google Africa Scholarship</h1>
      <div class="flex">
        <small class="text-xs 2xl:text-sm"><span class="font-semibold">By Ibrahim Kabir </span>- 19th - 25th Oct 2022</small>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Reports } from "@/assets/icons";
</script>

<style scoped lang="scss">
.report {
  display: flex;
  gap: 15px;
  align-items: center;
  padding: 15px;
  background-color: var(--card-light);
  border-radius: 7px;
  cursor: pointer;

  &:hover {
    background-color: var(--card-light-hover);
  }

  small {
    color: var(--text-inactive);
  }
}
</style>
