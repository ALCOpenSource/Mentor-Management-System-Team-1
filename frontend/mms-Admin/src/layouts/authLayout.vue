<template>
  <div class="grid h-screen grid-cols-2">
    <div>
      <Splash />
    </div>
    <div>
      <router-view></router-view>
    </div>
  </div>
</template>

<script setup lang="ts">
import Splash from "../components/Auth/Splash.vue";
</script>

<style scoped></style>
<style scoped></style>
