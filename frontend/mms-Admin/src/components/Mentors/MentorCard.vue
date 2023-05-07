<template>
  <div class="card">
    <div class="flex gap-3 items-center">
      <UserAvatar />
      <div>
        <h1 class="text-md font-semibold">Alison Davis</h1>
        <p class="text-xs text-[#4D4D4D]">Added 0ct. 10 2022</p>
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
  margin-bottom: 10px;

  &:hover {
    background-color: var(--light-grid-background);
  }

  &.active {
    background-color: var(--light-grid-background);
    border: none !important;
  }
}
</style>
