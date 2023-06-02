<template>
  <div class="flex justify-between items-center mb-4">
    <h2 class="font-[500] 2xl:font-semibold text-base 2xl:text-lg">{{ title }}</h2>
    <span class="bg-white extra_info p-[2px] 2xl:p-1 rounded-md px-3 2xl:px-4 font-semibold">
      {{ extraInfo }}
    </span>
  </div>
</template>

<script setup lang="ts">
type Props = {
  title: string;
  extraInfo: string;
};

defineProps<Props>();
</script>

<style>
.extra_info {
  border: 2px solid var(--btn-secondary-hover);
}
</style>
