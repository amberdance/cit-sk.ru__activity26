<template>
  <div :class="$style.headerContent">
    <div :class="[$style.iconWrapper, 'd-flex align-center']">
      <div :class="$style.item">
        <router-link to="/">
          <img src="../../assets/logo_primary.webp" alt="logo_primary" />
        </router-link>
      </div>
    </div>

    <div :class="[$style.authWrapper, 'd-flex align-center']">
      <div :class="$style.item">
        <router-link to="/auth">Вход</router-link>
      </div>
      <el-divider direction="vertical" />

      <div :class="$style.item">
        <router-link to="/registration">Регистрация</router-link>
      </div>
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
}

.authWrapper {
  justify-content: center;
  background-color: #ffffff;
  border-radius: 50px;
  height: 45px;
  width: 180px;
}

.authWrapper a:hover {
  color: #0469ff;
  transition: 0.2s;
}

.iconWrapper {
  background-color: #ffffff;
  border-radius: 50px;
  padding: 0px 15px;
}

img {
  max-width: 45px !important;
}
</style>
