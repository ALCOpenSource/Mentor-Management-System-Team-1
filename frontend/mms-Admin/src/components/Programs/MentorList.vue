<template>
  <div>
    <div class="justify-end flex items-center mb-6 gap-4">
      <IconSearch color="#058B94" class="cursor-pointer" />
      <Filter class="cursor-pointer" />
      <Close class="cursor-pointer" @click="onClick" />
    </div>
    <div class="h-[70vh] overflow-y-scroll scrollbar pr-1">
      <MentorItem
        v-for="(item, index) in 15"
        :key="item"
        :is-mentor-manager="isMentorManager"
        :added="addedRef?.includes(index)"
        :on-click="() => setAdded(index)"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { IconSearch, Close, Filter } from "@/assets/icons";
import MentorItem from "./MentorItem.vue";

defineProps<Props>();

const addedRef = ref<number[]>([]);

const setAdded = (index: number) => {
  if (addedRef.value?.includes(index)) {
    addedRef.value = addedRef.value?.filter((item) => item !== index);
  } else {
    addedRef.value?.push(index);
  }
  // Add or remove mentor/mentor-manager from the list in the backend
};

interface Props {
  onClick: () => void;
  isMentorManager: boolean;
}
</script>

<style scoped></style>
