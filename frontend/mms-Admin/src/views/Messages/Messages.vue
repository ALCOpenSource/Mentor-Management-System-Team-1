<template>
  <div>
    <div class="w-full h-[78vh] flex flex-col justify-center items-center border rounded-md" v-if="noMesage">
      <NoMessage />
      <h1 class="text-xl mt-5 mb-2">No messages yet</h1>
      <p class="text-[#808080]">No messages in your chatbox, yet. Start chatting with other users</p>
      <router-link to="/admin/messages/select-someone"><PrimaryBtn title="Browse People" class="mt-12" /></router-link>
    </div>
    <div v-else>
      <div class="flex justify-between items-center">
        <div class="flex w-[320px] justify-between items-center">
          <h1 class="font-semibold text-2xl">Chats</h1>
          <IconSearch color="#058B94" size="20" class="cursor-pointer" />
        </div>
        <router-link to="/admin/messages/broadcast">
          <PrimaryBtn title="Send Broadcast Message" />
        </router-link>
      </div>
      <div class="mt-4 flex gap-5 justify-between">
        <div class="chats-col">
          <ChatCard v-for="thread in messageStore.threads.data" :key="thread" :thread="thread" @openChat="loadMessage"/>
        </div>
        <div class="chat-col">
          <div class="flex justify-between items-center text-[#058B94]">
            <span class="bo border-b-2 w-full"></span>
            <small class="px-1 whitespace-nowrap"
              >Conversation Started, 15 Oct</small
            >
            <span class="bo border-b-2 w-full"></span>
          </div>
          <div class="chat-area">
            <div v-for="message in messageStore.thread.data" :key="message">
              <div
                class="w-full flex gap-8 justify-start mb-4"
                v-if="message.sender_id !== userStore.user.id"
              >
                <img
                  class="avatar"
                  :src="message.sender.avatar_url"
                  alt="avatar"
                />
                <div class="received">
                  <h1>{{ message.message }}</h1>
                  <small>{{ message.human_date }}</small>
                  <div v-if="message.attachments && message.attachments.length > 0">
                      <div v-for="attachment in message.attachments" :key="attachment">
                        <template v-if="attachment.type === 'image'">
                          <img :src="attachment.url" alt="attachment" />
                          <p>{{ attachment.name }}</p>
                          <p>{{ calculateFileSize(attachment.size) }}</p>
                        </template>
                        <template v-else>
                          <a :href="attachment.url" target="_blank"></a>
                          <p>{{ attachment.name }}</p>
                          <p>{{ calculateFileSize(attachment.size) }}</p>
                        </template>
                    </div>
                  </div>
                </div>
              </div>
              <div class="w-full flex justify-end mb-4" v-else>
                <div class="sent">
                  <h1>{{ message.message }}</h1>
                  <div class="flex justify-between items-center">
                    <small>{{ message.human_date }}</small>
                    <Tick v-if="message.status === 'unread'" />
                    <DoubleTick v-if="message.status === 'read'" />
                  </div>
                  <div v-if="message.attachments.length > 0">
                      <div v-for="attachment in message.attachments" :key="attachment">
                        <template v-if="attachment.type === 'image'">
                          <img :src="attachment.url" alt="attachment" />
                          <p>{{ attachment.name }}</p>
                          <p>{{ calculateFileSize(attachment.size) }}</p>
                        </template>
                        <template v-else>
                          <a :href="attachment.url" target="_blank"></a>
                          <p>{{ attachment.name }}</p>
                          <p>{{ calculateFileSize(attachment.size) }}</p>
                        </template>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div id="scrolldown"></div>
          </div>
          <div class="mt-4 w-full flex items-center picker">
            <Smiley class="mr-3 cursor-pointer" @click="toggle" />
            <UploadFile class="mr-4" @upload="getFile" />
            <input
              class="bg-white rounded-md w-full pl-6 py-2 focus:outline-[#058b94] placeholder:text-[#808080]"
              type="text"
              placeholder="|   Type a message..."
              v-model="chatInput"
              @keyup.enter="sendMessage"
            />
            <Picker
              v-if="emojiPickerSelected"
              :data="emojiIndex"
              title="Pick your emoji…"
              emoji="point_up"
              @select="convertEmoji"
            />
          </div>
          <small class="text-xs text-[#058b94] m-0 p-0">{{ file }}</small>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import { IconSearch } from "@/components/Icons";
