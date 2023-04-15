<template>
  <div class="mentor w-2/5">
    <div>
      <h1>Mentors</h1>
      <p class="flex items-center">
        <span class="first">30</span>
        <span class="sec">+12%</span>
      </p>
    </div>
    <svg
      width="40"
      height="41"
      viewBox="0 0 40 41"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M20.0002 18.8333C23.6821 18.8333 26.6668 15.8486 26.6668 12.1667C26.6668 8.48477 23.6821 5.5 20.0002 5.5C16.3183 5.5 13.3335 8.48477 13.3335 12.1667C13.3335 15.8486 16.3183 18.8333 20.0002 18.8333Z"
        stroke="#058B94"
        stroke-width="4"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M6.6665 35.5V28.8333C6.6665 26.9923 8.15889 25.5 9.99984 25.5H29.9998C31.8408 25.5 33.3332 26.9923 33.3332 28.8333V35.5"
        stroke="#058B94"
        stroke-width="4"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped lang="scss">
.mentor {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-left: 15px;
  padding-right: 15px;
  background-color: var(--card-light);
  border-radius: 7px;
  cursor: pointer;

  &:hover {
    background-color: var(--card-light-hover);
  }

  h1 {
    font-size: 1.2rem;
    font-weight: 400;
    color: var(--text-dark);
  }

  .first {
    font-size: 1.3rem;
    font-weight: 600;
    margin-right: 8px;
  }
  .sec {
    font-size: 1rem;
    font-weight: 400;
    color: var(--text-inactive);
  }
}
</style>
