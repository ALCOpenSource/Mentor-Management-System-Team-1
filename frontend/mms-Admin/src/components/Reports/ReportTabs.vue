<template>
  <div class="p-3 bg-green-400">
    <button>Program Reports</button>
    <button>Task Reports</button>
  </div>
  <component :is="current"></component>
</template>

<script lang="ts">
export default {
  data() {
    return {
      current: "",
    };
  },
};
</script>

<style></style>
