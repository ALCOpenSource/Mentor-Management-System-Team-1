<template>
  <div class="w-3/5 mx-auto flex flex-col justify-center h-full">
    <div class="flex gap-5 flex-col">
      <h1 class="mb-1 font-semibold text-2xl 2xl:text-3xl 2xl:font-bold">Forgot Password?</h1>
      <h3 class="font-normal text-xl 2xl:text-[22px]">An email has been sent to your registered email.</h3>
      <h3 class="font-normal text-xl 2xl:text-[22px]">Follow the link to reset your password.</h3>
      <PrimaryBtn title="Done" />
    </div>
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
</script>

<style scoped lang="scss">
h3 {
  color: var(--text-inactive);
}
</style>
