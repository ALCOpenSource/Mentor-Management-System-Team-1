<template>
  <span><Google size="35" /></span>
  <section class="flex flex-col">
    <h3 class="font-semibold truncate w-[230px]">
      {{ title ?? "No Title" }}
    </h3>
    <div class="flex gap-5">
      <div class="flex gap-2 items-center">
        <span><IconCalendar /></span>
        <span class="text-gray-300 mt-1 text-[12px]">
          {{ date ?? "No Date" }}
        </span>
      </div>
      <div class="flex gap-2 items-center">
        <span><IconTime /></span>
        <span class="text-gray-300 mt-1 text-[12px]">
          {{ time ?? "No Time" }}
        </span>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { IconCalendar, Google, IconTime } from "@/assets/icons";

type Props = {
  title: string;
  truncate?: boolean;
  date?: string;
  time?: string;
};

defineProps<Props>();
</script>
