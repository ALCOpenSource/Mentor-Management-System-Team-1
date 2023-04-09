<template>
  <div class="active">
    <div class="btn">
      <span>View</span>
    </div>
    <div class="flex mt-5 ml-3 items-center">
      <h1>6</h1>
      <h2>
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
  padding: 7px;
  max-width: 210px;
  min-width: 210px;
  color: var(--light-grid-background);
  position: relative;

  &:hover {
    background-color: var(--card-dark-hover);
  }

  .btn {
    position: absolute;
    right: 12px;
    top: 12px;
    width: 60px;
    height: 27px;
    background-color: var(--light-grid-background);
    color: var(--card-dark);
    border: none;
    padding-top: 2px;
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

  h1 {
    padding: 0;
    margin: 0;
    font-size: 65px;
    font-weight: 600;
    margin-right: 15px;
    line-height: 1;
  }

  h2 {
    white-space: wrap;
    line-height: 1;
    font-weight: 700;
    font-size: 22px;
  }
}
</style>
