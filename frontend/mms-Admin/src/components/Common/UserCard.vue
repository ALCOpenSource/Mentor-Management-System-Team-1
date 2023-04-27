<template>
  <div class="card">
    <div class="flex gap-5 items-center">
      <UserAvatar />
      <div class="flex flex-wrap items-center">
        <div class="flex flex-col mr-8">
          <h1 class="text-xl font-semibold">Allison Davies</h1>
          <small class="text-[#808080]">Program Assistant, Andela, She/her</small>
        </div>
        <div class="flex items-center gap-3">
          <div class="text-sm bg-[#E6FDFE] rounded py-1 px-3">PROGRAM ASST.</div>
          <div class="text-sm bg-[#E6FDFE] rounded py-1 px-3">MENTOR-GADS</div>
        </div>
      </div>
    </div>
    <div class="flex flex-wrap items-center gap-6">
      <Comment class="cursor-pointer" v-if="showComment"/>
      <IconDelete color="#058B94" class="cursor-pointer" v-if="showDelete"/>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Comment } from "@/assets/icons";
import { IconDelete } from "../Icons";
import UserAvatar from "./UserAvatar.vue";

defineProps({
  showComment: {
    type: Boolean,
    default: false,
  },
  showDelete: {
    type: Boolean,
    default: false,
  },
});
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 4rem;
  padding: 10px 40px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;
  margin-bottom: 10px;

  &:hover {
    background-color: var(--light-grid-background);
  }

  &.selected {
    background-color: var(--light-grid-background);
    border: none !important;
  }
}
</style>
