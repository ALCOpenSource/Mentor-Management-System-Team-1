<template>
  <div class="bg-green-200 p-4 pr-8 flex gap-4 items-center justify-between">
    <div class="flex items-center gap-16 text-black-400">
      <div class="flex gap-4">
        <section class="mt-1">
          <IconMentor v-if="type === 'mentor'" color="#058B94" size="30" />
          <IconReport v-if="type === 'reports'" color="#058B94" size="30" />
          <IconMentorManagers
            v-if="type === 'mentor-managers'"
            color="#058B94"
            size="30"
          />
        </section>
        <span class="text-4xl font-semibold">{{ count }}</span>
        <span class="text-2xl font-semibold">{{ text }}</span>
      </div>
      <span
        class="h-7 mb-2 text-white font-semibold text-sm flex items-center justify-center w-7 bg-red-400 rounded-full p-4"
        v-if="type === 'reports'"
      >
        {{ unread }}
      </span>
    </div>
    <PrimaryBtn title="View" />
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import { IconMentorManagers, IconMentor, IconReport } from "../Icons";

type Props = {
  count: string;
  text: string;
  unread: string;
  type: "mentor" | "mentor-managers" | "reports";
};

defineProps<Props>();
</script>
