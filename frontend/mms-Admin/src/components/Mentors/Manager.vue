<template>
  <div>
    <div class="flex justify-between items-center mb-3">
      <div>
        <PlainDropdown :options="options" title="All Mentors Assigned" />
      </div>
      <SearchBox placeholder="Search for Mentors" />
    </div>
    <div class="archive-card">
      <div class="mb-3" v-for="n in 10" :key="n">
        <UserCard is-mentor />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import UserCard from "../Common/UserCard.vue";
import SearchBox from "../Common/SearchBox.vue";
import PlainDropdown from "../Common/PlainDropdown.vue";

const options = [
  { text: "This Week" },
  { text: "This Month" },
  { text: "This Year" },
];
</script>

<style scoped lang="scss">
.archive-card {
  height: 56vh;
  overflow-y: scroll;
  padding-right: 0.5rem;
  padding-bottom: 3rem;

  &::-webkit-scrollbar {
    width: 5px;
    transition: all 0.5s ease-in-out;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: #06b9c6;
    border-radius: 50px;
  }
}
</style>
