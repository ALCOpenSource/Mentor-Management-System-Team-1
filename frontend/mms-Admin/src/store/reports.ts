import { defineStore } from 'pinia';
import axios from 'axios';
import { onBeforeMount } from 'vue';

interface ReportState {
  reports: Object | null;
  report: Object | null;
}

export const useReportStore = defineStore({
  id: 'reports',

  state: (): ReportState => {
    return {
      reports: null,
      report: null,
    };
  },

  getters: {
    getReports: (state) => state.reports,
    getReport: (state) => state.report,
  },

  actions: {
    async loadReports() {
      const res = await axios.get('v1/report/task');
      this.reports = res.data;
      console.log(this.reports)
    },

    async loadReport(task_id: Number) {
      const res = await axios.get('v1/report/task?task_id=' + task_id);
      this.report = res.data;
    },
  },

});