<template>
  <div>
    <div class="flex justify-between items-center mb-5">
      <h1 class="font-semibold text-2xl">
        Select someone to start a conversation
      </h1>
      <div class="flex gap-6 items-center">
        <Pagination @fetchPage="handlePagination" :pagination="userStore.pagination"/>
        <div class="flex items-center gap-4">
          <IconSearch color="#058B94" size="20" class="cursor-pointer" />
          <Filter class="cursor-pointer" />
          <router-link to="/admin/messages/inbox"
            ><Close class="cursor-pointer"
          /></router-link>
        </div>
      </div>
    </div>
    <div class="w-full mb-3" v-for="user in userStore.users" :key="user">
      <UserCard @select="handleAddToChat" :user="user" class="cursor-pointer"/>
    </div>
  </div>
</template>

<script setup lang="ts">
import { IconSearch, Close, Filter } from "@/assets/icons";
import Pagination from "@/components/Common/Pagination.vue";
import UserCard from "@/components/Common/UserCard.vue";
import { defineComponent } from 'vue'
import { useUserStore } from "@/store/user"
import { useMessageStore } from "@/store/message"

const userStore = useUserStore()
const messageStore = useMessageStore()

const getNumberToDisplay = () => {
  const height = window.innerHeight - window.innerHeight * 0.3;
  const cardHeight = 80;
  const numberToDisplay = Math.floor(height / cardHeight);
  return numberToDisplay;
};

const handleAddToChat = (user: Object) => {
  // Add to Top of Chat Array
  messageStore.updateReceiverData(user);
}

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
    const userStore = useUserStore()
    if (userStore.users) {
      next()
    } else {
      userStore.fetchUsers().then(() => {
        next();
      });
    }
  },
})
</script>

<style scoped></style>
