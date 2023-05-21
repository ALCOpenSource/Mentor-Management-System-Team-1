<template>
  <div
    class="card cursor-pointer flex gap-8 py-4 border-gray-200 border-2 rounded-md px-4"
  >
    <IconReportAlt color="#058B94" :size="50" />
    <section class="flex flex-col gap-2">
      <h2 class="text-2xl font-semibold">Room Library article write...</h2>
      <div class="flex gap-4">
        <p class="font-semibold text-gray-300">By Alison Davis</p>
        <p class="text-gray-300">19th - 25th Oct 22</p>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { IconTask } from "../Icons";
import IconReportAlt from "../Icons/IconReportAlt.vue";
</script>

<style></style>
