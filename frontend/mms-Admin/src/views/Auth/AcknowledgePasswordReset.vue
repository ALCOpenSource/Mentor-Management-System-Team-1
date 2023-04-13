<template>
  <div class="w-3/5 mx-auto flex flex-col justify-center h-full">
    <div class="flex gap-5 flex-col">
      <h1 class="mb-1">Forgot Password?</h1>
      <h3>An email has been sent to your registered email.</h3>
      <h3>Follow the link to reset your password.</h3>
      <PrimaryBtn title="Done" />
    </div>
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
</script>

<style scoped lang="scss">
h1 {
  font-weight: 700;
  font-size: 32px;
}

h3 {
  font-weight: 400;
  font-size: 22px;
  color: var(--text-inactive);
}
</style>
