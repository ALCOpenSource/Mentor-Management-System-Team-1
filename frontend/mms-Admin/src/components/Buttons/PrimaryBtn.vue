<template>
  <!-- Dynamic button types -->
  <button :type="type">
    <!-- Title of buttons passed in as Props -->
    {{ title }}
  </button>
</template>

<script setup lang="ts">

interface Props {
  title: string;
  type?: 'submit' | 'reset' | 'button';
}

defineProps<Props>();

</script>

<style scoped lang="scss">
button {
  border-radius: 10px;
  border: none;
  background-color: var(--btn-primary);
  color: #fff;
  width: 100%;
  padding: 12px 40px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-weight: 600;

  &:hover {
    background-color: var(--btn-primary-hover);
  }
}
</style>