import { Tick, DoubleTick, Smiley, NoMessage } from "@/assets/icons";
import ChatCard from "@/components/Messages/ChatCard.vue";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast/src";
import data from "emoji-mart-vue-fast/data/all.json";
import UploadFile from "@/components/Messages/UploadFile.vue";
import {useMessageStore} from "../../store/message"
import {useUserStore} from "../../store/user"

const userStore = useUserStore();

const messageStore = useMessageStore();
const noMesage = ref(false);

const emojiPickerSelected = ref(false);
let emojiIndex = new EmojiIndex(data);
const toggle = () => {
  emojiPickerSelected.value = !emojiPickerSelected.value;
};


const chatInput = ref("");

const convertEmoji = (emoji: any) => {
  chatInput.value += emoji.native;
};
const attachments: any[] = [];
const getFile = (files: any) => {
  // Do something with the file
  attachments.push(files);
};

const  calculateFileSize = (size: any) => {
    if(size < 1024) {
        return `${size} B`;
    } else if(size < 1024 * 1024) {
        return `${(size / 1024).toFixed(2)} KB`;
    } else if(size < 1024 * 1024 * 1024) {
        return `${(size / (1024 * 1024)).toFixed(2)} MB`;
    } else {
        return `${(size / (1024 * 1024 * 1024)).toFixed(2)} GB`;
    }
}
const loadMessage = (roomid: string, receiver_id: string, uuid: string, unread: number) => {
  messageStore.loadThread(roomid, receiver_id).then(() => {
      const scrolldown = document.getElementById("scrolldown");
      scrolldown?.scrollIntoView();
      if(unread !== 0) {
        messageStore.markAsRead(uuid);
      }
  });
}

const sendMessage = () => {
  // Create form data
    let formData = new FormData();
    formData.append('message', chatInput.value);
    formData.append('receiver_id', messageStore.receiver_id);

    // Append attachments
    attachments.forEach((file) => {
        formData.append('attachments[]', file);
    });

    messageStore.sendMessage(formData).then(() => {
      const scrolldown = document.getElementById("scrolldown");
      scrolldown?.scrollIntoView();

      chatInput.value = '';
    });
}

onMounted(() => {
  const scrolldown = document.getElementById("scrolldown");
  scrolldown?.scrollIntoView();
});
</script>

<script lang="ts">

import { defineComponent } from 'vue'

export default defineComponent({
  
  beforeRouteEnter(to, from, next) {
    const messageStore = useMessageStore();
    let roomid = '';
    let receiver_id = '';
    let uuid = '';
    let unread = 0;
    const thread = (()  => {
       const thread = messageStore?.threads?.data[0];
      roomid = thread.room_id;
      receiver_id = thread.receiver_id;
      uuid = thread.uuid;
      unread = thread.unread;

      // Exit the loop after the first iteration
      return;
    });

    if (messageStore.threads) {
      // The authentication state is already loaded, so proceed to the dashboard
      thread();
      messageStore.loadThread(roomid, receiver_id);
      next()
    } else {
      // The authentication state is not loaded yet, so wait for it before proceeding
      messageStore.loadThreads().then(() => {
        thread();
        return messageStore.loadThread(roomid, receiver_id);
      }).then(() => {
        if(unread !== 0) {
          messageStore.markAsRead(uuid);
        }
        next()
      })
    }
  },
})
</script>

<style scoped lang="scss">
.chats-col {
  min-width: 329px;
  height: 70vh;
  overflow-y: scroll;
  padding-right: 5px;

  &::-webkit-scrollbar {
    width: 5px;
    transition: all 0.5s ease-in-out;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: transparent;
    border-radius: 50px;
  }

  &:hover::-webkit-scrollbar-thumb {
    background: var(--btn-primary);
  }
}

.chat-col {
  width: 100%;
  height: 70vh;
  background-color: var(--light-grid-background);
  border-radius: 20px;
  border: 1px solid var(--card-light);
  padding: 25px 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  .chat-area {
    margin-top: 5px;
    height: 100%;
    overflow-y: scroll;
    color: #141414;

    &::-webkit-scrollbar {
      display: none;
    }

    small {
      color: var(#4d4d4d);
    }

    .sent {
      background-color: white;
      min-width: 308px;
      max-width: 500px;
      border-radius: 10px;
      border: 1px solid var(--card-light);
      display: flex;
      flex-direction: column;
      padding: 15px 20px;
      justify-content: space-between;
      min-height: 88px;
    }

    .received {
      background-color: var(--card-light);
      min-width: 308px;
      max-width: 500px;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      padding: 15px 20px;
      justify-content: space-between;
      min-height: 88px;
    }
  }
}

.avatar {
  width: 45px;
  border-radius: 50%;
  height: 45px;
}
</style>
