<template>
  <div class="container">
    <el-skeleton animated>
      <template slot="template">
        <div class="row">
          <div
            v-for="i in 4"
            :key="i"
            class="col-lg-3 col-md-6 col-sm-6 col-xs-12 skeleton_item"
          >
            <el-skeleton-item variant="image" class="image rounded" />

            <div class="meta">
              <el-skeleton-item variant="text" style="width: 60%" />
              <el-skeleton-item variant="text" />
            </div>
          </div>
        </div>
      </template>
    </el-skeleton>
  </div>
</template>

<style scoped>
.skeleton_item .image {
  height: 245px;
}

.skeleton_item .meta {
  padding: 1rem 0;
  height: 120px;
}
</style>
