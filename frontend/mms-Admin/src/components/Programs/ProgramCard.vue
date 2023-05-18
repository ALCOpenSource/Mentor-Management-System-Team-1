<template>
  <div class="card" :class="isSelected ? 'selected' : null" :onClick="onClick">
    <ProgramHeader :truncate="true" :title="title" :date="date" :time="time"/>
  </div>
</template>

<script setup lang="ts">
import ProgramHeader from "./ProgramHeader.vue";

type Props = {
  title: string;
  date?: string;
  time?: string;
  isSelected: boolean;
  onClick: () => void;
};

defineProps<Props>();
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 15px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;
  margin-bottom: 10px;
  cursor: pointer;
  transition: all 0.2s ease-in-out;

  &:hover {
    background-color: var(--light-grid-background);
  }

  &.selected {
    border-color: #058b94;
    background: var(--light-grid-background);
  }
}
</style>
