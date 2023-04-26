<script setup lang="ts">
import {useAuthStore} from "../../store/auth"

const authStore = useAuthStore();
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
    :src="authStore.authUser?.avatar || 'https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png'"
    alt=""
    srcset=""
  />
</template>

<style>
.avatar {
  width: 55px;
  border-radius: 50%;
  height: auto;
  cursor: pointer;
}
</style>
