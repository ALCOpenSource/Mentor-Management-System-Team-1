<template>
  <div class="active min-w-[190px] max-w-[200px] 2xl:min-w-[200px]">
    <div class="btn">
      <span>View</span>
    </div>
    <div class="flex mt-3 -ml-8 items-center">
      <h1 class="text-[55px] 2xl:text-[65px] font-semibold  mr-3">6</h1>
      <h2 class="text-[20px] 2xl:text-[22px] font-semibold 2xl:font-bold leading-[1]">
        Active <br />
        Programs
      </h2>
    </div>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped lang="scss">
.active {
  background-color: var(--card-dark);
  border-radius: 10px;
  padding: 5px;
  color: var(--light-grid-background);
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;

  &:hover {
    background-color: var(--card-dark-hover);
  }

  .btn {
    position: absolute;
    right: 12px;
    top: 12px;
    width: 57px;
    height: 25px;
    background-color: var(--light-grid-background);
    color: var(--card-dark);
    border: none;
    padding-top: 1px;
    text-align: center;
    border-radius: 5px;

    &:hover {
      cursor: pointer;
      background-color: var(--card-light-hover);

      span {
        text-decoration: underline;
      }
    }
  }
}
</style>
