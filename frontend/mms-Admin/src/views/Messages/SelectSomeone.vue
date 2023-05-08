<template>
  <div>
    <div class="flex justify-between items-center mb-5">
      <h1 class="font-semibold text-2xl">
        Select someone to start a conversation
      </h1>
      <div class="flex gap-6 items-center">
        <Pagination />
        <div class="flex items-center gap-4">
          <IconSearch color="#058B94" size="20" class="cursor-pointer" />
          <Filter class="cursor-pointer" />
          <router-link to="/admin/messages/inbox"><Close class="cursor-pointer" /></router-link>
        </div>
      </div>
    </div>
    <div class="w-full mb-3" v-for="num in getNumberToDisplay()" :key="num">
      <UserCard @click="handleAddToChat" class="cursor-pointer"/>
    </div>
  </div>
</template>

<script setup lang="ts">
import { IconSearch, Close, Filter } from "@/assets/icons";
import Pagination from "@/components/Common/Pagination.vue";
import UserCard from "@/components/Common/UserCard.vue";

const getNumberToDisplay = () => {
  const height = window.innerHeight - window.innerHeight * 0.3;
  const cardHeight = 80;
  const numberToDisplay = Math.floor(height / cardHeight);
  return numberToDisplay;
}

const handleAddToChat = (e: Event) => {
  // Add to Top of Chat Array
}

</script>

<style scoped></style>
