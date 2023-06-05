<template>
  <div class="status text-lg font-semibold">
    <h1>{{ title }}</h1>
  </div>
</template>

<script setup lang="ts">
defineProps({
  title: {
    type: String,
    required: true,
  },
});
</script>

<style scoped lang="scss">
.status {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px;
  width: 130px;
  height: 90px;
  color: var(--light-grid-background);
  background-color: var(--card-dark);
  border-radius: 10px;
  cursor: pointer;

  &:hover {
    background-color: var(--card-dark-hover);
  }
}
</style>
