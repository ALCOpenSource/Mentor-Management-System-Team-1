<script setup lang="ts">
import {useUserStore} from "../../store/user"

const userStore = useUserStore();
</script>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
  props: {
    imageLink: String,
  },
});
</script>

<template>
  <img
    class="avatar"
    :src="userStore.avatar?.avatar_url"
    alt=""
    srcset=""
  />
</template>

<style>
.avatar {
  width: 55px;
  border-radius: 50%;
  height: auto;
}
</style>
