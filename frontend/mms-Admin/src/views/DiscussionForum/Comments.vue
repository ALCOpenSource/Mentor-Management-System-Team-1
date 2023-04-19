<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="font-semibold text-2xl">Comments</h1>
      <router-link to="/admin/discussion-forum/discussions"
        ><PrimaryBtn title="Close"
      /></router-link>
    </div>
    <DiscussionCard id="3" />
    <div class="comment mt-10 mb-5">
      <textarea
        v-model="commentInput"
        @input="autoresize"
        placeholder="Write a comment..."
      ></textarea>
      <div class="w-full flex items-center justify-between picker">
        <div class="flex gap-1">
          <Smiley class="mr-3 cursor-pointer" @click="toggle" />
          <UploadFile class="mr-4" @upload="getFile" />
          <Picker
            v-if="emojiPickerSelected"
            :data="emojiIndex"
            title="Pick your emoji…"
            emoji="point_up"
            @select="convertEmoji"
          />
        </div>
        <SmallPrimaryBtn title="Post Comment" />
      </div>
      <small class="text-xs text-[#058b94] m-0 p-0">{{ file }}</small>
    </div>
    <div class="comment-wrapper">
      <div class="comment mb-4">
        <div class="flex justify-between items-center">
          <h1 class="font-semibold">Ibrahim Kekule</h1>
          <MoreIcon class="cursor-pointer" />
        </div>
        <p class="text-xs text-[#808080]">
          Found this so insightful. please how can i register to be a part of
          the program?
        </p>
        <div class="flex justify-end">
          <p class="text-xs text-[#808080]">Just now</p>
        </div>
      </div>
      <div class="comment mb-4">
        <div class="flex justify-between items-center">
          <h1 class="font-semibold">Sarah Tasha</h1>
          <MoreIcon class="cursor-pointer" />
        </div>
        <p class="text-xs text-[#808080]">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu
          turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec
          fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus
          elit sed risus. Maecenas eget condimentum velit, sit amet feugiat
          lectus. Class aptent taciti sociosqu ad litora torquent per conubia
          nostra, per inceptos himenaeos. Praesent auctor purus luctus enilf.
        </p>
        <div class="flex justify-end">
          <p class="text-xs text-[#808080]">2h ago</p>
        </div>
      </div>
      <div class="comment mb-3">
        <div class="flex justify-between items-center">
          <h1 class="font-semibold">Ibrahim Kekule</h1>
          <MoreIcon class="cursor-pointer" />
        </div>
        <p class="text-xs text-[#808080]">
          Found this so insightful. please how can i register to be a part of
          the program?
        </p>
        <div class="flex justify-end">
          <p class="text-xs text-[#808080]">3h ago</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
import DiscussionCard from "@/components/Discussion/DiscussionCard.vue";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast/src";
import data from "emoji-mart-vue-fast/data/all.json";
import UploadFile from "@/components/Messages/UploadFile.vue";
import { Smiley, MoreIcon } from "@/assets/icons";

const emojiPickerSelected = ref(false);
let emojiIndex = new EmojiIndex(data);
const toggle = () => {
  emojiPickerSelected.value = !emojiPickerSelected.value;
};

const commentInput = ref("");
const file = ref("");

const convertEmoji = (emoji: any) => {
  commentInput.value += emoji.native;
};

const getFile = (files: any) => {
  // Do something with the file
  file.value = files.name;
};

const autoresize = () => {
  const textarea = document.querySelector("textarea");
  textarea?.setAttribute("style", "height: auto; padding: 0");
  textarea?.setAttribute("style", "height:" + textarea?.scrollHeight + "px");
};
</script>

<style scoped lang="scss">
.comment {
  background-color: var(--light-grid-background);
  padding: 15px;
  border-radius: 5px;
  border: 1px solid var(--card-light);
}

.comment-wrapper {
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 20px;
}

textarea {
  width: 100%;
  border: none;
  resize: none;

  &:focus {
    outline: none;
  }
}
</style>
