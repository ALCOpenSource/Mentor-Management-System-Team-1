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
          <ChatCard v-for="item in 10" :key="item" />
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
            <div v-for="message in msgData[0].messages" :key="msgData[0].id">
              <div
                class="w-full flex gap-8 justify-start mb-4"
                v-if="message.rec"
              >
                <img
                  class="avatar"
                  src="https://blog.readyplayer.me/content/images/2021/04/IMG_0689.PNG"
                  alt="avatar"
                />
                <div class="received">
                  <h1>{{ message.msg }}</h1>
                  <small>{{ message.time }}</small>
                </div>
              </div>
              <div class="w-full flex justify-end mb-4" v-if="message.sent">
                <div class="sent">
                  <h1>{{ message.msg }}</h1>
                  <div class="flex justify-between items-center">
                    <small>{{ message.time }}</small>
                    <Tick v-if="message.status === 'Sent'" />
                    <DoubleTick v-if="message.status === 'Delivered'" />
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

const noMesage = ref(false);

const emojiPickerSelected = ref(false);
let emojiIndex = new EmojiIndex(data);
const toggle = () => {
  emojiPickerSelected.value = !emojiPickerSelected.value;
};

const chatInput = ref("");
const file = ref("");

const convertEmoji = (emoji: any) => {
  chatInput.value += emoji.native;
};

const getFile = (files: any) => {
  // Do something with the file
  file.value = files.name;
};

// Test Data
const msgData = [
  {
    id: 1,
    name: "Kabiru",
    avatar: "https://blog.readyplayer.me/content/images/2021/04/IMG_0689.PNG",
    messages: [
      {
        rec: true,
        sent: false,
        msg: "Hello Perculiar",
        time: "5:59 PM",
      },
      {
        rec: false,
        sent: true,
        msg: "Hello Kabiru, trust you are well?",
        time: "6:00 PM",
        status: "Delivered",
      },
      {
        rec: false,
        sent: true,
        msg: "I need to check up on you",
        time: "6:00 PM",
        status: "Sent",
      },
      {
        rec: true,
        sent: false,
        msg: "I need to check up on you?",
        time: "6:10 PM",
      },
      {
        rec: false,
        sent: true,
        msg: "Yes, I needed to check up on you, is that a problem",
        time: "6:12 PM",
        status: "Sent",
      },
      {
        rec: true,
        sent: false,
        msg: "No, I just wasn't expecting it, that's all",
        time: "6:13 PM",
      },
    ],
  },
];

onMounted(() => {
  const scrolldown = document.getElementById("scrolldown");
  scrolldown?.scrollIntoView();
});
</script>

<style scoped lang="scss">
.chats-col {
  min-width: 320px;
  height: 70vh;
  overflow-y: scroll;

  &:hover::-webkit-scrollbar {
    display: block;
  }

  &::-webkit-scrollbar {
    display: none;
    width: 5px;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: var(--btn-primary);
    height: 40px;
    border-radius: 50px;
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
