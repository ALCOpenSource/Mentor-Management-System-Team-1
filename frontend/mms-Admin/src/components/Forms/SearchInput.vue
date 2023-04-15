<template>
  <div class="w-2/4 relative">
    <span class="search_icon absolute top-[10px] left-4">
      <IconSearch color="#808080" />
    </span>
    <input
      class="p-4 py-2 pl-12 text-xl bg-white rounded-md w-full focus:outline-[#058b94]"
      type="text"
      placeholder="Search for anything"
    />
  </div>
</template>

<script setup lang="ts">
import { IconSearch } from "../Icons";
</script>

<style></style>
