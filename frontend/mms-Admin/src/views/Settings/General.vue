<template>
  <div>
    <div class="flex items-center mb-8">
      <v-avatar size="90px">
        <v-img :src="userBio.profilePicture || 'https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png'" :alt="userBio.firstName"></v-img>
      </v-avatar>
      <div class="ml-6">
        <h1 class="mb-2 text-xl font-semibold">Set Profile Picture</h1>
        <UploadProfilePic @upload="getSrc" />
      </div>
    </div>
    <div>
      <v-row align="center">
        <v-col cols="2">
          <h1 class="font-semibold">Full Name</h1>
        </v-col>
        <v-col>
          <v-row>
            <v-col>
              <input
                v-model="userBio.firstName"
                class="input"
                type="text"
                placeholder="First Name"
              />
            </v-col>
            <v-col>
              <input
                v-model="userBio.lastName"
                class="input"
                type="text"
                placeholder="Last Name"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="2">
          <h1 class="pt-3 font-semibold">About</h1>
        </v-col>
        <v-col>
          <textarea
            v-model="userBio.about"
            class="input"
            placeholder="Your Bio"
            rows="4"
          ></textarea>
        </v-col>
      </v-row>
      <v-row align="center">
        <v-col cols="2">
          <h1 class="font-semibold">Website</h1>
        </v-col>
        <v-col>
          <input
            v-model="userBio.website"
            class="input"
            placeholder="www.example.com"
          />
        </v-col>
      </v-row>
      <v-row align="center">
        <v-col cols="2">
          <h1 class="font-semibold">Country</h1>
        </v-col>
        <v-col>
          <v-row align="center">
            <v-col cols="5" class="my-select">
              <select
              v-model="userBio.country" @change.prevent="onSelect" class="input" required>
                <option value="" hidden disabled>Select Country</option>
                <option v-for="country in locationStore.country"
              :key="country.code" :value="country.code">{{ country.name }} </option>
              </select>
              <span class="">
                <svg
                  width="25"
                  height="24"
                  viewBox="0 0 25 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M16.6666 10L12.4999 14L8.33325 10"
                    stroke="#808080"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </span>
            </v-col>
            <v-col cols="2"
              ><h1 class="font-semibold text-center">City</h1></v-col
            >
            <v-col cols="5" class="my-select">
              <select v-model="userBio.city" class="input">
                <option value="" hidden disabled>Select City</option>
                <option v-for="city in locationStore.city"
              :key="city.code" :value="city.name">{{ city.name }}</option>
              </select>
              <span class="">
                <svg
                  width="25"
                  height="24"
                  viewBox="0 0 25 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M16.6666 10L12.4999 14L8.33325 10"
                    stroke="#808080"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </span>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="2">
          <h1 class="pt-1 font-semibold">Social</h1>
        </v-col>
        <v-col cols="10">
          <v-row justify="space-between">
            <v-col class="mr-6">
              <v-row no-gutters>
                <v-col cols="12" class="gits mb-3">
                  <span>
                    <GitHub />
                    GitHub
                  </span>
                  <input
                    v-model="userBio.github"
                    type="text"
                    placeholder="@githubuser"
                  />
                </v-col>
                <v-col cols="12" class="gits">
                  <span>
                    <LinkedIn />
                    LinkedIn
                  </span>
                  <input
                    v-model="userBio.linkedin"
                    type="text"
                    placeholder="@linkdeinbuser"
                  />
                </v-col>
              </v-row>
            </v-col>
            <v-col class="ml-6">
              <v-row no-gutters>
                <v-col cols="12" class="gits mb-3">
                  <span>
                    <Instagram />
                    Instagram
                  </span>
                  <input
                    v-model="userBio.instagram"
                    type="text"
                    placeholder="@instagramuser"
                  />
                </v-col>
                <v-col cols="12" class="gits">
                  <span>
                    <Twitter />
                    Twitter
                  </span>
                  <input
                    v-model="userBio.twitter"
                    type="text"
                    placeholder="@twitterbuser"
                  />
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <div class="w-[175px] float-right mt-8 mb-4">
        <PrimaryBtn title="Save Changes" @click="handleSubmit" />
      </div>
    </div>
    <Modal
      title="Profile Saved Successfully"
      :src="profileSuccess"
      :is-modal-open="isModalOpen"
      primary-text="Done"
      @toggle-modal="toggleModal"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, watch, computed } from "vue";
