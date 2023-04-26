<template>
  <svg
    :width="size ? size + 9 : 22"
    :height="size ?? 13"
    viewBox="0 0 22 13"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M1 1.5H21M5 6.5H17M10 11.5H12"
      :stroke="color ?? '#058B94'"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</template>

<script setup lang="ts">
type Props = {
  size?: string;
  color?: string;
};

defineProps<Props>();
</script>
