<template>
  <div>
    <div class="flex justify-between items-center">
      <div>
        <h1 class="font-semibold text-2xl">Broadcast Message</h1>
      </div>
      <router-link to="/admin/messages/inbox">
        <PrimaryBtn title="Close" />
      </router-link>
    </div>
    <div class="broadcast-select">
      <v-expansion-panels variant="inset">
        <v-expansion-panel>
          <v-expansion-panel-title>
            <h1>
              Select recepient<span v-if="isSelected.length > 0">: </span>
              <span
                v-for="item in isSelected"
                :key="item"
                v-if="isSelected.length > 0"
                >{{ item }},
              </span>
            </h1>
            <template v-slot:actions="{ expanded }">
              <v-icon v-if="!expanded"><IconArrowDown /></v-icon>
              <v-icon v-else><IconArrowUp /></v-icon>
            </template>
          </v-expansion-panel-title>
          <v-expansion-panel-text>
            <ul>
              <li
                v-for="user in userStore.users" :key="user.id"
                @click="setSelected(user.id)"
              >
                {{ user.name }}
              </li>
            </ul>
          </v-expansion-panel-text>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
    <div class="msg-area">
      <div
        class="flex flex-col items-center center mb-5"
        v-for="message in messageStore.broadcast.data"
        :key="message"
      >
        <small class="smallD bg-white p-1 px-2 rounded">{{message.human_date}}</small>
        <div class="broadcast-card">
          <p class="text-[#4D4D4D] text-xl">
            {{message.message}}
          </p>
          <div class="flex justify-between items-center mt-3">
            <h3 class="font-semibold underline">{{ message }}</h3>
            <div class="flex items-center">
              <small class="text-[#4D4D4D] mr-2">{{ message.human_date }}</small>
              <DoubleTick v-if="message.status === 'read'" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full flex items-center mt-6 picker">
      <Smiley class="mr-3 cursor-pointer" @click="toggle" />
      <UploadFile class="mr-4" @upload="getFile" />
      <input
        class="bg-[#f7feff] border rounded-md w-full pl-6 py-2 focus:outline-[#058b94] placeholder:text-[#808080]"
        type="text"
        rows="1"
        placeholder="|   Type a message..."
        v-model="broadcastInput"
        @keyup.enter="broadcastMessage"
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
</template>

<script setup lang="ts">
import { ref } from "vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import { IconArrowDown, IconArrowUp, Smiley, DoubleTick } from "@/assets/icons";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast/src";
import data from "emoji-mart-vue-fast/data/all.json";
import UploadFile from "@/components/Messages/UploadFile.vue";
import { useUserStore } from "@/store/user"
import { useMessageStore } from "@/store/message"
import { defineComponent } from 'vue'

const userStore = useUserStore()
const messageStore = useMessageStore()

const emojiPickerSelected = ref(false);
let emojiIndex = new EmojiIndex(data);
const toggle = () => {
  emojiPickerSelected.value = !emojiPickerSelected.value;
};

const broadcastInput = ref("");
const convertEmoji = (emoji: any) => {
  console.log(emoji);
  broadcastInput.value += emoji.native;
};
const file = ref("");

const attachments: any[] = [];
const getFile = (files: any) => {
  // Do something with the file
  attachments.push(files);
};

// const selected = ref([
//   {
//     id: 1,
//     name: "Mentor Managers",
//   },
//   {
//     id: 2,
//     name: "Mentors",
//   },
//   {
//     id: 3,
//     name: "Perculiar",
//   },
//   {
//     id: 4,
//     name: "Kabiru",
//   },
// ]);

const isSelected = ref<string[]>([]);
const selectedId = ref<string[]>([]);

const setSelected = (id: number) => {
  const item = userStore.users?.find((item: { id: number; }) => item.id === id);
  if (item) {
    const index = isSelected.value.findIndex((it) => it === item.name);
    if (index === -1) {
      isSelected.value.push(item.name);
      selectedId.value.push(item.id);
    } else {
      isSelected.value.splice(index, 1);
      selectedId.value.splice(index, 1);
    }
  }
};

const broadcastMessage = () => {

    messageStore.sendBroadcast(broadcastInput, selectedId, attachments).then(() => {
      const scrolldown = document.getElementById("scrolldown");
      scrolldown?.scrollIntoView();

      broadcastInput.value = '';
    });
}
</script>

<script lang="ts">

export default defineComponent({
  
  beforeRouteEnter(to, from, next) {
    const userStore = useUserStore()
    const messageStore = useMessageStore()
    if (userStore.users && messageStore.broadcast) {
      next()
    } else {
      userStore.fetchUsers().then(() => {
        return messageStore.loadBroadcast()  
      }).then(() => {
         next();
      });
    }
  },
})
</script>

<style scoped lang="scss">
.broadcast-select {
  margin: 25px 0;
  .v-expansion-panel {
    .v-expansion-panel-title {
      padding-left: 30px !important;
      padding-right: 30px !important;
      border: 1px solid var(--border);
    }
  }

  li {
    padding: 5px 0;
    cursor: pointer;
    border-bottom: 1px solid var(--border);
    &:last-child {
      border-bottom: none;
    }
  }
}

.msg-area {
  width: 100%;
  height: 49vh;
  background-color: var(--light-grid-background);
  border-radius: 20px;
  border: 1px solid var(--card-light);
  padding: 35px 40px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow-y: scroll;

  &::-webkit-scrollbar {
    width: 8px;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: var(--btn-primary);
    height: 80px;
    border-radius: 50px;
  }

  .broadcast-card {
    background-color: var(--card-light);
    border-radius: 10px;
    padding: 20px;
    margin-top: 10px;
  }

  .smallD {
    color: #808080 !important;
    font-weight: 600;
  }
}

input {
  border: 1px solid var(--card-light) !important;
}
</style>
