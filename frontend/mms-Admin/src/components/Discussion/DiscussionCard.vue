<template>
  <div class="discussion">
    <div class="flex justify-between mb-3">
      <div class="flex gap-3">
        <img
          class="avatar"
          src="https://blog.readyplayer.me/content/images/2021/04/IMG_0689.PNG"
          alt="avatar"
        />
        <div>
          <h1 class="font-semibold text-xl">Allison Davies</h1>
          <p class="text-xs text-[#808080]">Mentor Manager</p>
        </div>
      </div>

      <v-menu persistent>
        <template v-slot:activator="{ props }">
          <MoreIcon id="menu-activator" class="cursor-pointer" v-bind="props" />
        </template>
        <div class="bg-[#e6fdfe] rounded p-2">
          <p class="cursor-pointer" @click="updateModal">Update Topic</p>
        </div>
      </v-menu>
    </div>
    <div class="mb-4">
      <h1 class="text-xl text-[#333333] mb-2">
        The New MMS Discussion Forum Guidelines and Regulations
      </h1>
      <p class="text-[#808080]">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis
        molestie, dictum est a, mattis tellus. Sed dignissim, metus nec
        fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus
        elit sed risus. Maecenas eget condimentum velit, sit amet feugiat
        lectus. Class aptent taciti sociosqu ad litora torquent per conubia
        nostra, per inceptos himenaeos. Praesent auctor purus luctus enilf.
      </p>
    </div>
    <div class="flex justify-between items-center">
      <div class="flex gap-6 items-center">
        <router-link :to="{ name: 'comments', params: { id: props.id } }"
          ><Comment class="cursor-pointer"
        /></router-link>
        <Bookmark class="cursor-pointer" />
        <Share class="cursor-pointer" />
      </div>
      <div class="flex gap-1 items-center">
        <IconTime />
        <p class="text-xs text-[#808080]">5h ago</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { MoreIcon, IconTime, Share, Comment, Bookmark } from "@/assets/icons";
const emit = defineEmits(["updateModal"]);

const props = defineProps<{
  id: string;
}>();

const updateModal = () => {
  emit("updateModal");
};
</script>

<style scoped lang="scss">
.discussion {
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 15px;
  padding-bottom: 10px;
  margin-bottom: 20px;

  .avatar {
    width: 45px;
    border-radius: 50%;
    height: 45px;
  }
}
</style>
