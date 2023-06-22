<template>
    <button>
        {{ title }}
    </button>
</template>

<script setup lang="ts">

type Props = {
    title: string;
    type?: "submit" | "reset" | "button";
    fullWidth?: boolean;
    class?: string;
    onClick?: () => void;
}

defineProps<Props>();
</script>

<style lang="scss" scoped>
button {
  border-radius: 10px;
  border: none;
  outline: 2px solid var(--btn-primary);
  color: var(--btn-primary);
  width: max-content;
  padding: 12px 40px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-weight: 600;

  &:disabled {
    background-color: var(--btn-disabled);
    cursor: not-allowed;
  }

  &:hover {
    outline-color: var(--btn-primary-hover);
    color: var(--btn-primary-hover);

    &:disabled {
      background-color: darken(#808080, 10);
    }
  }
}
</style>