<template>
  <div>
    <h1 class="font-semibold text-xl 2xl:text-2xl">Search Results</h1>
    <div class="flex justify-between items-center mt-3 mb-3">
      <div>
        <PlainDropdown :options="options" title="All" />
      </div>
      <div>
        <Pagination />
      </div>
    </div>
    <div>
      <UserCard />
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import PlainDropdown from "@/components/Common/PlainDropdown.vue";
import Pagination from "@/components/Common/Pagination.vue";
import UserCard from "@/components/Common/UserCard.vue";

const route = useRoute();
const search = route.params.search;

const options = [{ text: "Read" }, { text: "Unread" }];
onMounted(() => {
  // Search for the value in the database
});
</script>

<style scoped></style>
