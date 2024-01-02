import { defineStore } from "pinia";
import axios from "axios";

interface FaqState {
  generalFaqs: Faq[];
  technicalFaqs: Faq[];
  faq: Faq | null;
}

interface Faq {
  id?: number;
  question: string;
  answer: string;
  category: string;
}

export const useFaqStore = defineStore({
  id: "faq",

  state: (): FaqState => {
    return {
      generalFaqs: [],
      technicalFaqs: [],
      faq: null,
    };
  },

  actions: {
    async fetchFaqs() {
      this.generalFaqs = [];
      try {
        await axios
          .get("v1/faq")
          .then(
            (response) => (
              (this.generalFaqs = response?.data?.data?.general),
              (this.technicalFaqs = response?.data?.data?.technical)
            )
          );
      } catch (e) {
        console.error(e);
      }
    },
  },
});
