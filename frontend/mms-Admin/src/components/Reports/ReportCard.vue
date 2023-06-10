<template>
  <router-link :to="path + id" key="1">
    <div
      class="cursor-pointer overflow-hidden w-full gap-4 flex items-center mb-2 px-2 py-3 border-gray-200 border rounded-md"
    >
      <slot></slot>
      <section class="flex flex-col gap-1">
        <h2 class="text-sm 2xl:text-base mb-1 truncate w-[98%] font-semibold">
          {{ title }}
        </h2>
        <p class="text-xs text-gray-300"><span class="font-[500]">By {{ author }} - </span> 19th - 25th Oct 22</p>
      </section>
    </div>
  </router-link>
</template>

<script setup lang="ts">
import { IconTask } from "../Icons";
import IconReportAlt from "../Icons/IconReportAlt.vue";

type Props = {
  path: string;
  title: string;
  author: string;
  date: string;
  id: number;
};

defineProps<Props>();
</script>

<style></style>
