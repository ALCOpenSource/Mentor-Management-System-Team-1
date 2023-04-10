<template>
  <div class="status">
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
  padding: 15px;
  width: 130px;
  height: 100px;
  color: var(--light-grid-background);
  background-color: var(--card-dark);
  border-radius: 10px;
  font-weight: 600;
  font-size: 1.2rem;
  cursor: pointer;

  &:hover {
    background-color: var(--card-dark-hover);
  }
}
</style>
