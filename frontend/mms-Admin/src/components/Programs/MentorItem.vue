<template>
  <div class="card">
    <div class="flex gap-2 items-center">
      <img
        src="https://i.pravatar.cc/300"
        class="w-[45px] h-auto rounded-full object-cover"
        alt=""
        srcset=""
      />
      <div class="flex flex-col">
        <div class="flex flex-col">
          <router-link
            :to="{
              name: isMentorManager ? 'mentor-manager' : 'mentor',
              params: { id: 1 },
            }"
          >
            <h1
              class="text-base font-semibold cursor-pointer hover:underline transition-all"
            >
              Allison Davies
            </h1>
          </router-link>
          <small class="text-[#808080] text-xs whitespace-nowrap"
            >Program Assistant, Andela, She/her</small
          >
        </div>
        <div class="flex items-center gap-2">
          <div class="w-full text-xs truncate bg-[#E6FDFE] rounded py-1 px-3">
            PROGRAM ASST.
          </div>
          <div class="w-full text-xs truncate bg-[#E6FDFE] rounded py-1 px-3">
            MENTOR-GADS
          </div>
        </div>
      </div>
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

defineEmits(["delete"]);

interface Props {
  isMentorManager: boolean;
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
