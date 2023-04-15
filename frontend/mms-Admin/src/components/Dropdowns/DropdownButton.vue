<template>
  <button
    class="bg-green-100 dashboard_section rounded-md px-4 flex items-center gap-2 font-medium py-2"
  >
    {{ text }}
    <span>
      <svg
        width="10"
        height="7"
        viewBox="0 0 10 7"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M9 1.03711L5 5.03711L1 1.03711"
          stroke="#808080"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </span>
  </button>
</template>

<script setup lang="ts">
type Props = {
  text: string;
};

defineProps<Props>();
</script>
