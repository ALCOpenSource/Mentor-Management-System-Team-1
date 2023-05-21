<template>
  <div
    class="card cursor-pointer flex gap-8 py-4 border-gray-200 border-2 rounded-md px-4"
  >
    <IconTask color="#058B94" size="75" />
    <section class="flex flex-col gap-4">
      <h2 class="text-2xl">Room Library article write...</h2>
      <div class="flex gap-4">
        <p class="font-semibold text-gray-300">By Alison Davis</p>
        <p>19th - 25th Oct 22</p>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { IconTask } from "../Icons";
</script>

<style></style>
