<template>
  <div class="w-full flex items-center justify-between">
    <div class="flex gap-5 items-center">
      <UserAvatar />
      <div class="flex flex-wrap items-center">
        <div class="flex flex-col mr-8">
          <h1
            class="text-lg 2xl:text-xl font-semibold cursor-pointer hover:underline transition-all"
          >
            Allison Davies
          </h1>
          <small class="text-[#808080]"
            >Program Assistant, Andela, She/her</small
          >
        </div>
        <div class="flex items-center gap-3">
          <div class="text-xs bg-[#E6FDFE] rounded py-1 px-3">
            PROGRAM ASST.
          </div>
          <div class="text-xs bg-[#E6FDFE] rounded py-1 px-3">MENTOR-GADS</div>
        </div>
      </div>
    </div>
    <div>
      <IconDelete color="#058B94" class="cursor-pointer" @click="onClick" />
    </div>
  </div>
</template>

<script setup lang="ts">
import UserAvatar from "../Common/UserAvatar.vue";
import { IconDelete } from "../Icons";

defineProps<Props>();

interface Props {
  onClick: () => void;
}
</script>

<style scoped></style>
