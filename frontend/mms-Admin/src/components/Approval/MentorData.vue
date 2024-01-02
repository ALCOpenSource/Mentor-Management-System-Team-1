<template>
  <div class="about">
    <h1 class="text-base 2xl:text-lg font-semibold">Bio</h1>
    <div class="bio text-sm 2xl:text-base">
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent
        dignissim ut cursus purus efficitur et. Duis ac enim tellus. Phasellus
        pharetra metus, ut cursus purus efficitur et. Duis ac enim tellus.
        Phasellus eget tortor dapibus, laoreet mauris sed, dignissim lectus.
      </p>
    </div>
    <div class="flex items-center gap-3 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">
        Technical Proficiency:
      </h1>
      <p class="text-[#808080] text-sm 2xl:text-base">
        Java Script, Django, Mysql, Android
      </p>
    </div>
    <div class="flex items-center gap-3 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">Previous Programs:</h1>
      <p class="text-[#808080] text-sm 2xl:text-base">
        GADS 2022, Google I/O Extended 2021
      </p>
    </div>
    <div class="flex items-center gap-3 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">Previous Roles Held:</h1>
      <p class="text-[#808080] text-sm 2xl:text-base">
        Learner, Mentor, Program Assistant, Program Assistant Lead
      </p>
    </div>
    <div class="flex items-center gap-3 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">
        Availability to join a new program:
      </h1>
      <p class="text-[#808080] text-sm 2xl:text-base">Unavailable</p>
    </div>
    <div class="flex items-center gap-3 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">Program of interest:</h1>
      <p class="text-[#808080] text-sm 2xl:text-base">
        Google Africa Scholarship Program
      </p>
    </div>
    <div class="flex items-center gap-3 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">Been a Mentor Before?</h1>
      <p class="text-[#808080] text-sm 2xl:text-base">Yes</p>
    </div>
    <div class="flex items-center gap-3 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">
        Years of Technical Experience:
      </h1>
      <p class="text-[#808080] text-sm 2xl:text-base">3years</p>
    </div>
    <div class="flex flex-col gap-2 mb-3">
      <h1 class="text-base 2xl:text-lg font-semibold">Documents</h1>
      <div class="flex gap-2">
        <div class="flex gap-1">
          <Paper />
          <p class="text-[#808080] text-sm 2xl:text-base">My resume.doc</p>
        </div>
        <div class="flex gap-1">
          <Paper />
          <p class="text-[#808080] text-sm 2xl:text-base">
            Birth Cerificate.doc
          </p>
        </div>
        <div class="flex gap-1">
          <Paper />
          <p class="text-[#808080] text-sm 2xl:text-base">Java Lead.doc</p>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-between mt-5 mb-3">
      <h3
        class="text-[#023C40] text-base 2xl:text-lg underline font-semibold cursor-pointer decoration-[#058B94] decoration-2"
      >
        Send Message
      </h3>
      <div class="flex gap-5">
        <SecondaryBtn title="Decline" />
        <PrimaryBtn title="Approve" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Paper } from "@/assets/icons";
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import SecondaryBtn from "../Buttons/SecondaryBtn.vue";
</script>

<style scoped lang="scss">
.about {
  padding: 0.5rem;
  .bio {
    padding: 14px;
    border: 1px solid #cefafd;
    background-color: var(--card-light);
    color: #4d4d4d;
    margin-bottom: 10px;
  }
}
</style>
