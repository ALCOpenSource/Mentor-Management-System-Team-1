<template>
  <v-text-field
    v-model="email"
    variant="solo"
    placeholder="Email"
    required
    :rules="emailRules"
    @input="$emit('update:email', email)"
  >
  </v-text-field>
</template>

<script setup lang="ts">
import {ref} from "vue";

defineEmits(["update:email"]);

const email = ref("");
const emailRules = [
  (value: string) => Boolean(value) || "Email is required",
  (value: string) => /.+@.+\..+/.test(value) || "Email must be valid",
];
</script>

<style scoped></style>
