<template>
  <div>
    <div class="flex justify-between items-center">
      <h1 class="font-semibold text-xl 2xl:text-2xl">
        Mentors Assigned to Google Africa...
      </h1>
      <div class="flex items-center gap-3">
        <Pagination @fetchPage="handlePagination" :pagination="userStore.pagination"/>
        <Filter class="cursor-pointer" />
        <router-link :to="{ name: 'program', params: { id: route.params.id } }">
          <Close class="cursor-pointer" />
        </router-link>
      </div>
    </div>
    <div class="mt-5 mb-5">
      <div v-for="user in userStore.users" :key="user.name" class="mb-3">
        <UserCard :show-comment="true" :user="user" :is-mentor="true" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineComponent } from "vue";
import { useRoute } from "vue-router";
import { Close, Filter } from "@/assets/icons";
import Pagination from "@/components/Common/Pagination.vue";
import UserCard from "@/components/Common/UserCard.vue";
import { useUserStore } from "@/store/user";

const userStore = useUserStore();
const route = useRoute();

const getNumberToDisplay = () => {
  const height = window.innerHeight - window.innerHeight * 0.3;
  const cardHeight = 80;
  const numberToDisplay = Math.floor(height / cardHeight);
  return numberToDisplay;
};

let page = 0;
const handlePagination = (type: string) => {
  // Add to Top of Chat Array
  switch (type) {
    case 'first':
      if(userStore?.pagination?.current_page !== 1) {
        page = 1;
      }
      break;
  
    case 'previous':
      if(userStore?.pagination?.links?.previous !== null) {
        page = userStore?.pagination?.current_page - 1;
      }
      break;

    case 'next':
      if(userStore?.pagination?.links?.next !== null) {
        page = userStore?.pagination?.current_page + 1;
      }
      break;
  
    case 'last':
      if(userStore?.pagination?.current_page !== userStore?.pagination?.total_pages) {
        page = userStore?.pagination?.total_pages;
      }
      break;

    default:
      break;
  }
  if(page !== 0) {
    userStore.fetchUserPerPage(page);
  }
}
</script>

<script lang="ts">
export default defineComponent({
  beforeRouteEnter(to, from, next) {
    const userStore = useUserStore();
    if (userStore.users) {
      next();
    } else {
      userStore.fetchUsers().then(() => {
        next();
      });
    }
  },
});
</script>

<style scoped></style>
