<template>
  <span><IconTask color="#058B94" size="34" /></span>
  <section class="flex flex-col">
    <h3
      :class="truncate ? 'truncate w-[160px]' : ''"
      class="text-sm 2xl:text-base font-semibold"
    >
      {{ title ?? "No Title" }}
    </h3>
    <div class="flex gap-2 items-center">
      <span><IconCalendar /></span>
      <span class="text-gray-300 mt-1 text-xs"
        >{{ calculateDaysLeft(daysDue) }} days from now</span
      >
    </div>
  </section>
</template>

<script setup lang="ts">
import { IconCalendar } from "@/assets/icons";
import { IconTask } from "../Icons";

type Props = {
  title: string;
  daysDue: string;
  truncate?: boolean;
};

const calculateDaysLeft = (date: string) => {
  const daysLeft = new Date(Date.now()).getTime() - new Date(date).getTime();
  const differenceInDays = Math.floor(daysLeft / (1000 * 3600 * 24));
  return differenceInDays;
};

defineProps<Props>();
</script>
