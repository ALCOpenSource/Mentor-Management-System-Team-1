<template>
  <div
    class="inline-flex items-center border-2 border-gray-100 rounded-md p-4 gap-4"
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
    <span
      @click="() => updateSelectedResources(resource.id)"
      class="cursor-pointer"
    >
      <IconAdd
        color="#058B94"
        v-if="!_selectedResources.includes(resource.id)"
      />
      <IconTick
        color="#058B94"
        v-else-if="_selectedResources.includes(resource.id)"
      />
    </span>
  </div>
</template>

<script setup lang="ts">
import type { ResourceType } from "@/typings/components";
import { IconAdd } from "../Icons";
import IconTick from "../Icons/IconTick.vue";
import { ref } from "vue";

let _selectedResources = ref<number[]>([]);

type Props = {
  resource: ResourceType;
  onClick: (id: number) => void;
  selectedResources: number[];
};

const updateSelectedResources = (id: number) => {

  if (!_selectedResources.value.includes(id)) {
    _selectedResources.value = _selectedResources.value.concat(id);
  } else {
    _selectedResources.value = _selectedResources.value.filter(
      (resource) => resource === id
    );
  }
};

const emit = defineEmits(["selectResource"]);

defineProps<Props>();
</script>
