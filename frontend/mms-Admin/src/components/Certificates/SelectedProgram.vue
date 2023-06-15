<template>
  <div class="w-full flex items-center justify-between">
    <div class="flex gap-10 items-center">
      <img
        src="https://i.pravatar.cc/300"
        class="w-[45px] h-auto rounded-full object-cover"
        alt=""
        srcset=""
      />
      <h1
        class="text-lg 2xl:text-xl font-semibold cursor-pointer hover:underline transition-all"
      >
        Google Africa Scholarship Program
      </h1>
    </div>
    <div>
      <IconDelete color="#058B94" class="cursor-pointer" @click="onClick" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { IconDelete } from "../Icons";

defineProps<Props>();

interface Props {
  onClick: () => void;
}
</script>

<style scoped lang="scss"></style>
