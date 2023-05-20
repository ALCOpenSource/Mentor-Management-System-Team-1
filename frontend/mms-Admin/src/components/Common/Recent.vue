<template>
  <div class="recent">
    <h1 class="p-2 font-semibold text-lg">Recent</h1>
    <div class="flex flex-col gap-2">
      <MentorCard v-for="item in 6" :key="item" :details="recentDetails" />
    </div>
  </div>
</template>

<script setup lang="ts">
import MentorCard from "../Mentors/MentorCard.vue";
import { smallCertificate } from "@/assets/images";

const recentDetails = {
  name: "Alison Davis",
  text: "GADS CLOUD 2022 - COMP...",
  imgUrl: smallCertificate,
  isCert: true,
};
</script>

<style scoped lang="scss">
.recent {
  border: 1px solid var(--card-light);
  border-radius: 10px;
  background-color: var(--light-grid-background);
  padding: 5px;
  padding-bottom: 10px;
}
</style>
