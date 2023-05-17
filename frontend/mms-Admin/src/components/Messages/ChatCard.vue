<template>
  <div class="card" @click="openChat(thread.room_id, thread.receiver_id)">
    <div class="flex gap-3 items-center">
      <UserAvatar :imageLink="thread.user.avatar_url"/>
      <div>
        <h1 class="text-md font-semibold">{{ thread.user.name }}</h1>
        <p class="text-xs">{{ thread.preview }}</p>
      </div>
    </div>
    <div class="flex flex-col items-center justify-center">
      <p>{{ thread.human_date }}</p>
      <small v-if="thread.unread !== 0"
        class="flex justify-center items-center bg-[#FF5964] text-white rounded w-[15px] h-[15px]"
        >{{ thread.unread}}</small
      >
    </div>
  </div>
</template>

<script setup lang="ts">
import UserAvatar from "../Common/UserAvatar.vue";
import {onMounted} from "vue";

const emit = defineEmits(["openChat"]);

const props = defineProps<{
  thread?: Object;
}>();
const thread = props.thread;

const openChat = (roomid: string, receiver_id: string) => {
  emit("openChat", roomid, receiver_id); 
};
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 15px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;
  margin-bottom: 10px;
  cursor: pointer;

  &:hover {
    background-color: var(--light-grid-background);
  }

  &.active {
    background-color: var(--light-grid-background);
    border: none !important;
  }
}
</style>
