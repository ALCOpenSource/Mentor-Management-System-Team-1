<template>
  <v-menu activator="parent" transition="slide-y-transition">
    <template v-slot:activator="{ props }">
      <div class="flex items-center gap-2" :="props">
        <h1 class="font-semibold">{{ title }}</h1>
        <Dropdown />
      </div>
    </template>
    <div class="w-40 absolute">
      <v-list>
        <v-list-item
          v-for="(option, index) in options"
          :key="index"
          :value="index"
        >
          <v-list-item-title>{{ option.text }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </div>
  </v-menu>
</template>

<script setup lang="ts">
import { Dropdown } from "@/assets/icons";

defineProps<DropdownProps>();

interface DropdownProps {
  options: Option[];
  title: string;
}
interface Option {
  text: string;
}
</script>

<style scoped></style>
