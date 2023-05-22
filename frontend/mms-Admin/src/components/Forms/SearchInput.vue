<template>
  <div class="w-2/4 relative">
    <span class="search_icon absolute top-[10px] left-4">
      <IconSearch color="#808080" />
    </span>
    <form @submit.prevent="(e: Event)=>handleSubmit(e)">
      <input
        v-model="searchValue"
        class="p-4 py-2 pl-12 text-xl bg-white rounded-md w-full focus:outline-[#058b94]"
        type="text"
        placeholder="Search for anything"
      />
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { IconSearch } from "../Icons";
import { useRouter } from "vue-router";

const router = useRouter();

const searchValue = ref("");

const handleSubmit = (e: Event) => {
  router.push({
    name: "search-results",
    params: { search: searchValue.value },
  });
};
</script>

<style></style>
