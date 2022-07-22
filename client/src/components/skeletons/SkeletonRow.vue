<template>
  <div class="container">
    <el-skeleton animated :class="$style.root">
      <template slot="template">
        <div :class="[$style.wrapper, 'd-flex']">
          <div :class="$style.polls_card">
            <el-skeleton-item
              variant="image"
              class="rounded"
              style="width: 300px; height: 200px"
            />
            <div style="padding-top: 14px">
              <el-skeleton-item variant="h2" style="width: 60%" />
              <div
                style="
                  display: flex;
                  align-items: center;
                  justify-items: space-between;
                  margin-top: 16px;
                  height: 16px;
                "
              >
                <el-skeleton-item variant="h3" style="margin-right: 16px" />
              </div>
            </div>
          </div>

          <div :class="$style.polls_card">
            <el-skeleton-item
              variant="image"
              class="rounded"
              style="width: 300px; height: 200px"
            />
            <div style="padding-top: 14px">
              <el-skeleton-item variant="h2" style="width: 60%" />
              <div
                style="
                  display: flex;
                  align-items: center;
                  justify-items: space-between;
                  margin-top: 16px;
                  height: 16px;
                "
              >
                <el-skeleton-item variant="h3" style="margin-right: 16px" />
              </div>
            </div>
          </div>
          <div :class="$style.polls_card">
            <el-skeleton-item
              variant="image"
              class="rounded"
              style="width: 300px; height: 200px"
            />
            <div style="padding-top: 14px">
              <el-skeleton-item variant="h2" style="width: 60%" />
              <div
                style="
                  display: flex;
                  align-items: center;
                  justify-items: space-between;
                  margin-top: 16px;
                  height: 16px;
                "
              >
                <el-skeleton-item variant="h3" style="margin-right: 16px" />
              </div>
            </div>
          </div>
          <div :class="$style.polls_card">
            <el-skeleton-item
              variant="image"
              class="rounded"
              style="width: 300px; height: 200px"
            />
            <div style="padding-top: 14px">
              <el-skeleton-item variant="h2" style="width: 60%" />
              <div
                style="
                  display: flex;
                  align-items: center;
                  justify-items: space-between;
                  margin-top: 16px;
                  height: 16px;
                "
              >
                <el-skeleton-item variant="h3" style="margin-right: 16px" />
              </div>
            </div>
          </div>
        </div>
      </template>
    </el-skeleton>
  </div>
</template>

<style module>
.wrapper {
  padding: 1rem 0;
}

.polls_card {
  padding: 1rem;
  min-height: 90px;
}
</style>
