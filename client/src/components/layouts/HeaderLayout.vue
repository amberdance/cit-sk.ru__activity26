<template>
  <div :class="$style.headerContent">
    <div :class="[$style.iconWrapper, 'd-flex align-center']">
      <div :class="$style.item">icon1</div>
      <el-divider direction="vertical" />
      <div :class="$style.item">icon2</div>
    </div>

    <div :class="[$style.authWrapper, 'd-flex align-center']">
      <div :class="$style.item">Вход</div>
      <el-divider direction="vertical" />
      <div :class="$style.item">Регистрация</div>
    </div>
  </div>
</template>

<style module>
.headerContent {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  align-items: center;
  color: #ffffff;
  padding: 1rem;
  min-height: 30px;
}

.authWrapper {
}

.iconWrapper {
}
</style>
