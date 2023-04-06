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
import { ref } from "vue";

defineEmits(["update:email"]);

const email = ref("");
const emailRules = [
  (v: string) => !!v || "Email is required",
  (v: string) => /.+@.+\..+/.test(v) || "Email must be valid",
];
</script>

<style scoped></style>
