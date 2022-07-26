<template>
  <div class="container p-0">
    <el-skeleton animated>
      <template slot="template">
        <el-skeleton-item
          variant="text"
          style="padding: 1.9rem; margin-bottom: 1rem"
        />

        <div class="d-flex flex-column" style="padding: 0 1rem">
          <el-skeleton-item variant="text" class="mt-2" style="width: 70%" />
          <el-skeleton-item variant="text" class="mt-2" style="width: 30%" />
          <el-skeleton-item variant="text" class="mt-2" style="width: 40%" />
          <el-skeleton-item variant="text" class="mt-2" style="width: 50%" />
          <el-skeleton-item
            variant="image"
            style="width: 100%; height: 450px; margin-top: 1rem"
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
              class="skeleton_item d-flex align-center mt-2"
            >
              <el-skeleton-item variant="circle" style="margin-right: 0.5rem" />
              <el-skeleton-item variant="text" style="max-width: 25%" />
            </div>
          </div>
        </div>
      </template>
    </el-skeleton>
  </div>
</template>
