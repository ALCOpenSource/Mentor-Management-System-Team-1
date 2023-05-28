<template>
  <div class="w-7/12">
    <div class="justify-end flex items-center mb-12 gap-4">
      <IconSearch color="#058B94" />
      <IconFilter />
      <IconCancel />
    </div>

    <div class="flex gap-3 flex-col">
      <ResourceItem
        v-for="resource in resources"
        :onClick="onClick"
        :resource="resource"
        :selectedResources="selectedResources"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { IconSearch } from "@/assets/icons";
import IconFilter from "../Icons/IconFilter.vue";
import ResourceItem from "./ResourceItem.vue";
import IconCancel from "../Icons/IconCancel.vue";
import type { ResourceType } from "@/typings/components";

type Props = {
  resources: ResourceType[];
  selectedResources: number[];
  onClick: (resourceId: number) => void;
};

defineProps<Props>();
</script>