import { storeToRefs } from 'pinia'
import LinkedIn from "../../assets/icons/LinkedIn.vue";
import Twitter from "../../assets/icons/Twitter.vue";
import Instagram from "../../assets/icons/Instagram.vue";
import GitHub from "../../assets/icons/GitHub.vue";
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import UploadProfilePic from "../../components/Settings/UploadProfilePic.vue";
import Modal from "../../components/Forms/Modal.vue";
import { profileSuccess } from "../../assets/images";
import {useUserStore} from "../../store/user"
import {useLocationStore} from "../../store/location"

const userStore = useUserStore();
const locationStore = useLocationStore();
const { city, country } = storeToRefs(locationStore)
//let path = null

const isModalOpen = ref(false);
const userBio = ref({
  firstName: userStore.user?.first_name,
  lastName: userStore.user?.last_name,
  city: userStore.user?.city,
  country: userStore.user?.country,
  website: userStore.user?.website?.my_website?.url,
  twitter: userStore.user?.social_links?.twitter_username?.name,
  instagram: userStore.user?.social_links?.instagram_username?.name,
  linkedin: userStore.user?.social_links?.linkedin_username?.name,
  github: userStore.user?.social_links?.github_username?.name,
  about: userStore.user?.about_me,
  profilePicture: userStore.avatar?.avatar_url,
});
//
const getSrc = async (file: File, src: string) => {
  if(userStore.avatar && userStore.avatar.avatar_url)
  {
    userBio.value.profilePicture = src
    //path = file
    await userStore.uploadAvatar(file);

  }
};

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleSubmit = async () => {
  // Handle the Form submission
  const response = await userStore.updateUser(userBio);
  
  if (response && response.data && response.data.success) {
    toggleModal();
    // Handle the success here, toggle modal
    return;
  }
};

const onSelect = async() => {
  // update select options if a new country is selected
  await locationStore.setCity(userBio.value.country);
}

const filteredCities = computed(() => {
  return locationStore.city?.filter((city: { code: string; }) => city.code === userBio.value.country);
});

watch(country, () => {
  // Reset selected city when the country changes
  userBio.value.city = "";
});

watch(filteredCities, () => {
  // Update select options when the cities for the current country change
  const select = document.querySelector(".my-select-city select");
  const options = select?.querySelectorAll("option");
  if (options) {
    for (let i = 0; i < options.length; i++) {
      const option = options[i];
      option.selected = option.value === userBio.value.city;
    }
  }
});


</script>
<script lang="ts">
import { defineComponent } from 'vue'

function getCountryCode(countryName: any, countries: any) {
  for (let key in countries) {
    if (countries[key].name === countryName) {
      return countries[key].code;
    }
  }
  return null; // country not found
}

export default defineComponent({
  beforeRouteEnter(to, from, next) {     
    const locationStore = useLocationStore(); 
    const userStore = useUserStore(); 
    if (locationStore.country && locationStore.city) {
      // The location state is already loaded, so proceed to General Settings
      next()
    } else {
      // The location state is not loaded yet, so wait for it before proceeding
      const country = userStore.user?.country_name || 'Afghanistan'
      locationStore.setCountry().then(() => {
        const countryCode = getCountryCode(country, locationStore.country);
        return locationStore.setCity(countryCode);
      }).then(() => {
        next();
      });
    }
  },
})
</script>


<style scoped lang="scss">
.input {
  border: 1.6px solid var(--border);
  border-radius: 5px;
  padding: 10px 15px;
  width: 100%;
  position: relative;
}

input:focus,
textarea:focus,
select:focus {
  outline: 2px solid var(--btn-primary);
}

.my-select {
  position: relative;

  span {
    position: absolute;
    right: 25px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 0;
    pointer-events: none;
  }
}

.gits {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 0;
  margin: 0;

  span,
  input {
    padding: 5px 10px;
    border: 1px solid var(--border);
  }
  input {
    width: 100%;
    border-radius: 0 5px 5px 0;
  }
  span {
    border-radius: 5px 0 0 5px;
    font-weight: 600;
    display: flex;
    align-items: center;
    min-width: 110px;
    gap: 5px;
  }
}
</style>
