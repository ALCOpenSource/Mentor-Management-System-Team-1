<template>
  <button
    :class="underline ? 'underline' : ''"
    class="text-red-400 flex items-center gap-2"
  >
    <slot></slot>
    <span class="mt-1">{{ title }}</span>
  </button>
</template>

<script setup lang="ts">
type Props = {
  title: string;
  Icon?: any;
  underline?: boolean;
};
defineProps<Props>();
</script>

<style scoped lang="scss">
button {
  border-radius: 10px;
  border: none;
  width: max-content;
  padding: 12px 40px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-weight: 600;

  &:disabled {
    background-color: var(--btn-disabled);
    cursor: not-allowed;
  }

  &:hover {
    background-color: var(--border);

    &:disabled {
      background-color: darken(#808080, 10);
    }
  }
}
</style>
