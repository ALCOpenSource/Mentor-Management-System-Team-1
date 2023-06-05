<template>
  <div class="flex w-[165px] justify-between items-center">
    <ArrowLeft2 @click="$emit('fetchPage', 'first')" class="cursor-pointer" />
    <ArrowLeft @click="$emit('fetchPage', 'previous')" class="cursor-pointer" />
    <p class="font-semibold whitespace-nowrap">{{ (pagination.current_page * pagination.per_page) - (pagination.per_page - 1) }} - {{ pagination.current_page * pagination.per_page }} of {{ pagination.total }}</p>
    <ArrowRight @click="$emit('fetchPage', 'next')" class="cursor-pointer" />
    <ArrowRight2 @click="$emit('fetchPage', 'last')" class="cursor-pointer" />
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

defineEmits(["fetchPage"]);

</script>

<style scoped lang="scss"></style>
