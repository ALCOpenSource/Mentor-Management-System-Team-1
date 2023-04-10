<script lang="ts">
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import Password from "@/components/Forms/Password.vue";


export default {
  components: {
    PrimaryBtn,
    Password,
  },
  data() {
    return {
      password: "",
      isModalOpen: false,
    };
  },
  methods: {
    onPasswordChange() {
    // handle on password change
},
toggleModal() {
    this.isModalOpen = !this.isModalOpen;
},
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
        placeholder="Email"
        @update:password="(value: string) => (password = value)"
      />
      <PrimaryBtn
        :disabled="!password.length"
        title="Reset Password"
        class="mt-5"
        type="submit"
        @click="toggleModal"
      />
    </form>
    <p class="flex justify-end font-semibold underline">
      Remeber Password? Login
    </p>
  </div>
  <!-- MODAL -->
  <v-row justify="center">
    <v-dialog v-model="isModalOpen" width="600">
      <div class="border-2 flex py-6 rounded-lg gap-8 flex-col items-center bg-white">
          <h2 class="font-bold text-2xl">Password Reset Successful</h2>
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
      </div>
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
