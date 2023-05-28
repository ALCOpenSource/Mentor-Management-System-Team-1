<template>
  <div class="card">
    <div class="flex gap-3 items-center">
      <div v-if="!details.isCert">
        <UserAvatar :imageLink="details.imgUrl" />
      </div>
      <div v-if="details.isCert">
        <img :src="details.imgUrl" alt="" />
      </div>
      <div class="w-3/5">
        <h1 class="text-base font-semibold">{{ details.name }}</h1>
        <p class="text-xs text-[#4D4D4D] truncate">{{ details.text }}</p>
      </div>
    </div>
    <div class="flex flex-col items-center justify-center">
      <SmallPrimaryBtn title="View" />
    </div>
  </div>
</template>

<script setup lang="ts">
import UserAvatar from "../Common/UserAvatar.vue";
import SmallPrimaryBtn from "../Buttons/SmallPrimaryBtn.vue";

defineProps<Props>();

interface Props {
  details: {
    name: string;
    text?: string;
    imgUrl: string;
    isView?: boolean;
    count?: number;
    isCert?: boolean;
  };
}
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 15px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;

  &:hover {
    background-color: var(--light-grid-background);
  }

  &.active {
    background-color: var(--light-grid-background);
    border: none !important;
  }
}
</style>
