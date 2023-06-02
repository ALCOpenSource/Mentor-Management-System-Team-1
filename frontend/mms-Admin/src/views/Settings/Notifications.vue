<template>
  <div>
    <h1 class="text-lg 2xl:text-xl font-semibold">General Notifications</h1>
    <v-row no-gutters class="my-2" align="center">
      <v-col cols="6"></v-col>
      <v-col cols="1" class="font-semibold text-sm 2xl:text-base mr-4">Email</v-col>
      <v-col cols="1" class="font-semibold text-sm 2xl:text-base whitespace-nowrap">In-app</v-col>
    </v-row>
    <v-row
      v-for="item in generalNotifications"
      :key="item.id"
      no-gutters
      align="center"
      class="my-4"
    >
      <v-col cols="6"
        ><p class="text-sm 2xl:text-base">{{ item.name }}</p></v-col
      >
      <v-col cols="1" class="mr-4"
        ><Checkbox
          :id="item.id"
          :switch-name="item.switchEmail"
          :checked="item.email"
          @update:checked="toggleGenEmail"
      /></v-col>
      <v-col cols="1">
        <Checkbox
          :id="item.id"
          :switch-name="item.switchInApp"
          :checked="item.inApp"
          @update:checked="toggleGenInApp"
        />
      </v-col>
    </v-row>
    <h1 class="text-lg 2xl:text-xl font-semibold mt-12">Discussion Notifications</h1>
    <v-row no-gutters class="my-2" align="center">
      <v-col cols="6"></v-col>
      <v-col cols="1" class="font-semibold text-sm 2xl:text-base mr-4">Email</v-col>
      <v-col cols="1" class="font-semibold text-sm 2xl:text-base whitespace-nowrap">In-app</v-col>
    </v-row>
    <v-row
      v-for="item in discussionNotifications"
      :key="item.id"
      no-gutters
      align="center"
      class="my-4"
    >
      <v-col cols="6"
        ><p class="text-sm 2xl:text-base">{{ item.name }}</p></v-col
      >
      <v-col cols="1" class="mr-4"
        ><Checkbox
          :id="item.id"
          :switch-name="item.switchEmail"
          :checked="item.email"
          @update:checked="toggleEmail"
      /></v-col>
      <v-col cols="1">
        <Checkbox
          :id="item.id"
          :switch-name="item.switchInApp"
          :checked="item.inApp"
          @update:checked="toggleInApp"
        />
      </v-col>
    </v-row>
    <v-row class="mt-10" align-content="center" justify="start">
      <v-col cols="6">
        <PrimaryBtn title="Save Changes" @click="handleSubmit" />
      </v-col>
    </v-row>
    <Modal
      title="Settings Saved Successfully"
      :src="profileSuccess"
      :is-modal-open="isModalOpen"
      primary-text="Done"
      @toggle-modal="toggleModal"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import Checkbox from "../../components/Forms/Checkbox.vue";
import Modal from "../../components/Forms/Modal.vue";
import { profileSuccess } from "../../assets/images";

const isModalOpen = ref(false);

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleSubmit = () => {
  toggleModal();

  // Handle Submit
};

// Should come from the backend
const generalNotifications = ref([
  {
    name: "All Notifications",
    switchEmail: "switch1",
    switchInApp: "switch2",
    id: "1",
    email: false,
    inApp: true,
  },
  {
    name: "Programs",
    switchEmail: "switch3",
    switchInApp: "switch4",
    id: "2",
    email: false,
    inApp: true,
  },
  {
    name: "Tasks",
    switchEmail: "switch5",
    switchInApp: "switch6",
    id: "3",
    email: true,
    inApp: false,
  },
  {
    name: "Approval Requests",
    switchEmail: "switch7",
    switchInApp: "switch8",
    id: "4",
    email: true,
    inApp: false,
  },
  {
    name: "Reports",
    switchEmail: "switch9",
    switchInApp: "switch10",
    id: "5",
    email: true,
    inApp: false,
  },
]);

// Should come from the backend
const discussionNotifications = ref([
  {
    name: "Comments on my post",
    switchEmail: "switch11",
    switchInApp: "switch12",
    id: "6",
    email: false,
    inApp: true,
  },
  {
    name: "Posts",
    switchEmail: "switch13",
    switchInApp: "switch14",
    id: "7",
    email: false,
    inApp: true,
  },
  {
    name: "Comments",
    switchEmail: "switch15",
    switchInApp: "switch16",
    id: "8",
    email: true,
    inApp: false,
  },
  {
    name: "Mentions",
    switchEmail: "switch17",
    switchInApp: "switch18",
    id: "9",
    email: true,
    inApp: false,
  },
  {
    name: "Direct Message",
    switchEmail: "switch19",
    switchInApp: "switch20",
    id: "10",
    email: true,
    inApp: false,
  },
]);

const toggleGenEmail = (id: String) => {
  const index = generalNotifications.value.findIndex((item) => item.id === id);
  generalNotifications.value[index].email =
    !generalNotifications.value[index].email;
};

const toggleGenInApp = (id: String) => {
  const index = generalNotifications.value.findIndex((item) => item.id === id);
  generalNotifications.value[index].inApp =
    !generalNotifications.value[index].inApp;
};

const toggleEmail = (id: String) => {
  const index = discussionNotifications.value.findIndex(
    (item) => item.id === id
  );
  discussionNotifications.value[index].email =
    !discussionNotifications.value[index].email;
};

const toggleInApp = (id: String) => {
  const index = discussionNotifications.value.findIndex(
    (item) => item.id === id
  );
  discussionNotifications.value[index].inApp =
    !discussionNotifications.value[index].inApp;
};
</script>

<style scoped lang="scss"></style>
