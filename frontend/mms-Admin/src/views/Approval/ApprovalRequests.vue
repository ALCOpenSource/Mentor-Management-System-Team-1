<template>
  <div class="flex gap-5">
    <div class="w-[319px] flex flex-col gap-8">
      <div>
        <Category :category="category" @selected="setSelected" />
      </div>
      <div>
        <Recent :details="recentDetails" />
      </div>
    </div>
    <div class="w-full">
      <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-semibold">
          {{ category[selected].name }}
        </h1>
        <div v-if="selected !== 2">
          <PrimaryBtn
            :title="
              selected === 0 ? 'Add new Mentor Manager' : 'Add new Mentor'
            "
            @click="
              handleModalDecider(
                `add-${selected === 0 ? 'mentor-manager' : 'mentor'}`
              )
            "
          />
        </div>
      </div>
      <div>
        <div v-for="(item, index) in 10" :key="item" class="mb-2">
          <Accordion v-if="selected !== 2" :index="index" approval user>
            <MentorData />
          </Accordion>
          <ProgramCard v-else />
        </div>
      </div>
    </div>
  </div>
  <Modal
    :title="modalData.title"
    :isModalOpen="isModalOpen"
    :src="modalData.src"
    :cardText="modalData.cardText"
    :primaryText="modalData.primaryText"
    :secondaryText="modalData.secondaryText"
    :email="modalData.email"
    @toggleModal="handleSubmit"
    @update:email="newEmail = $event"
    @closeModal="closeModal"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";
import Category from "@/components/Common/Category.vue";
import Recent from "@/components/Common/Recent.vue";
import { category1, category2, category3 } from "@/assets/images";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import Accordion from "@/components/Common/Accordion.vue";
import ProgramCard from "@/components/Approval/ProgramCard.vue";
import Modal from "../../components/Forms/Modal.vue";
import MentorData from "@/components/Approval/MentorData.vue";

const selected = ref(0);
const newEmail = ref("");
const isModalOpen = ref(false);
const modalData = ref<ModalData>({
  title: "",
  src: "",
  cardText: "",
  primaryText: "",
  secondaryText: "",
  email: false,
});
const modalDecider = ref("");
const validEmail = ref(false);

const setSelected = (index: number) => {
  selected.value = index;
};

// Fetch data from store according to the selected category and pending status

const openModal = () => {
  isModalOpen.value = true;
};
const closeModal = () => {
  isModalOpen.value = false;
};
const validateEmail = (email: string) => {
  const emailRules = [
    (value: string) => Boolean(value) || "Email is required",
    (value: string) => /.+@.+\..+/.test(value) || "Email must be valid",
  ];
  validEmail.value = emailRules.every((rule) => rule(email) === true);
  if (validEmail.value) {
    handleModalDecider(`confirm-${modalDecider.value}`);
  }
};

const handleSubmit = () => {
  // Handle the Form submission
  switch (modalDecider.value) {
    case "add-mentor":
      validateEmail(newEmail.value);
      // Send the invitation to mentor
      break;
    case "add-mentor-manager":
      validateEmail(newEmail.value);
      // Send the invitation to mentor manager
      break;
    case "confirm-add-mentor":
      // Close the modal
      closeModal();
      break;
    case "confirm-add-mentor-manager":
      // Close the modal
      closeModal();
      break;
  }
};

const handleModalDecider = (value: string) => {
  modalDecider.value = value;
  switch (value) {
    case "add-mentor":
      modalData.value = {
        title: "Add Mentor",
        primaryText: "Send",
        secondaryText: "Cancel",
        email: true,
      };
      openModal();
      break;
    case "confirm-add-mentor":
      modalData.value = {
        title: "Add Mentor",
        cardText: `An invitation has been sent to ${newEmail.value} successfully`,
        primaryText: "Done",
      };
      break;
    case "add-mentor-manager":
      modalData.value = {
        title: "Add Mentor Manager",
        primaryText: "Send",
        secondaryText: "Cancel",
        email: true,
      };
      openModal();
      break;
    case "confirm-add-mentor-manager":
      modalData.value = {
        title: "Add Mentor Manager",
        cardText: `An invitation has been sent to ${newEmail.value} successfully`,
        primaryText: "Done",
      };
      break;
  }
};

const category = [
  {
    name: "Mentor Manager Requests",
    count: 287,
    imgUrl: category1,
  },
  {
    name: "Mentor Requests",
    count: 160,
    imgUrl: category2,
  },
  {
    name: "Program Requests",
    count: 160,
    imgUrl: category3,
  },
];
const recentDetails = {
  name: "Alison Davis",
  text: "GADS CLOUD 2022 - COMP...",
  imgUrl: "https://picsum.photos/100/100",
};

interface ModalData {
  title: string;
  src?: string;
  cardText?: string;
  primaryText: string;
  secondaryText?: string;
  email?: boolean;
}
</script>

<style scoped></style>
