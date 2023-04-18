<script lang="ts">
import { defineComponent } from "vue";
import { placeholderImg } from "../../assets/images";
export default defineComponent({
  props: {
    imageLink: String,
  },
});
</script>

<template>
  <img
    class="avatar"
    :src="
      placeholderImg ||
      'https://blog.readyplayer.me/content/images/2021/04/IMG_0689.PNG'
    "
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
