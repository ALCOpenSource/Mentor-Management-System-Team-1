<template>
  <div class="flex h-[100px] gap-4">
    <ActiveCard />
    <div
      class="flex bg-green-100 rounded-lg w-full dashboard_section p-2 justify-between gap-4"
    >
      <div v-for="card in cardData" :key="card.name">
        <router-link :to="{ name: card.pathName }">
          <MentorCard
            :title="card.name"
            :count="card.count"
            :percentage="card.percent"
          >
            <IconTask v-if="card.name === 'Tasks'" color="#058B94" size="35" />
            <IconMentor
              v-if="card.name === 'Mentors'"
              color="#058B94"
              size="35"
            />
            <IconMentorManagers
              v-if="card.name === 'Mentor Managers'"
              color="#058B94"
              size="30"
            />
            <IconReport
              v-if="card.name === 'Reports'"
              color="#058B94"
              size="35"
            />
          </MentorCard>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import ActiveCard from "./ActiveCard.vue";
import MentorCard from "./MentorCard.vue";
import {
  IconTask,
  IconMentor,
  IconMentorManagers,
  IconReport,
} from "@/components/Icons";

const cardData = [
  {
    name: "Mentors",
    count: 30,
    percent: "12%",
    icon: IconMentor,
    pathName: "mentors",
  },
  {
    name: "Mentor Managers",
    count: 10,
    percent: "5%",
    icon: IconMentorManagers,
    pathName: "mentor-managers",
  },
  {
    name: "Tasks",
    count: 40,
    percent: "32%",
    icon: IconReport,
    pathName: "tasks",
  },
  {
    name: "Reports",
    count: 38,
    percent: "22%",
    icon: IconTask,
    pathName: "reports",
  },
];
</script>

<style scoped lang="scss"></style>
