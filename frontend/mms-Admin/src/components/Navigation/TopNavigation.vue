<template>
  <nav>
    <Logo />
    <section class="nav_links flex items-center w-3/4 justify-end gap-8">
      <SearchInput />
      <Navlinks />
    </section>
  </nav>
</template>

<script setup lang="ts">
import SearchInput from "../Forms/SearchInput.vue";
import Logo from "./Logo.vue";
import Navlinks from "./Navlinks.vue";
</script>

<style scoped>
nav {
  background-color: var(--btn-primary);
  padding: 1.2rem;
  padding-left: 55px;
  padding-right: 55px;
  align-items: center;
  display: flex;
  justify-content: space-between;
}
</style>
