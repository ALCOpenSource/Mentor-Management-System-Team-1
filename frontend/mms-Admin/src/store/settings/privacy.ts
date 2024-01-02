import { defineStore } from "pinia";
import axios from "axios";

interface PrivacyState {
  show_contact_info: boolean;
  show_github: boolean;
  show_instagram: boolean;
  show_linkedin: boolean;
  show_twitter: boolean;
  show_modal: boolean;
}

export const usePrivacyStore = defineStore({
  id: "privacy",

  state: (): PrivacyState => {
    return {
      show_contact_info: false,
      show_github: false,
      show_instagram: false,
      show_linkedin: false,
      show_twitter: false,
      show_modal: false,
    };
  },

  actions: {
    async fetchPrivacy() {
      try {
        await axios.get("v1/user/preferences").then((response) => {
          this.show_contact_info = response?.data?.data?.show_contact_info;
          this.show_github = response?.data?.data?.show_github;
          this.show_instagram = response?.data?.data?.show_instagram;
          this.show_linkedin = response?.data?.data?.show_linkedin;
          this.show_twitter = response?.data?.data?.show_twitter;
        });
      } catch (e) {}
    },
    async updatePrivacy() {
      const preferences = {
        show_contact_info: this.show_contact_info,
        show_github: this.show_github,
        show_instagram: this.show_instagram,
        show_linkedin: this.show_linkedin,
        show_twitter: this.show_twitter,
      };

      try {
        await axios
          .patch("v1/user/preferences", {
            preferences,
          })
          .then((response) => {
            if (response?.status === 200) {
              this.show_contact_info = response?.data?.data?.show_contact_info;
              this.show_github = response?.data?.data?.show_github;
              this.show_instagram = response?.data?.data?.show_instagram;
              this.show_linkedin = response?.data?.data?.show_linkedin;
              this.show_twitter = response?.data?.data?.show_twitter;
              this.show_modal = true;
            }
          });
      } catch (e) {}
    },
  },
});
