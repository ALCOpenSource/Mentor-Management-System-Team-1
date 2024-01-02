<template>
  <div class="w-[346px] relative">
    <span class="search_icon absolute top-[8px] left-4">
      <IconSearch />
    </span>
    <input
      class="p-4 py-[6px] pl-12 border bg-white rounded-md w-full focus:outline-[#058b94] placeholder:text-[14px]"
      type="text"
      :placeholder="placeholder"
    />
  </div>
</template>

<script setup lang="ts">
import { IconSearch } from "@/assets/icons";

defineProps({
  placeholder: {
    type: String,
    default: "Search for anything",
  },
});
</script>

<style scoped></style>
