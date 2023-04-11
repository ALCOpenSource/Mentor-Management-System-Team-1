<template>
  <div>
    <div class="flex justify-between items-center mb-12">
      <div class="flex items-center">
        <v-avatar size="90px">
          <v-img
            src="https://cdn.vuetifyjs.com/images/john.jpg"
            alt="John"
          ></v-img>
        </v-avatar>
        <div class="ml-6">
          <div class="flex items-center">
            <h1 class="mr-2 text-xl font-semibold">Perculiar Umeh</h1>
            <svg
              width="30"
              height="30"
              viewBox="0 0 30 30"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <g clip-path="url(#clip0_7931_4687)">
                <path
                  d="M3.33333 4.16699C2.44928 4.16699 1.60143 4.51818 0.976311 5.1433C0.35119 5.76842 0 6.61627 0 7.50033L0 22.5003C0 23.3844 0.35119 24.2322 0.976311 24.8573C1.60143 25.4825 2.44928 25.8337 3.33333 25.8337H10V4.16699H3.33333Z"
                  fill="#009A49"
                />
                <path d="M10 4.16699H20V25.8337H10V4.16699Z" fill="#EEEEEE" />
                <path
                  d="M26.6667 4.16699H20V25.8337H26.6667C27.5507 25.8337 28.3986 25.4825 29.0237 24.8573C29.6488 24.2322 30 23.3844 30 22.5003V7.50033C30 6.61627 29.6488 5.76842 29.0237 5.1433C28.3986 4.51818 27.5507 4.16699 26.6667 4.16699V4.16699Z"
                  fill="#009A49"
                />
              </g>
              <defs>
                <clipPath id="clip0_7931_4687">
                  <rect width="30" height="30" fill="white" />
                </clipPath>
              </defs>
            </svg>
          </div>
          <p class="text-slate-500">Admin</p>
        </div>
      </div>
      <div>
        <PrimaryBtn title="Edit Profile" />
      </div>
    </div>
    <div class="card p-6">
      <h1 class="text-xl font-semibold mb-6">About</h1>
      <p class="sub-card">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent
        dignissim ut cursus purus efficitur et. Duis ac enim tellus. Phasellus
        pharetra metus, ut cursus purus efficitur et. Duis ac enim tellus.
        Phasellus eget tortor dapibus, laoreet mauris sed, dignissim lectus.
        Duis ac enim tellus. Phasellus pharetra metus, ut cursus purus efficitur
        et. Duis ac enim tellus. Phasellus eget tortor dapibus, laoreet mauris
        sed, dignissim lectus.
      </p>
      <div class="grid w-2/4 grid-cols-2 mb-6">
        <div class="flex items-center cursor-pointer">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M25 6.25H5C4.30964 6.25 3.75 6.80964 3.75 7.5V22.5C3.75 23.1904 4.30964 23.75 5 23.75H25C25.6904 23.75 26.25 23.1904 26.25 22.5V7.5C26.25 6.80964 25.6904 6.25 25 6.25Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M25 6.875L15 16.25L5 6.875"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">peculiah@andela.com</p>
        </div>
        <div class="flex items-center">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M7.54049 19.1091L15 27.5L22.4595 19.1091C28.1807 12.6735 23.6116 2.5 15 2.5C6.38835 2.5 1.81923 12.6735 7.54049 19.1091Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M15 16.25C17.0711 16.25 18.75 14.5711 18.75 12.5C18.75 10.4289 17.0711 8.75 15 8.75C12.9289 8.75 11.25 10.4289 11.25 12.5C11.25 14.5711 12.9289 16.25 15 16.25Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">Lagos, Nigeria</p>
        </div>
      </div>
      <div class="grid w-2/4 grid-cols-2">
        <div class="flex items-center cursor-pointer">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M3.75 15H27.5"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M15 2.75195C18.093 5.9083 20 10.2312 20 14.9995C20 19.7677 18.093 24.0906 15 27.2468"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M15 2.75195C11.907 5.9083 10 10.2312 10 14.9995C10 19.7677 11.907 24.0906 15 27.2468"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">www.peculiah.com</p>
        </div>
        <div class="flex items-center">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M3.75 7.5C3.75 6.11929 4.86929 5 6.25 5H23.75C25.1307 5 26.25 6.11929 26.25 7.5V25C26.25 26.3807 25.1307 27.5 23.75 27.5H6.25C4.86929 27.5 3.75 26.3807 3.75 25V7.5Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M3.75 12.5H26.25"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M20 2.5V7.5"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M10 2.5V7.5"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">Member since June 22, 2021</p>
        </div>
      </div>
      <h1 class="text-xl font-semibold mb-6 mt-10">Social</h1>
      <div class="grid w-2/4 gap-16 grid-cols-2 mb-6">
        <div class="flex items-center social-card">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M12 0C5.37 0 0 5.37 0 12C0 17.31 3.435 21.795 8.205 23.385C8.805 23.49 9.03 23.13 9.03 22.815C9.03 22.53 9.015 21.585 9.015 20.58C6 21.135 5.22 19.845 4.98 19.17C4.845 18.825 4.26 17.76 3.75 17.475C3.33 17.25 2.73 16.695 3.735 16.68C4.68 16.665 5.355 17.55 5.58 17.91C6.66 19.725 8.385 19.215 9.075 18.9C9.18 18.12 9.495 17.595 9.84 17.295C7.17 16.995 4.38 15.96 4.38 11.37C4.38 10.065 4.845 8.985 5.61 8.145C5.49 7.845 5.07 6.615 5.73 4.965C5.73 4.965 6.735 4.65 9.03 6.195C9.99 5.925 11.01 5.79 12.03 5.79C13.05 5.79 14.07 5.925 15.03 6.195C17.325 4.635 18.33 4.965 18.33 4.965C18.99 6.615 18.57 7.845 18.45 8.145C19.215 8.985 19.68 10.05 19.68 11.37C19.68 15.975 16.875 16.995 14.205 17.295C14.64 17.67 15.015 18.39 15.015 19.515C15.015 21.12 15 22.41 15 22.815C15 23.13 15.225 23.505 15.825 23.385C18.2072 22.5807 20.2772 21.0497 21.7437 19.0074C23.2101 16.965 23.9993 14.5143 24 12C24 5.37 18.63 0 12 0Z"
              fill="#4D4D4D"
            />
          </svg>
          <p class="ml-3">@peculiar.umeh</p>
        </div>
        <div class="flex items-center social-card">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M21.835 0.28125H2.16504C1.125 0.28125 0.28125 1.125 0.28125 2.16504V21.835C0.28125 22.875 1.125 23.7188 2.16504 23.7188H21.835C22.875 23.7188 23.7188 22.875 23.7188 21.835V2.16504C23.7188 1.125 22.875 0.28125 21.835 0.28125ZM21.835 21.8438C8.71582 21.8408 2.15625 21.8379 2.15625 21.835C2.15918 8.71582 2.16211 2.15625 2.16504 2.15625C15.2842 2.15918 21.8438 2.16211 21.8438 2.16504C21.8408 15.2842 21.8379 21.8438 21.835 21.8438ZM3.75586 9.06738H7.2334V20.2529H3.75586V9.06738ZM5.49609 7.53809C6.60645 7.53809 7.51172 6.63574 7.51172 5.52246C7.51172 5.25777 7.45958 4.99566 7.35829 4.75111C7.25699 4.50657 7.10852 4.28437 6.92136 4.0972C6.73419 3.91003 6.51199 3.76156 6.26744 3.66027C6.02289 3.55897 5.76079 3.50684 5.49609 3.50684C5.2314 3.50684 4.96929 3.55897 4.72475 3.66027C4.4802 3.76156 4.258 3.91003 4.07083 4.0972C3.88366 4.28437 3.73519 4.50657 3.6339 4.75111C3.5326 4.99566 3.48047 5.25777 3.48047 5.52246C3.47754 6.63574 4.37988 7.53809 5.49609 7.53809ZM12.8877 14.7188C12.8877 13.2598 13.166 11.8477 14.9736 11.8477C16.7549 11.8477 16.7812 13.5146 16.7812 14.8125V20.2529H20.2559V14.1182C20.2559 11.1064 19.6055 8.78906 16.0869 8.78906C14.3965 8.78906 13.2627 9.71777 12.7969 10.5967H12.75V9.06738H9.41309V20.2529H12.8877V14.7188Z"
              fill="#4D4D4D"
            />
          </svg>
          <p class="ml-3">@peculiar.umeh</p>
        </div>
      </div>
      <div class="grid w-2/4 gap-16 grid-cols-2">
        <div class="flex items-center social-card">
          <svg
            width="22"
            height="21"
            viewBox="0 0 22 21"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M21 2.00002C21 2.00002 20.3 4.10002 19 5.40002C20.6 15.4 9.6 22.7 1 17C3.2 17.1 5.4 16.4 7 15C2 13.5 -0.5 7.60002 2 3.00002C4.2 5.60002 7.6 7.10002 11 7.00002C10.1 2.80002 15 0.400023 18 3.20002C19.1 3.20002 21 2.00002 21 2.00002Z"
              stroke="#4D4D4D"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-3">@peculiar.umeh</p>
        </div>
        <div class="flex items-center social-card">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M7.465 1.066C8.638 1.012 9.012 1 12 1C14.988 1 15.362 1.013 16.534 1.066C17.706 1.119 18.506 1.306 19.206 1.577C19.939 1.854 20.604 2.287 21.154 2.847C21.714 3.396 22.146 4.06 22.422 4.794C22.694 5.494 22.88 6.294 22.934 7.464C22.988 8.639 23 9.013 23 12C23 14.988 22.987 15.362 22.934 16.535C22.881 17.705 22.694 18.505 22.422 19.205C22.146 19.9391 21.7133 20.6042 21.154 21.154C20.604 21.714 19.939 22.146 19.206 22.422C18.506 22.694 17.706 22.88 16.536 22.934C15.362 22.988 14.988 23 12 23C9.012 23 8.638 22.987 7.465 22.934C6.295 22.881 5.495 22.694 4.795 22.422C4.06092 22.146 3.39582 21.7133 2.846 21.154C2.28638 20.6047 1.85331 19.9399 1.577 19.206C1.306 18.506 1.12 17.706 1.066 16.536C1.012 15.361 1 14.987 1 12C1 9.012 1.013 8.638 1.066 7.466C1.119 6.294 1.306 5.494 1.577 4.794C1.85372 4.06008 2.28712 3.39531 2.847 2.846C3.39604 2.2865 4.06047 1.85344 4.794 1.577C5.494 1.306 6.294 1.12 7.464 1.066H7.465ZM16.445 3.046C15.285 2.993 14.937 2.982 12 2.982C9.063 2.982 8.715 2.993 7.555 3.046C6.482 3.095 5.9 3.274 5.512 3.425C4.999 3.625 4.632 3.862 4.247 4.247C3.88205 4.60205 3.60118 5.03428 3.425 5.512C3.274 5.9 3.095 6.482 3.046 7.555C2.993 8.715 2.982 9.063 2.982 12C2.982 14.937 2.993 15.285 3.046 16.445C3.095 17.518 3.274 18.1 3.425 18.488C3.601 18.965 3.882 19.398 4.247 19.753C4.602 20.118 5.035 20.399 5.512 20.575C5.9 20.726 6.482 20.905 7.555 20.954C8.715 21.007 9.062 21.018 12 21.018C14.938 21.018 15.285 21.007 16.445 20.954C17.518 20.905 18.1 20.726 18.488 20.575C19.001 20.375 19.368 20.138 19.753 19.753C20.118 19.398 20.399 18.965 20.575 18.488C20.726 18.1 20.905 17.518 20.954 16.445C21.007 15.285 21.018 14.937 21.018 12C21.018 9.063 21.007 8.715 20.954 7.555C20.905 6.482 20.726 5.9 20.575 5.512C20.375 4.999 20.138 4.632 19.753 4.247C19.3979 3.88207 18.9657 3.60121 18.488 3.425C18.1 3.274 17.518 3.095 16.445 3.046ZM10.595 15.391C11.3797 15.7176 12.2534 15.7617 13.0669 15.5157C13.8805 15.2697 14.5834 14.7489 15.0556 14.0422C15.5278 13.3356 15.7401 12.4869 15.656 11.6411C15.572 10.7953 15.197 10.005 14.595 9.405C14.2112 9.02148 13.7472 8.72781 13.2363 8.54515C12.7255 8.36248 12.1804 8.29536 11.6405 8.34862C11.1006 8.40187 10.5792 8.57418 10.1138 8.85313C9.64845 9.13208 9.25074 9.51074 8.9493 9.96185C8.64786 10.413 8.45019 10.9253 8.37052 11.462C8.29084 11.9986 8.33115 12.5463 8.48854 13.0655C8.64593 13.5847 8.91648 14.0626 9.28072 14.4647C9.64496 14.8668 10.0938 15.1832 10.595 15.391ZM8.002 8.002C8.52702 7.47697 9.15032 7.0605 9.8363 6.77636C10.5223 6.49222 11.2575 6.34597 12 6.34597C12.7425 6.34597 13.4777 6.49222 14.1637 6.77636C14.8497 7.0605 15.473 7.47697 15.998 8.002C16.523 8.52702 16.9395 9.15032 17.2236 9.8363C17.5078 10.5223 17.654 11.2575 17.654 12C17.654 12.7425 17.5078 13.4777 17.2236 14.1637C16.9395 14.8497 16.523 15.473 15.998 15.998C14.9377 17.0583 13.4995 17.654 12 17.654C10.5005 17.654 9.06234 17.0583 8.002 15.998C6.94166 14.9377 6.34597 13.4995 6.34597 12C6.34597 10.5005 6.94166 9.06234 8.002 8.002ZM18.908 7.188C19.0381 7.06527 19.1423 6.91768 19.2143 6.75397C19.2863 6.59027 19.3248 6.41377 19.3274 6.23493C19.33 6.05609 19.2967 5.87855 19.2295 5.71281C19.1622 5.54707 19.0624 5.39651 18.936 5.27004C18.8095 5.14357 18.6589 5.04376 18.4932 4.97652C18.3275 4.90928 18.1499 4.87598 17.9711 4.87858C17.7922 4.88119 17.6157 4.91965 17.452 4.9917C17.2883 5.06374 17.1407 5.1679 17.018 5.298C16.7793 5.55103 16.6486 5.88712 16.6537 6.23493C16.6588 6.58274 16.7992 6.91488 17.0452 7.16084C17.2911 7.40681 17.6233 7.54723 17.9711 7.5523C18.3189 7.55737 18.655 7.42669 18.908 7.188Z"
              fill="#4D4D4D"
            />
          </svg>
          <p class="ml-3">@peculiar.umeh</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
</script>

<style scoped lang="scss">
.card {
  border: 1.7px solid var(--border);
  border-radius: 10px;
  box-shadow: 0px 5px 5px rgba(241, 241, 241, 0.25);
  margin-bottom: 3rem;

  .sub-card {
    padding: 14px;
    border: 1px solid var(--card-light);
    background-color: var(--light-grid-background);
    color: #4d4d4d;
    margin-bottom: 2.5rem;
  }

  .social-card {
    color: #4d4d4d;
    font-weight: 600;
    border-radius: 5px;
    background-color: var(--card-light);
    font-size: 20px;
    padding: 8px 12px;

    &:hover {
      background-color: var(--card-light-hover);
      cursor: pointer;
    }
  }
}
</style>
