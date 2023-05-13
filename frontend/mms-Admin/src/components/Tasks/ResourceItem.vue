<template>
  <div
    class="inline-flex cursor-pointer items-center border-2 border-gray-100 rounded-md p-4 gap-4"
  >
    <img
      src="https://i.pravatar.cc/300"
      class="w-20 h-auto rounded-full object-cover"
      alt=""
      srcset=""
    />
    <section class="flex flex-col">
      <h3 class="font-bold text-xl">{{ resource.name }}</h3>
      <span class="text-gray-300">Program Assistant, Andela, She/her</span>
      <div class="flex gap-2">
        <span class="bg-green-200 p-2 rounded-md">PROGRAM ASST.</span>
        <span class="bg-green-200 p-2 rounded-md">MENTOR-GADS</span>
      </div>
    </section>
    <span @click="() => onClick(resource.id)">
      <IconAdd
        color="#058B94"
        v-if="!selectedResources.includes(resource.id)"
      />
      <IconTick v-else />
    </span>
  </div>
</template>

<script setup lang="ts">
import type { ResourceType } from "@/typings/components";
import { IconAdd } from "../Icons";
import IconTick from "../Icons/IconTick.vue";

type Props = {
  resource: ResourceType;
  onClick: (id: number) => void;
  selectedResources: number[];
};

defineProps<Props>();
</script>
