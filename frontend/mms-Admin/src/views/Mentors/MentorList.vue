<template>
  <div>
    <div class="flex justify-between item">
      <div class="flex items-center gap-3">
        <h1 class="font-semibold text-2xl mr-3">Mentors</h1>
        <GridOne :color="activeGrid === 'gridOne' ? '#058B94' : '#CEFAFD'" class="cursor-pointer" @click="changeGrid('gridOne')"/>
        <GridTwo :color="activeGrid === 'gridTwo' ? '#058B94' : '#CEFAFD'" class="cursor-pointer" @click="changeGrid('gridTwo')"/>
      </div>
      <div class="flex items-center gap-5">
        <div class="flex gap-3">
          <router-link to="/admin/messages/broadcast">
            <SecondaryBtn title="Send Broadcast Message" />
          </router-link>
          <PrimaryBtn title="Add New Mentor" @click="handleModalDecider('add')"/>
        </div>
        <Pagination />
        <IconSearch color="#058B94" class="cursor-pointer"/>
        <Filter class="cursor-pointer"/>
      </div>
    </div>
    <v-row no-gutters class="gap-3 mt-5 transition-all">
      <v-col v-for="n in numberToDisplay" :cols="cols" class="transition-all">
        <UserCard show-comment show-delete @delete="handleModalDecider('delete')"/>
      </v-col>
    </v-row>
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
import { ref, onMounted } from "vue";
import { GridOne, GridTwo, Filter, IconSearch } from "@/assets/icons";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import SecondaryBtn from "@/components/Buttons/SecondaryBtn.vue";
import Pagination from "@/components/Common/Pagination.vue";
import UserCard from "@/components/Common/UserCard.vue";
import Modal from "../../components/Forms/Modal.vue";
import { deleteSuccess } from "../../assets/images";

const activeGrid = ref("gridOne");
const cols = ref(6);
const numberToDisplay = ref(0);
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
const validEmail = ref(true);

const getNumberToDisplay = () => {
  const height = window.innerHeight - window.innerHeight * 0.3;
  const cardHeight = 80;
  const numberToDisplay = Math.floor(height / cardHeight);
  return numberToDisplay;
}

const changeGrid = (grid: string) => {
  activeGrid.value = grid;
  if (grid === "gridOne") {
    cols.value = 12;
    numberToDisplay.value = getNumberToDisplay();
  } else {
    cols.value = 5.9;
    numberToDisplay.value = getNumberToDisplay() * 2 - 2;
  }
}

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
    handleModalDecider("confirm-add");
  }
};

const handleSubmit = () => {
  // Handle the Form submission
  switch (modalDecider.value)
  {
    case "delete":
      // Delete the mentor
      closeModal();
      break;
    case "add":
      // Send the invitation
      validateEmail(newEmail.value);
      break;
    case "confirm-add":
      // Close the modal
      closeModal();
      break;
  }
};

const handleModalDecider = (value: string) => {
  modalDecider.value = value;
  switch (value)
  {
    case "delete":
      modalData.value = {
        title: "Mentor Deleted Successfully",
        src: deleteSuccess,
        primaryText: "Done",
        secondaryText: "Undo",
      };
      openModal();
      break;
    case "add":
      modalData.value = {
        title: "Add Mentor",
        primaryText: "Send",
        secondaryText: "Cancel",
        email: true,
      };
      openModal();
      break;
    case "confirm-add":
      modalData.value = {
        title: "Add Mentor",
        cardText: `An invitation has been sent to ${newEmail.value} successfully`,
        primaryText: "Done",
      };
      break;
  }
}

onMounted(() => {
  changeGrid("gridOne");
})

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
