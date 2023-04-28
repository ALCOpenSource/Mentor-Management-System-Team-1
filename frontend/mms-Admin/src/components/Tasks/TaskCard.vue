<template>
  <div class="card" :class="isSelected ? 'selected' : null" :onClick="onClick">
    <TaskCardHeader :truncate="true" :title="title" :days-due="daysDue" />
  </div>
</template>

<script setup lang="ts">
import TaskCardHeader from "./TaskCardHeader.vue";

type Props = {
  title: string;
  description: string;
  daysDue: number;
  isSelected: boolean;
  onClick: () => void;
};

defineProps<Props>();
</script>

<style scoped lang="scss">
.card {
  display: flex;
  cursor: pointer;
  gap: 1rem;
  min-height: 100px;
  width: 100%;
  overflow-x: hidden;
  padding: 1rem;
  border: 2px solid hsla(0, 0%, 90%, 1);
  border-radius: 10px;
  transition: 200ms border-color ease-in, background 300ms ease-out;

  &.selected {
    border-color: #058b94;
    background: var(--light-grid-background);
  }
}
</style>
