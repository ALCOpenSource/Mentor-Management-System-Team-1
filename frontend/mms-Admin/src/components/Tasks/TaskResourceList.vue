<template>
  <div class="w-7/12 pl-4 flex gap-6 flex-col">
    <section class="flex items-center gap-4 justify-end">
      <IconSearch color="#058B94" />
      <IconFilter />
      <IconCancel />
    </section>
    <section>
      <MentorResource />
    </section>
  </div>
</template>

<script setup lang="ts">
import IconSearch from "../Icons/IconSearch.vue";
import IconFilter from "../Icons/IconFilter.vue";
import { IconCancel } from "../Icons";
import MentorResource from "./MentorResource.vue";
</script>
