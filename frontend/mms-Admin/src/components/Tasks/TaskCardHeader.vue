<template>
  <span><IconTask color="#058B94" size="60" /></span>
  <section class="flex flex-col">
    <h3
      :class="truncate ? 'truncate w-[250px]' : ''"
      class="text-xl font-semibold"
    >
      {{ title ?? "No Title" }}
    </h3>
    <div class="flex gap-2 items-center">
      <span><IconCalendar /></span>
      <span class="text-gray-300 mt-1">{{ daysDue }} days from now</span>
    </div>
  </section>
</template>

<script setup lang="ts">
import { IconCalendar } from "@/assets/icons";
import { IconTask } from "../Icons";

type Props = {
  title: string;
  daysDue: number;
  truncate?: boolean;
};

defineProps<Props>();
</script>
