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
  border-radius: 10px;
  border: none;
  background-color: var(--btn-primary);
  color: #fff;
  width: max-content;
  padding: 12px 40px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-weight: 600;

  @media (max-width: 1280px) {
    font-weight: 500;
    padding: 10px 30px;
  }

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
