<template>
  <div class="mentor w-full">
    <div>
      <h1 class="text-lg 2xl:text-xl text-[#333333] whitespace-nowrap">
        {{ title }}
      </h1>
      <p class="flex items-center gap-2 -mt-2">
        <span class="text-lg 2xl:text-xl font-semibold">{{ count }}</span>
        <span class="sec text-sm 2xl:text-base">+{{ percentage }}</span>
      </p>
    </div>
    <slot></slot>
  </div>
</template>

<script setup lang="ts">
defineProps<Props>();

interface Props {
  title: string;
  count: number;
  percentage: string;
}
</script>

<style scoped lang="scss">
.mentor {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  height: 100%;
  padding-left: 15px;
  padding-right: 15px;
  background-color: var(--card-light);
  border-radius: 7px;
  cursor: pointer;

  &:hover {
    background-color: var(--card-light-hover);
  }
  .sec {
    font-weight: 400;
    color: var(--text-inactive);
  }
}
</style>
