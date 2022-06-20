<template>
  <div :class="$style.footerContent">
    <div :class="$style.coockieText">
      Мы используем файлы cookie для улучшения работы сайта. Продолжая
      просматривать этот сайт, вы соглашаетесь с условиями использования
      cookie–файлов. Также сайт использует средство аналитики посещаемости
      пользователей "Яндекс.Метрика". С условиями использования сервиса
      Яндекс.Метрика и AppMetrica можно ознакомиться
      <el-link
        type="primary"
        href="https://yandex.ru/legal/metrica_termsofuse/"
        style="font-size: 16px"
        target="_blank"
        :underline="false"
        >здесь</el-link
      >
    </div>
    <el-button
      type="primary"
      @click="$emit('onCookieAccept')"
      style="margin: 0 0.5rem"
      >Понятно</el-button
    >
    <svg
      viewBox="0 0 1024 1024"
      xmlns="http://www.w3.org/2000/svg"
      data-v-78e17ca8=""
      :class="$style.btnClose"
      @click="$emit('onCookieAccept')"
    >
      <path
        fill="currentColor"
        d="M764.288 214.592 512 466.88 259.712 214.592a31.936 31.936 0 0 0-45.12 45.12L466.752 512 214.528 764.224a31.936 31.936 0 1 0 45.12 45.184L512 557.184l252.288 252.288a31.936 31.936 0 0 0 45.12-45.12L557.12 512.064l252.288-252.352a31.936 31.936 0 1 0-45.12-45.184z"
      ></path>
    </svg>
  </div>
</template>

<style module>
.footerContent {
  max-width: 1450px;
  margin: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}

.btnClose {
  color: #000000;
  height: 35px;
  width: 35px;
  cursor: pointer;
}
</style>
