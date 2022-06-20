<template>
  <div :class="$style.background">
    <div :class="$style.overlay"></div>
    <div :class="$style.content">
      <el-row>
        <el-col :xs="10" :md="12" :sm="10" :lg="5">
          <div :class="$style.heading">
            <h1>Уважаемые жители Ставропольского края!</h1>
            <div :class="$style.headingContent">
              <p>Предлагаем вам принять участие в беспрецендентном опросе</p>
              <div class="a-center">
                <el-button type="primary">Пройти опрос</el-button>
              </div>
            </div>
          </div>
        </el-col>

        <el-col :span="12">
          <router-view />
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<style module>
.background {
  background-image: url("../assets/bg.webp");
  background-position: 50% 50%;
  background-repeat: no-repeat;
  background-size: cover;
}
.overlay {
  background-color: #ffffff;
  height: 100%;
  opacity: 0.5;
  position: fixed;
  width: 100%;
}
.content {
  position: relative;
}

.heading {
  background-color: #259942cc;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  padding: 50px;
  border-right: 4px #ffffff solid;
  color: #ffffff;
}
.heading h1 {
  font-size: 30px;
}

.headingContent {
  font-size: 18px;
  padding: 1rem 0;
}

.headingContent button {
  border: none;
  color: #ffffff;
  padding: 1.5rem;
  width: 100%;
  font-weight: bold;
}
</style>
