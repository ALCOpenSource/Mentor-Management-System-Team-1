<template>
  <svg
    width="30"
    height="30"
    viewBox="0 0 30 30"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M23.75 3.75H6.25C4.86929 3.75 3.75 4.86929 3.75 6.25V18.75C3.75 20.1307 4.86929 21.25 6.25 21.25H10L14.558 25.808C14.8021 26.0521 15.1979 26.0521 15.442 25.808L20 21.25H23.75C25.1307 21.25 26.25 20.1307 26.25 18.75V6.25C26.25 4.86929 25.1307 3.75 23.75 3.75Z"
      :stroke="color ?? '#F7FEFF'"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</template>

<script setup lang="ts">
const props = defineProps({
  color: String,
});
</script>
