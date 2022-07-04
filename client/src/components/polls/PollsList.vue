<template>
  <div :class="$style.pollsList">
    <h2 style="font-size: 40px">Опросы</h2>

    <div :class="$style.pollsWrapper">
      <div v-for="i in 3" :key="i" :class="$style.pollsWrapper">
        <div :class="$style.pollsCard">
          <div :class="$style.image"></div>

          <div :class="$style.meta">
            <div :class="$style.subtitle">Благоустройство</div>
            <div :class="$style.title">
              Бесплатные туалеты на каждом перекрестке
            </div>
            <div :class="$style.btn">
              <div class="btn_primary">Перейти</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="m-1">
      <a href="#">Показать еще</a>
    </div>
  </div>
</template>

<style module>
.pollsList {
  background-color: #9cacb5;
  color: var(--color-font--secondary);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.pollsWrapper {
  display: flex;
  justify-content: space-between;
}

.pollsCard {
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  color: var(--color-font--primary);
  max-width: 250px;
  min-height: 430px;
  margin-right: 20px;
}

.pollsCard,
.image {
  border-radius: 15px;
}
.meta {
  padding: 0 15px 15px 15px;
}
.image {
  height: 220px;
  background-image: url("https://всевдом24.рф/ssl/u/df/11f394ba4c11e7ab389fc6ad831b8f/-/ТУАЛЕТ.jpg");
  background-position: 50% 50%;
  background-repeat: no-repeat;
  background-size: cover;
  background-color: #ffffff;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.subtitle {
  color: #444444;
  margin: 1rem 0;
  font-weight: bold;
  font-size: 17px;
}

.title {
  font-size: 20px;
  margin-top: 5px;
}

.btn {
  display: block;
  text-align: center;
  margin-top: 25px;
}
</style>
