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
// src="userStore.avatar?.avatar_url || 'https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png'"
<template>
  <img
    class="avatar" 
    :src="imageLink || 'https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png'"
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
