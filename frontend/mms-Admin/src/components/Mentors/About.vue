<template>
  <div class="tab">
    <div class="about">
      <h1 class="text-lg font-semibold">Bio</h1>
      <div class="bio">
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent
          dignissim ut cursus purus efficitur et. Duis ac enim tellus. Phasellus
          pharetra metus, ut cursus purus efficitur et. Duis ac enim tellus.
          Phasellus eget tortor dapibus, laoreet mauris sed, dignissim lectus.
        </p>
      </div>
      <div class="flex gap-3 mb-3">
        <h1 class="text-lg font-semibold">Technical Proficiency:</h1>
        <p class="text-[#808080]">Java Script, Django, Mysql, Android</p>
      </div>
      <div class="flex gap-3 mb-3">
        <h1 class="text-lg font-semibold">Previous Programs:</h1>
        <p class="text-[#808080]">GADS 2022, Google I/O Extended 2021</p>
      </div>
      <div class="flex gap-3 mb-3">
        <h1 class="text-lg font-semibold">Previous Roles Held:</h1>
        <p class="text-[#808080]">
          Learner, Mentor, Program Assistant, Program Assistant Lead
        </p>
      </div>
      <div class="flex gap-3 mb-3">
        <h1 class="text-lg font-semibold">
          Availability to join a new program:
        </h1>
        <p class="text-[#808080]">Unavailable</p>
      </div>
      <div class="flex gap-3 mb-3">
        <h1 class="text-lg font-semibold">Program of interest:</h1>
        <p class="text-[#808080]">Google Africa Scholarship Program</p>
      </div>
      <div class="flex gap-3 mb-3">
        <h1 class="text-lg font-semibold">Been a Mentor Before?</h1>
        <p class="text-[#808080]">Yes</p>
      </div>
      <div class="flex gap-3 mb-3">
        <h1 class="text-lg font-semibold">Years of Technical Experience:</h1>
        <p class="text-[#808080]">3years</p>
      </div>
      <div class="flex flex-col gap-2 mb-3">
        <h1 class="text-lg font-semibold">Documents</h1>
        <div class="flex gap-2">
          <div class="flex gap-1">
            <Paper />
            <p class="text-[#808080]">My resume.doc</p>
          </div>
          <div class="flex gap-1">
            <Paper />
            <p class="text-[#808080]">Birth Cerificate.doc</p>
          </div>
          <div class="flex gap-1">
            <Paper />
            <p class="text-[#808080]">Java Lead.doc</p>
          </div>
        </div>
      </div>
      <div class="flex items-center gap-3 mb-3">
        <h1 class="text-lg font-semibold">Website:</h1>
        <a
          href="http://"
          target="_blank"
          rel="noopener noreferrer"
          class="hover:underline"
          >example.com</a
        >
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Paper } from "@/assets/icons";
</script>

<style scoped lang="scss">
.tab {
  width: 100%;
  height: 56vh;
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: 0px 5px 5px rgba(241, 241, 241, 0.25);
  padding: 0.5rem;
}
.about {
  height: 100%;
  overflow-y: scroll;
  padding: 0.5rem;

  &::-webkit-scrollbar {
    width: 5px;
    transition: all 0.5s ease-in-out;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: #06b9c6;
    border-radius: 50px;
  }
  .bio {
    padding: 14px;
    border: 1px solid var(--card-light);
    background-color: var(--light-grid-background);
    color: #4d4d4d;
    margin-bottom: 10px;
  }
}
</style>
