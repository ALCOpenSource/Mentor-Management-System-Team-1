<template>
  <div class="w-2/4 relative">
    <span class="search_icon absolute top-4 left-4">
      <IconSearch color="#808080" />
    </span>
    <input
      class="p-4 pl-12 text-xl bg-white rounded-md w-full"
      type="text"
      placeholder="Search for anything"
    />
  </div>
</template>

<script setup lang="ts">
import { IconSearch } from "../Icons";
</script>

<style></style>
