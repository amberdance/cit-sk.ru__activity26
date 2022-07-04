<template>
  <div :class="$style.headerContent">
    <div :class="[$style.iconWrapper, 'd-flex align-center']">
      <router-link to="/">
        <img src="../../assets/logo_primary.webp" alt="logo_primary" />
      </router-link>
    </div>

    <div :class="[$style.authWrapper, 'd-flex align-center']">
      <router-link to="/auth">Вход</router-link>

      <el-divider direction="vertical" />

      <router-link to="/registration">Регистрация</router-link>
    </div>
  </div>
</template>

<style module>
.headerContent {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  align-items: center;
  color: var(--color-font--secondary);
  padding: 1rem;
}

.authWrapper {
  justify-content: center;
  background-color: #ffffff;
  border-radius: 50px;
  height: 45px;
  width: 180px;
}

.authWrapper a {
  color: var(--color-font--primary);
}
.authWrapper a:hover {
  color: var(--color-primary);
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
