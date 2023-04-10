<template>
  <div class="w-3/5 mx-auto flex flex-col justify-center h-full">
    <div>
      <h1 class="mb-1">Reset your password</h1>
      <h3>Put in the email attached to this account</h3>
    </div>
    <form class="mt-14 mb-5">
      <Email
        placeholder="Email"
        @update:email="(value: string ) => (email = value)"
      />
      <PrimaryBtn
        :disabled="isButtonDisabled"
        title="Reset Password"
        type="submit"
        class="mt-5"
      />
    </form>
    <p class="flex justify-end font-semibold underline">
      Remeber Password? Login
    </p>
  </div>
</template>

<script lang="ts">
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import Email from "@/components/Forms/Email.vue";

export default {
  components: {
    PrimaryBtn,
    Email,
  },
  data() {
    return {
      email: "",
    };
  },
  computed: {
    isButtonDisabled() {
      return !this.email.length
    },
  },
};

</script>

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
