<script lang="ts">
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import Password from "@/components/Forms/Password.vue";
import { ref } from "vue";

export default {
  components: {
    PrimaryBtn,
    Password,
  },
  methods: {
    async onPasswordChange(e: any) {
      console.log("changing password", e);
    },
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    printHi() {
      alert("hola");
    },
  },
  data() {
    return {
      password: "",
      isModalOpen: false,
    };
  },
};
</script>

<template>
  <div class="w-3/5 mx-auto flex flex-col justify-center h-full">
    <div>
      <h1 class="mb-1">Set new password</h1>
      <h3>Put in the email attached to this account</h3>
    </div>
    <form class="mt-14 mb-5" @submit.prevent="onPasswordChange">
      <Password
        @update:password="(value: string) => (password = value)"
        placeholder="Email"
      />
      <PrimaryBtn
        :disabled="password.length < 1 ? true : false"
        title="Reset Password"
        @click="toggleModal"
        type="submit"
        class="mt-5"
      />
    </form>
    <p class="flex justify-end font-semibold underline">
      Remeber Password? Login
    </p>
  </div>
  <!-- MODAL -->
  <v-row justify="center">
    <v-dialog v-model="isModalOpen" width="800">
      <v-card class="border-2 border-rose-600 bg-slate-200">
        <v-card-title>
          <span class="text-h5 font-bold">Password Reset Successful</span>
        </v-card-title>
        <v-card-text>
          <img
            src="../../assets/images/reset_successful.png"
            alt=""
            srcset=""
          />
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <PrimaryBtn title="Done" @click="toggleModal" />
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<style scoped lang="scss">
h1 {
  font-weight: 700;
  font-size: 32px;
}

h3 {
  font-weight: 400;
  font-size: 22px;
  color: var(--text-inactive);
}

p {
  cursor: pointer;

  &:hover {
    color: var(--btn-primary);
  }
}
</style>
