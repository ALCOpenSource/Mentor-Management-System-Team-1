<template>
  <div class="inline-flex">
    <v-menu activator="parent" transition="slide-y-transition">
      <template v-slot:activator="{ props }">
        <DropdownButton text="This Week" :="props" />
      </template>
      <div class="w-40 -right-1 absolute">
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
  </div>
</template>

<script setup lang="ts">
import DropdownButton from "./DropdownButton.vue";

type Props = {
  options?: Object[];
};

defineProps<Props>();
</script>
