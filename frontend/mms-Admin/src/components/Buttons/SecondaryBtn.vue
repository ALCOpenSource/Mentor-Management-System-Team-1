<template>
  <!-- Dynamic button types -->
  <button :type="type" :style="{ width: fullWidth ? '100%' : 'max-content' }">
    <!-- Title of buttons passed in as Props -->
    {{ title }}
  </button>
</template>

<script setup lang="ts">
interface Props {
  title: string;
  type?: "submit" | "reset" | "button";
  fullWidth?: boolean;
}

defineProps<Props>();
</script>

<style scoped lang="scss">
button {
  border-radius: 10px;
  border: 1px solid var(--btn-primary);
  background-color: var(--btn-secondary);
  color: #023c40;
  width: max-content;
  padding: 12px 40px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-weight: 600;

  @media (max-width: 1280px) {
    font-weight: 500;
    padding: 10px 30px;
  }

  &:hover {
    background-color: var(--btn-secondary-hover);
  }
}
</style>
