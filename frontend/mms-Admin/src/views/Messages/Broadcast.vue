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
                v-for="selected in selected" :key="selected.id"
                @click="setSelected(selected.id)"
              >
                {{ selected.name }}
              </li>
            </ul>
          </v-expansion-panel-text>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
    <div v-if="messageStore.broadcast.data.length !== 0" class="msg-area">
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
            <h3 class="font-semibold underline">Mentor Manager</h3>
            <div class="flex items-center">
              <small class="text-[#4D4D4D] mr-2">{{ message.human_date }}</small>
              <DoubleTick v-if="message.status === 'read'" />
            </div>

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
  broadcastInput.value += emoji.native;
};
const file = ref("");

const attachments: any[] = [];
const getFile = (files: any) => {
  // Do something with the file
  attachments.push(files);
};

const selected = ref([
  {
    id: 1,
    name: "Mentor Managers",
    value: "mentor_manager"
  },
  {
    id: 2,
    name: "Mentors",
    value: "mentor",
  },
  {
    id: 3,
    name: "Admin",
    value: "admin",
  },
  {
    id: 4,
    name: "Assistant",
    value: "assistant",
  },
]);

const isSelected = ref<string[]>([]);
const selectedRoles = ref<string[]>([]);

const setSelected = (id: number) => {
  const item = selected.value?.find((item: { id: number; }) => item.id === id);
  if (item) {
    const index = isSelected.value.findIndex((it) => it === item.name);
    if (index === -1) {
      isSelected.value.push(item.name);
      selectedRoles.value.push(item.value);
    } else {
      isSelected.value.splice(index, 1);
      selectedRoles.value.splice(index, 1);
    }
  }
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

const broadcastMessage = () => {

    messageStore.sendBroadcast(broadcastInput, selectedRoles, attachments).then(() => {
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
