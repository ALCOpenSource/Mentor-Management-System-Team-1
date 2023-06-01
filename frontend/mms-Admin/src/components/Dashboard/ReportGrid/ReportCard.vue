<template>
  <div class="report w-3/5">
    <Reports />
    <div>
      <h1 class="font-normal text-lg">Google Africa Scholarship</h1>
      <div>
        <small class="text-semibold text-base">By Ibrahim Kabir </small>
        <small>- 19th - 25th Oct 2022</small>
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
  gap: 20px;
  align-items: center;
  padding: 15px;
  background-color: var(--card-light);
  border-radius: 7px;
  min-width: 330px;
  max-width: 350px;
  cursor: pointer;

  &:hover {
    background-color: var(--card-light-hover);
  }

  small {
    color: var(--text-inactive);
  }
}
</style>
