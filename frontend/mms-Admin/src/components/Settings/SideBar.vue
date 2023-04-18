<template>
  <ul>
    <router-link
      v-for="item in list"
      :key="item"
      :to="`/admin/settings/${item.toLowerCase()}`"
      active-class="active"
    >
      <li class="block py-2">
        {{ item }}
      </li>
    </router-link>
  </ul>
</template>

<script setup lang="ts">
const list = [
  "General",
  "Password",
  "Notifications",
  "Privacy",
  "Archive",
  "Support",
  "FAQ",
];
</script>

<style scoped lang="scss">
ul {
  border: 1px solid var(--card-light);
  color: var(--text-inactive);
  text-align: center;
  min-width: 230px;
  height: 282px;
  border-radius: 5px;

  li {
    border-bottom: 1px solid var(--card-light);
    background-color: var(--light-grid-background);
    &:last-child {
      border-bottom: none;
    }
    &:hover {
      background-color: #fff;
      color: #333;
      font-weight: 600;
    }
  }
}
.active {
  background-color: #fff;
  color: #333;
  font-weight: 600;

  li {
    background-color: #fff;
    color: #333;
    font-weight: 600;
  }
}
</style>
