<template>
  <router-link :to="path + id" key="1">
    <div
      class="card cursor-pointer overflow-hidden w-full gap-4 flex mb-6 py-4 border-gray-200 border-2 rounded-md px-4"
    >
      <slot></slot>
      <section class="flex flex-col gap-1">
        <h2 class="text-xl truncate w-[300px] font-semibold">{{ title }}</h2>
        <div class="flex justify-between gap-4">
          <p class="font-semibold text-gray-300 min-w-1/4 truncate">
            By {{ author }}
          </p>
          <p class="text-gray-300 w-1/2">19th - 25th Oct 22</p>
        </div>
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
  id: number;
};

defineProps<Props>();
</script>

<style></style>
