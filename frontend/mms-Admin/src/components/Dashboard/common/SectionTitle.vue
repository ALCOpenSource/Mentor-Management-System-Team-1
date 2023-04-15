<template>
  <div class="flex justify-between items-center mb-4">
    <h2 class="font-semibold text-lg pb-2">{{ title }}</h2>
    <span class="bg-white extra_info p-1 rounded-md px-4 font-semibold">
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
