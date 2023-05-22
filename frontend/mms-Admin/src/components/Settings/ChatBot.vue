<template>
  <div class="chat">
    <div class="chatbot" @click="toggleChat">
      <Comment />
    </div>
    <v-expand-transition>
      <div class="live-chat" v-if="showChat">
        <div class="header">
          <div class="flex justify-between items-center">
            <div
              class="rounded-full bg-[#fff] p-1 flex justify-center items-center"
            >
              <img :src="appLogo" alt="logo" />
            </div>
            <div class="close" @click="toggleChat">
              <Close color="#fff" />
            </div>
          </div>

          <h1 class="text-white text-2xl font-bold mt-3 mb-2">MMS Support</h1>
          <p class="text-white">
            A live chat interface that allows for seamless, natural
            communication and connection.
          </p>
        </div>
        <div class="chat-area">
          <div v-for="message in msgData[0].messages" :key="msgData[0].id">
            <div
              class="w-full flex gap-3 justify-start mb-6"
              v-if="message.rec"
            >
              <img
                class="avatar"
                src="https://blog.readyplayer.me/content/images/2021/04/IMG_0689.PNG"
                alt="avatar"
              />
              <div class="received">
                <h1 class="text-base font-semibold">Assistant</h1>
                <h2>{{ message.msg }}</h2>
                <small class="flex justify-end">{{ message.time }}</small>
              </div>
            </div>
            <div class="w-full flex justify-end mb-6" v-if="message.sent">
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
          <div id="scrolldown2"></div>
        </div>
        <div class="bottom">
          <Smiley class="cursor-pointer" />
          <input type="text" placeholder="Reply ..." />
          <Photo class="cursor-pointer" />
          <SendChat class="cursor-pointer" />
        </div>
      </div>
    </v-expand-transition>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import {
  Close,
  Comment,
  Smiley,
  Photo,
  SendChat,
  Tick,
  DoubleTick,
} from "@/assets/icons";
import { appLogo } from "../../assets/images";

const showChat = ref(false);
const toggleChat = () => {
  showChat.value = !showChat.value;
  if (showChat.value) {
    setTimeout(() => {
      const scrolldown = document.getElementById("scrolldown2");
      scrolldown?.scrollIntoView({ behavior: "smooth" });
    }, 100);
  }
};

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
</script>

<style scoped lang="scss">
.chat {
  position: relative;
}
.chatbot {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  background-color: var(--card-light);
  width: 66px;
  height: 66px;
  cursor: pointer;
  box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.25);
}
.live-chat {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 450px;
  height: 80vh;
  background-color: #fff;
  filter: drop-shadow(0px 30px 60px rgba(70, 41, 242, 0.14));
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  .header {
    width: 100%;
    height: 32%;
    background: rgb(67, 159, 167);
    background: linear-gradient(
      51deg,
      rgba(67, 159, 167, 0.9866071428571429) 12%,
      rgba(21, 85, 89, 1) 52%,
      rgba(0, 212, 255, 1) 100%
    );
    backdrop-filter: blur(24px);
    border-radius: 10px 10px 0 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 20px;

    img {
      width: 50px;
      height: 52px;
      margin-left: 4px;
    }

    .close {
      cursor: pointer;
      background: rgba($color: #fff, $alpha: 0.2);
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  }

  .chat-area {
    width: 100%;
    height: 58%;
    padding: 20px;
    overflow-y: auto;

    &::-webkit-scrollbar {
      display: none;
    }

    small {
      color: #919090;
      font-size: 14px;
    }

    .sent {
      max-width: 75%;

      h1 {
        background-color: var(--btn-primary);
        color: #fff;
        padding: 10px 15px;
        border-radius: 10px 0px 10px 10px;
        font-size: 16px;
        font-weight: 400;
      }
    }

    .received {
      max-width: 75%;

      h2 {
        background-color: #f1f7ff;
        color: #000;
        padding: 10px 15px;
        border-radius: 0px 10px 10px 10px;
        font-size: 16px;
        font-weight: 400;
      }
    }

    .avatar {
      width: 40px;
      border-radius: 50%;
      height: 40px;
    }
  }

  .bottom {
    width: 100%;
    height: 10%;
    background-color: #fff;
    border-top: 1px solid var(--border);
    border-radius: 0 0 10px 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 20px;

    input {
      padding: 8px 10px;
      width: 100%;
      border-radius: 5px;

      &:focus {
        outline: 1.8px solid var(--btn-primary);
      }
    }
  }
}
</style>
