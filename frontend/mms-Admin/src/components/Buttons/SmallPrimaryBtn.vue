<template>
  <!-- Dynamic button types -->
  <button
    :type="type"
    @click="onClick"
    :class="class"
    :style="{ width: fullWidth ? '100%' : 'max-content' }"
  >
    <!-- Title of buttons passed in as Props -->
    {{ title }}
  </button>
</template>

<script setup lang="ts">
interface Props {
  title: string;
  type?: "submit" | "reset" | "button";
  fullWidth?: boolean;
  class?: string;
  onClick?: () => void;
}

defineProps<Props>();
</script>

<style scoped lang="scss">
button {
  border-radius: 6px;
  border: none;
  background-color: var(--btn-primary);
  color: #fff;
  width: max-content;
  padding: 5px 15px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-weight: 400;
  font-size: 12px;

  &:disabled {
    background-color: var(--btn-disabled);
    cursor: not-allowed;
  }

  &:hover {
    background-color: var(--btn-primary-hover);

    &:disabled {
      background-color: darken(#808080, 10);
    }
  }
}
</style>
