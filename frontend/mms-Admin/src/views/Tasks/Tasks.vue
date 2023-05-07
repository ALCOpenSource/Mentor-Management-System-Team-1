<template>
  <div className="flex gap-4 pt-8 overflow-y-hidden">
    <div className="w-6/12 overflow-x-hidden">
      <section className="flex justify-between pb-6 overflow-y-auto ">
        <h1 className="font-bold text-2xl">Tasks</h1>
        <div class="flex items-center gap-2">
          <span class="cursor-pointer">
            <IconSearch color="#058B94" />
          </span>
          <span class="cursor-pointer">
            <IconFilter />
          </span>
        </div>
      </section>
      <section
        class="flex flex-col h-[80vh] task_list gap-4 overflow-y-auto overflow-x-hidden"
      >
        <TaskCard
          v-for="task in allTasks"
          :onClick="() => selectTask(task.id)"
          :key="task.id"
          :is-selected="task.id === selectedTask"
          :title="task.title"
          :description="task.description"
          :days-due="task.daysDue"
        />
      </section>
    </div>
    <div className="flex flex-col gap-2 w-full">
      <div class="flex justify-end">
        <PrimaryBtn title="Create New Task" />
      </div>
      <TaskDetails :task="taskToShow" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { IconSearch } from "@/assets/icons";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import IconFilter from "@/components/Icons/IconFilter.vue";
import TaskCard from "@/components/Tasks/TaskCard.vue";
import TaskDetails from "@/components/Tasks/TaskDetails.vue";
</script>

<script lang="ts">
export default {
  data() {
    return {
      selectedTask: 4,
      allTasks: [
        {
          id: 1,
          title: "Room Library article write inside thew ings",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 41,
        },
        {
          id: 2,
          title: "Found the new haven",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 2,
        },
        {
          id: 3,
          title: "Kitchen pillars in field",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 1,
        },
        {
          id: 4,
          title: "Books denied immediate freeze",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 9,
        },
        {
          id: 5,
          title: "Dredge into derailed",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 1,
        },
        {
          id: 6,
          title: "Time intense rebound",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 4,
        },
        {
          id: 7,
          title: "Looming endostat",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 4,
        },
        {
          id: 8,
          title: "Surrogate nuance",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 4,
        },
        {
          id: 9,
          title: "Query dingola period",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 4,
        },
        {
          id: 10,
          title: "Nellion Signal",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 4,
        },
        {
          id: 11,
          title: "Werinkle Pidgin Influx",
          description:
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa praesentium blanditiis maiores minima libero aliquam tenetur illum fuga sapiente vitae laborum aperiam officia quisquam, earum inventore, expedita laboriosam nam, unde nostrum qui dicta placeat. Culpa error, rerum quidem ad sit adipisci excepturi est suscipit quia aliquid consequuntur doloremque, pariatur assumenda corporis eos ut odit nemo porro non. Tempora, vitae commodi?",
          daysDue: 4,
        },
      ],
    };
  },
  methods: {
    selectTask(id: number) {
      this.selectedTask = id;
    },
  },
  computed: {
    taskToShow() {
      return this.allTasks.filter((task) => task.id === this.selectedTask)[0];
    },
  },
};
</script>

<style scoped lang="scss">
.task_list {
  padding-right: 0.5rem;

  &::-webkit-scrollbar {
    width: 5px;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: var(--scrollbar-bg);
    height: 40px;
    border-radius: 100px;
  }

  &::-webkit-scrollbar-thumb:hover {
    background: var(--btn-primary);
    opacity: 0.2;
  }
}
</style>
