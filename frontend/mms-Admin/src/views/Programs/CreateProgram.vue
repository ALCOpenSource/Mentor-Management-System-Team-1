<template>
  <div class="flex justify-between gap-5">
    <div class="transition-all w-full">
      <h1 class="font-bold text-2xl mb-8">Create New Program</h1>
      <div class="flex items-center mb-8">
        <v-avatar size="90px">
          <v-img src="https://picsum.photos/300/300" alt="pic"></v-img>
        </v-avatar>
        <div class="ml-6">
          <h1 class="mb-2 text-xl font-semibold">Set Profile Picture</h1>
          <UploadProfilePic @upload="getSrc" :pry="false" title="Select file" />
        </div>
      </div>
      <v-form v-model="valid" class="mt-10 flex flex-col">
        <Input
          label="Program Name"
          placeholder="Enter program name"
          hint="The title must contain a maximum of 32 characters"
        />
        <Textarea placeholder="Enter description" label="Program Description" />
        <section class="flex gap-6 mt-4 mb-12">
          <ResourceSelector
            v-if="!isMentorList"
            :on-click="showMentorList"
            title="Add Mentor Manager"
            :num="5"
          />
          <ResourceSelector
            v-if="!isMentorManagerList"
            :on-click="showMentorManagerList"
            title="Add Mentor"
            :num="6"
          />
          <ResourceSelector
            :on-click="
              () => router.push({ name: 'create-criteria', params: { id: 1 } })
            "
            title="Set Criteria"
            :num="9"
          />
        </section>
        <div
          class="flex mb-5"
          :class="
            isMentorList || isMentorManagerList
              ? 'justify-start'
              : 'justify-end'
          "
        >
          <PrimaryBtn title="Create Program" @click.prevent="handleSubmit" />
        </div>
      </v-form>
    </div>
    <div
      v-if="isMentorList || isMentorManagerList"
      class="max-w-[450px] min-w-[330px] transition-all"
    >
      <MentorList
        :on-click="hideList"
        :is-mentor-manager="!isMentorManagerList"
      />
    </div>
  </div>
  <Modal
    title="Program Created Successfully!"
    :isModalOpen="isModalOpen"
    :src="profileSuccess"
    primaryText="Done"
    @toggleModal="closeModal"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import UploadProfilePic from "@/components/Settings/UploadProfilePic.vue";
import Input from "@/components/Forms/Input.vue";
import Textarea from "@/components/Forms/Textarea.vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import ResourceSelector from "@/components/Common/ResourceSelector.vue";
import { profileSuccess } from "@/assets/images";
import Modal from "@/components/Forms/Modal.vue";
import MentorList from "@/components/Programs/MentorList.vue";

const router = useRouter();

const isModalOpen = ref(false);
const valid = ref(false);
const isMentorList = ref(false);
const isMentorManagerList = ref(false);

// Number or mentor/mentor-manager added to the list, from the array length we can get the number of mentors/mentor-managers added
const num = ref(0);

const getSrc = (file: any, src: any) => {
  console.log(file, src);
};

const closeModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleSubmit = () => {
  if (!valid.value) return;
  isModalOpen.value = !isModalOpen.value;
  console.log("submitted");
};

const showMentorList = () => {
  isMentorManagerList.value = false;
  isMentorList.value = true;
};
const showMentorManagerList = () => {
  isMentorList.value = false;
  isMentorManagerList.value = true;
};

const hideList = () => {
  isMentorList.value = false;
  isMentorManagerList.value = false;
};
</script>

<style scoped></style>
