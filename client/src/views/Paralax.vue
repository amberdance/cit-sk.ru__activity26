<template>
  <kinesis-container class="parallax">
    <kinesis-element
      class="img clouds"
      tag="img"
      :src="require('@/assets/parallax-bg/clouds.png')"
      :strength="-10"
    />
    <kinesis-element
      class="img mountain left_mountain"
      tag="img"
      :src="require('@/assets/parallax-bg/left_mountains.png')"
      :strength="-10"
    />
    <kinesis-element
      class="img mountain right_mountain"
      tag="img"
      :src="require('@/assets/parallax-bg/right_mountains.png')"
      :strength="-10"
    />
    <kinesis-element
      class="img field"
      tag="img"
      :src="require('@/assets/parallax-bg/field.png')"
      :strength="-10"
    />
  </kinesis-container>
</template>
<script>
import { KinesisContainer, KinesisElement } from "vue-kinesis";

export default {
  components: {
    KinesisContainer,
    KinesisElement,
  },
};
</script>

<style scoped>
.parallax {
  position: absolute;
  top: -210px;
  right: 0;
}

.parallax .img {
  left: 0;
  right: 0;
  width: 100%;
  height: 100%;
}

.parallax .clouds {
  position: relative;
  height: 1000px;
}
.parallax .mountain {
  position: relative;
  height: 250px;
  width: 50%;
  top: -340px;
}
.parallax .field {
  position: absolute;
  top: 800px;
  height: 350px;
}
</style>
