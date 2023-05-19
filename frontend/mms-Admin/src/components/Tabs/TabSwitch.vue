<template>
  <div class="inline-flex gap-4 rounded-md bg-green-400 p-2">
    <button class="tab-button">Program Reports</button>
    <button class="active">Task Reports</button>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

let selectedTab = null;
</script>

<style scoped lang="scss"></style>
