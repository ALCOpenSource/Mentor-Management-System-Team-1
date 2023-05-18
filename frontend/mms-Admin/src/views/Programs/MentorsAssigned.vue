<template>
  <div>
    <div class="flex justify-between items-center">
      <h1 class="font-semibold text-2xl">
        Mentors Assigned to Google Africa...
      </h1>
      <div class="flex items-center gap-3">
        <Pagination />
        <Filter class="cursor-pointer" />
        <router-link :to="{name: 'program', params: { id: route.params.id } }">
          <Close class="cursor-pointer" />
        </router-link>
      </div>
    </div>
    <div class="mt-5 mb-5">
      <div v-for="item in getNumberToDisplay()" :key="item" class="mb-3">
        <UserCard :show-comment="true" :is-mentor="true"/>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from "vue-router";
import { Close, Filter } from "@/assets/icons";
import Pagination from "@/components/Common/Pagination.vue";
import UserCard from "@/components/Common/UserCard.vue";

const route = useRoute();

const getNumberToDisplay = () => {
  const height = window.innerHeight - window.innerHeight * 0.3;
  const cardHeight = 80;
  const numberToDisplay = Math.floor(height / cardHeight);
  return numberToDisplay;
}

</script>

<style scoped></style>
