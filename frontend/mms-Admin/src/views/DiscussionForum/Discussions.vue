<template>
  <div>
    <h1 class="font-semibold text-2xl">Discussion Forum</h1>
    <div class="add" @click="toggleTopicModal">
      <h1 class="text-[#808080]">Add new topic</h1>
      <IconCircleAdd />
    </div>
    <div class="discussion-area">
      <DiscussionCard @update-modal="updateModal" />
      <DiscussionCard />
      <DiscussionCard />
      <DiscussionCard />
    </div>
    <v-row justify="center">
      <v-dialog v-model="isTopicModalOpen" width="866" persistent>
        <div
          class="flex w-full bg-white py-12 px-10 rounded-xl gap-3 flex-col items-center justify-between"
        >
          <div class="flex w-full justify-between items-center">
            <h1 class="text-2xl font-semibold">New Topic</h1>
            <Close @click="toggleTopicModal" class="cursor-pointer" />
          </div>
          <div class="w-full mt-2">
            <v-form v-model="valid" @submit.prevent="handleSubmit">
              <v-text-field
                v-model="topicState.title"
                :rules="[rules.required, rules.min]"
                type="text"
                hint="At least 8 characters"
                variant="solo"
                placeholder="Enter a title"
              ></v-text-field>
              <div>
                <textarea
                  v-model="topicState.body"
                  placeholder="Start typing..."
                  class="border rounded-md w-full p-3 focus:outline-[#058b94] placeholder:text-lg placeholder:font-light"
                  rows="5"
                ></textarea>
                <div class="flex gap-3 mt-1 mb-3">
                  <Smiley color="#058b94" />
                  <Docs color="#058b94" />
                </div>
              </div>
              <div class="flex w-full justify-end">
                <PrimaryBtn title="Post to Forum" type="submit" />
              </div>
            </v-form>
          </div>
        </div>
      </v-dialog>
    </v-row>
  </div>
  <Modal
    title="Post Created Successfully!"
    :src="profileSuccess"
    :is-modal-open="isModalOpen"
    primary-text="Done"
    @toggle-modal="toggleModal"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";
import { IconCircleAdd, Close, Smiley, Docs } from "@/assets/icons";
import DiscussionCard from "@/components/Discussion/DiscussionCard.vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import Modal from "../../components/Forms/Modal.vue";
import { profileSuccess } from "../../assets/images";

const valid = ref(false);
const isTopicModalOpen = ref(false);
const isModalOpen = ref(false);
const isUpdate = ref(false);

// Demo State
const topicState = ref({
  title: "",
  body: "",
});

const toggleTopicModal = () => {
  isTopicModalOpen.value = !isTopicModalOpen.value;
};
const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const rules = {
  required: (value: string) => Boolean(value) || "Required.",
  min: (value: string) => value.length >= 8 || "Min 8 characters",
};

// Demo
const handleSubmit = () => {
  if (topicState.value.body.length < 8) {
    alert("Topic must contain a min 8 characters");
    return;
  }
  if (valid.value) {
    toggleTopicModal();
    // Do something depending on isUpdate or Adding
  }
  toggleModal();
  topicState.value = {
    title: "",
    body: "",
  };
};

const updateModal = () => {
  isUpdate.value = true;
  // Get Topic data and set the topic state
  topicState.value = {
    title: "Topic Title",
    body: "Topic Body",
  };
  toggleTopicModal();
};
</script>

<style scoped lang="scss">
.add {
  width: 100%;
  border: 1px solid var(--border);
  padding: 10px 30px;
  margin: 20px 0;
  margin-bottom: 30px;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
}

.discussion-area {
  height: 62vh;
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
}

textarea {
  resize: none;
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
}
</style>
