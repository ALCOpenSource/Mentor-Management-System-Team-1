<template>
  <div>
    <div class="flex justify-between items-center">
      <div>
        <h1 class="font-semibold text-2xl">Braodcast Message</h1>
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
                v-for="(item, index) in selected"
                :key="item.id"
                @click="setSelected(item.id)"
              >
                {{ item.name }}
              </li>
            </ul>
          </v-expansion-panel-text>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
    <div class="msg-area">
      <div
        class="flex flex-col items-center center mb-5"
        v-for="item in 5"
        :key="item"
      >
        <small class="smallD bg-white p-1 px-2 rounded">09-01-23</small>
        <div class="broadcast-card">
          <p class="text-[#4D4D4D] text-xl">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent
            dignissim pharetra metus, ut cursus purus efficitur et. Duis ac enim
            tellus. Phasellus eget tortor dapibus, laoreet mauris sed, dignissim
            lectus.
          </p>
          <div class="flex justify-between items-center mt-3">
            <h3 class="font-semibold underline">Mentor Managers</h3>
            <div class="flex items-center">
              <small class="text-[#4D4D4D] mr-2">09-01-23</small>
              <DoubleTick />
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

const getFile = (files: any) => {
  // Do something with the file
  file.value = files.name;
};

const selected = ref([
  {
    id: 1,
    name: "Mentor Managers",
  },
  {
    id: 2,
    name: "Mentors",
  },
  {
    id: 3,
    name: "Perculiar",
  },
  {
    id: 4,
    name: "Kabiru",
  },
]);

const isSelected = ref<string[]>([]);

const setSelected = (id: number) => {
  const item = selected.value.find((item) => item.id === id);
  if (item) {
    const index = isSelected.value.findIndex((it) => it === item.name);
    if (index === -1) {
      isSelected.value.push(item.name);
    } else {
      isSelected.value.splice(index, 1);
    }
  }
};
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
