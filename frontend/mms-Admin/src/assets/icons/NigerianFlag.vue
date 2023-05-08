<template>
  <img :src="userStore.user?.flag" width="30" height="30" :alt="userStore.user?.country + 'flag'" />
</template>

<script setup lang="ts">
import {useUserStore} from "../../store/user"

const userStore = useUserStore();
</script>