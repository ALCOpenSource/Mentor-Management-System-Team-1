<template>
  <div>
    <div class="flex justify-between items-center">
      <h1 class="font-semibold text-xl 2xl:text-2xl">Program Reports</h1>
      <div class="flex items-center gap-3">
        <Pagination @fetchPage="handlePagination" :pagination="userStore.pagination"/>
        <Filter class="cursor-pointer" />
        <router-link :to="{ name: 'program', params: { id: route.params.id } }">
          <Close class="cursor-pointer" />
        </router-link>
      </div>
    </div>
    <div class="mt-5 mb-5">
      <div
        v-for="(item, index) in getNumberToDisplay()"
        :key="item"
        class="mb-3"
      >
        <div class="card">
          <div class="flex items-center justify-between py-[10px] px-[20px]">
            <div class="flex items-center">
              <Reports />
              <div class="flex flex-col ml-5">
                <h1 class="font-semibold text-lg 2xl:text-xl text-[#333333]">
                  Google Africa Scholarship Program
                </h1>
                <div class="flex justify-between">
                  <p class="text-xs text-[#808080]">
                    By Ibrahim Kabir - 19th - 25th Oct 22
                  </p>
                </div>
              </div>
            </div>
            <div class="flex gap-5 items-center">
              <Download class="cursor-pointer" />
              <ShareAlt class="cursor-pointer" />
              <v-icon
                v-if="!showDetails?.show || showDetails?.index !== index"
                @click="toggleShowDetails(index)"
              >
                <IconArrowDown class="cursor-pointer" />
              </v-icon>
              <v-icon v-else @click="toggleShowDetails(index)">
                <IconArrowUp class="cursor-pointer" />
              </v-icon>
            </div>
          </div>
          <v-expand-transition>
            <div
              v-if="showDetails?.show && showDetails?.index === index"
              class="bg-green-100 py-[10px] px-[20px]"
            >
              <h3 class="text-sm">Some contenddjddt</h3>
            </div>
          </v-expand-transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineComponent } from "vue";
import { useRoute } from "vue-router";
import {
  Close,
  Filter,
  Reports,
  IconArrowDown,
  IconArrowUp,
  ShareAlt,
  Download,
} from "@/assets/icons";
import Pagination from "@/components/Common/Pagination.vue";
import { useUserStore } from "@/store/user";

const userStore = useUserStore();
const route = useRoute();
const showDetails = ref<ShowDetails>();

const getNumberToDisplay = () => {
  const height = window.innerHeight - window.innerHeight * 0.3;
  const cardHeight = 75;
  const numberToDisplay = Math.floor(height / cardHeight);
  return numberToDisplay;
};

const toggleShowDetails = (index: number) => {
  if (showDetails.value?.show && showDetails.value?.index === index) {
    showDetails.value = { show: false, index: -1 };
  } else {
    showDetails.value = { show: true, index };
  }
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

interface ShowDetails {
  index: number;
  show: boolean;
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

<style scoped lang="scss">
.card {
  display: flex;
  flex-direction: column;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;

  &:hover {
    background-color: var(--light-grid-background);
  }
}
</style>
