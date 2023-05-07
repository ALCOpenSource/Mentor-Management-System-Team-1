<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold">Settings</h1>
      <div class="flex" v-if="route.path == archiveRoute">
        <div class="w-[346px] relative mr-5">
          <span class="search_icon absolute top-[10px] left-4">
            <IconSearch />
          </span>
          <input
            class="p-4 py-2 pl-12 border bg-white rounded-md w-full focus:outline-[#058b94] placeholder:text-[16px]"
            type="text"
            placeholder="Search for anything"
          />
        </div>
        <Pagination />
      </div>
    </div>
    <div class="flex gap-8">
      <SideBar />
      <div class="w-full flex flex-col">
        <div class="card">
          <router-view></router-view>
        </div>
        <div class="self-end" v-if="route.path == supportRoute">
          <ChatBot />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from "vue-router";
import SideBar from "../components/Settings/SideBar.vue";
import Pagination from "@/components/Common/Pagination.vue";
import { IconSearch } from "@/assets/icons";
import ChatBot from "@/components/Settings/ChatBot.vue";

const route = useRoute();
const archiveRoute = "/admin/settings/archive";
const supportRoute = "/admin/settings/support";
</script>

<style scoped>
.card {
  border: 1.7px solid var(--border);
  border-radius: 10px;
  box-shadow: 0px 5px 5px rgba(241, 241, 241, 0.25);
  margin-bottom: 3rem;
  width: 100%;
  padding: 20px;
}
</style>
