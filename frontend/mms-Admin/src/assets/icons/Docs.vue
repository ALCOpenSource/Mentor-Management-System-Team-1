<template>
  <svg
    width="25"
    height="25"
    viewBox="0 0 25 25"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M21.875 11.4862L13.3797 20.0929C11.0339 22.4697 7.23035 22.4697 4.88443 20.0929C2.53852 17.7163 2.53852 13.8628 4.88443 11.4862L11.9639 4.31384C13.5278 2.72937 16.0634 2.72937 17.6274 4.31384C19.1913 5.89831 19.1913 8.46724 17.6274 10.0517L10.5479 17.224C9.76599 18.0163 8.49817 18.0163 7.71619 17.224C6.93422 16.4318 6.93422 15.1473 7.71619 14.3551L14.7956 7.18278"
      :stroke="color || '#808080'"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</template>

<script setup lang="ts">
const props = defineProps<{
  color?: string;
}>();
const color = props.color;
</script>
