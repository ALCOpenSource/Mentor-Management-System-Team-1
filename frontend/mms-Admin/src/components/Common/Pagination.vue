<template>
  <div class="flex w-[165px] justify-between items-center">
    <ArrowLeft2 class="cursor-pointer" />
    <ArrowLeft class="cursor-pointer" />
    <p class="font-semibold text-sm 2xl:text-base whitespace-nowrap">
      1 - 10 of 50
    </p>
    <ArrowRight class="cursor-pointer" />
    <ArrowRight2 class="cursor-pointer" />
  </div>
</template>

<script setup lang="ts">
import { ArrowLeft, ArrowRight, ArrowRight2, ArrowLeft2 } from "@/assets/icons";

const props = defineProps({
  pagination: {
    type: Object,
    default: null,
  },
});
</script>

<style scoped lang="scss"></style>
