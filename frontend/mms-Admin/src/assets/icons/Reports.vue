<template>
  <svg
    :width="width"
    :height="height"
    viewBox="0 0 29 36"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M21.1112 7.99967H8.22233M21.1112 14.6663H8.22233M21.1112 21.333H16.2779M24.3334 34.6663H5.00011C3.22048 34.6663 1.77789 33.174 1.77789 31.333V4.66634C1.77789 2.82539 3.22048 1.33301 5.00011 1.33301H24.3334C26.113 1.33301 27.5557 2.82539 27.5557 4.66634V31.333C27.5557 33.174 26.113 34.6663 24.3334 34.6663Z"
      stroke="#058B94"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</template>

<script setup lang="ts">
defineProps({
  width: {
    type: String,
    default: "29",
  },
  height: {
    type: String,
    default: "36",
  },
});
</script>
