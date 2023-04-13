<template>
  <ul>
    <li
      v-for="item in list"
      :key="item"
      :class="{
        active: active === item,
      }"
    >
      <router-link :to="`/settings/${item.toLowerCase()}`" class="block py-2">
        {{ item }}
      </router-link>
    </li>
  </ul>
</template>

<script setup lang="ts">
import {computed} from "vue";
import {useRoute} from "vue-router";

const route = useRoute();
const list = [
  "General",
  "Password",
  "Notifications",
  "Privacy",
  "Archive",
  "Support",
  "FAQ",
];

const active = computed(() => {
  return list.find((item) => route.path === `/settings/${item.toLowerCase()}`);
});
</script>

<style scoped lang="scss">
ul {
  border: 1px solid var(--card-light);
  color: var(--text-inactive);
  text-align: center;
  width: 230px;
  height: 290px;
  border-radius: 5px;

  li {
    border-bottom: 1px solid var(--card-light);
    background-color: var(--light-grid-background);
    &:last-child {
      border-bottom: none;
    }
    &.active {
      background-color: #fff;
      color: #333;
      font-weight: 600;
    }

    &:hover {
      background-color: #fff;
      color: #333;
      font-weight: 600;
    }
  }
}
</style>
