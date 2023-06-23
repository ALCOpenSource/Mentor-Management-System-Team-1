import { defineStore } from "pinia";
import axios from "axios";

export const useTasksStore = defineStore("tasks", {
  state: () => ({
    tasks: [],
    selectedTask: {},
    isLoading: false,
    isCreatingTask: false,
  }),
  getters: {
    taskToShow: (state) =>
      state.tasks.filter((task) => task.id === state.selectedTask)[0],
  },
  actions: {
    async fetchAllTasks() {
      try {
        this.isLoading = true;
        const { data } = await axios.get("v1/task");
        this.tasks = data?.data;
      } catch (error) {
      } finally {
        this.isLoading = false;
      }
    },
    selectTask(id: string) {
      this.selectedTask = this.tasks.filter((task) => task.id === id)[0];
      console.log("selecting task of", this.selectedTask);
    },
    async createTask(task: {}) {
      try {
        console.log("new Task is being created");
        this.isCreatingTask = true;
        const { data } = await axios.post("v1/task", task);
        // check if task was created
        console.log("data is", data);
      } catch (error) {
        console.log("could not create task", error);
      } finally {
        this.isCreatingTask = false;
      }
    },
    async updateTask(task: {}) {},
    async deleteTask(taskId: string) {
      try {
        this.isLoading = true;
        const { data } = await axios.delete(`v1/task/${taskId}`);
        console.log(`Task of ${taskId} is being deleted`, data);

        // check if task was deleted
      } catch (error) {
        console.error("could not delete task", error);
      } finally {
        this.isLoading = false;
      }
    },
  },
});
