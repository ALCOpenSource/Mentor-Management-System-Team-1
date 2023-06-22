<template>
  <div class="card">
    <div class="flex gap-2 items-center">
      <img
        src="https://i.pravatar.cc/300"
        class="w-[45px] h-auto rounded-full object-cover"
        alt=""
        srcset=""
      />
      <h1
        class="text-sm 2xl:text-base font-semibold cursor-pointer hover:underline transition-all"
      >
        Google Africa Scholarship
      </h1>
    </div>
    <div class="flex flex-wrap items-center justify-end mr-0" @click="onClick">
      <Tick color="#058B94" class="cursor-pointer" v-if="added" />
      <IconCircleAdd color="#058B94" class="cursor-pointer" v-else />
    </div>
  </div>
</template>

<script setup lang="ts">
import { Tick, IconCircleAdd } from "@/assets/icons";

defineProps<Props>();

interface Props {
  added?: boolean;
  onClick?: () => void;
}
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;
  margin-bottom: 10px;
}
</style>
