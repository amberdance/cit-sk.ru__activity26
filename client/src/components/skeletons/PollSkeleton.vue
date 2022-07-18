<template>
  <el-skeleton animated :class="$style.root">
    <template slot="template">
      <div class="d-flex align-center">
        <el-skeleton-item
          variant="text"
          style="padding: 1.9rem; margin-bottom: 1rem"
        />
      </div>

      <div class="d-flex flex-column" style="padding: 1rem">
        <el-skeleton-item
          variant="text"
          :class="$style.item"
          style="width: 70%"
        />
        <el-skeleton-item
          variant="text"
          :class="$style.item"
          style="width: 30%"
        />
        <el-skeleton-item
          variant="text"
          :class="$style.item"
          style="width: 40%"
        />
        <el-skeleton-item
          variant="text"
          :class="$style.item"
          style="width: 50%"
        />
        <el-skeleton-item
          variant="image"
          style="width: 100%; height: auto; min-height: 500px; margin-top: 1rem"
        />

        <div
          class="d-flex flex-column"
          style="margin: 1rem 0; padding: 0 1rem 1rem 1rem"
        >
          <el-skeleton-item
            variant="h1"
            style="font-size: 30px; margin: 1rem 0"
          />

          <div
            v-for="i in 4"
            :key="i"
            :class="[$style.item, 'd-flex align-center']"
          >
            <el-skeleton-item variant="circle" style="margin-right: 0.5rem" />
            <el-skeleton-item variant="text" style="max-width: 20%" />
          </div>
        </div>
      </div>
    </template>
  </el-skeleton>
</template>

<style module>
.root .item {
  margin-top: 0.5rem;
}
</style>
