<template>
  <div class="w-full flex flex-col gap-6">
    <div class="flex justify-end">
      <PrimaryBtn title="Compose Report" />
    </div>
    <section
      class="border h-[70vh] gap-2 justify-center items-center flex flex-col border-gray-200 rounded-md"
    >
      <div class="flex flex-col gap-1 items-center">
        <IconNotSelected />
        <h4 class="font-semibold">No item selected yet</h4>
      </div>
      <p class="text-gray-500">Select an item from the list to view report</p>
    </section>
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import { IconNotSelected } from "@/components/Icons";
</script>

<style></style>
