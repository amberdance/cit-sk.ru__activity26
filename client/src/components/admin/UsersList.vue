<template>
  <CmsLayout>
    <div class="users">
      <div class="filter">
        <div class="filter_wrapper">
          <div class="filter_item">
            <el-switch
              v-model="params.isActive"
              active-text="Активные"
            ></el-switch>
          </div>

          <div class="filter_item">
            <el-switch
              v-model="params.isVerified"
              active-text="Телефон подтвержден"
            ></el-switch>
          </div>
        </div>
      </div>

      <div class="users_table">
        <el-table
          height="800px"
          empty-text="Нет данных"
          v-loading="isLoading"
          :default-sort="{ prop: 'id', order: 'descending' }"
          :data="users"
          :stripe="true"
          :border="true"
        >
          <el-table-column
            label="ID"
            prop="id"
            width="70"
            align="center"
            sortable
          ></el-table-column>

          <el-table-column
            label="ID мобилизации"
            prop="associateId"
            width="120"
            align="center"
          ></el-table-column>

          <el-table-column
            label="Создан"
            prop="createdAt"
            align="center"
            width="180"
          ></el-table-column>

          <el-table-column
            label="Дата рождения"
            prop="birthday"
            align="center"
            width="120"
          ></el-table-column>

          <el-table-column
            label="Фамилия"
            prop="lastName"
            align="center"
            width="180"
          ></el-table-column>

          <el-table-column
            label="Имя"
            prop="firstName"
            align="center"
            width="180"
          ></el-table-column>

          <el-table-column
            label="Отчество"
            prop="patronymic"
            align="center"
            width="180"
          ></el-table-column>

          <el-table-column
            label="Email"
            prop="email"
            align="center"
            width="180"
          ></el-table-column>

          <el-table-column label="Адрес" prop="address"></el-table-column>

          <el-table-column
            label="Телефон"
            prop="phone"
            align="center"
            width="180"
          ></el-table-column>

          <el-table-column
            label="Телефон подтвержден"
            width="120"
            align="center"
          >
            <template #default="{ row }">
              <span
                ><el-checkbox
                  v-model="row.isVerified"
                  :disabled="true"
                ></el-checkbox>
              </span>
            </template>
          </el-table-column>
        </el-table>

        <el-pagination
          class="pagination"
          background
          :total="pagination.total"
          :page-size="pagination.perPage"
          :page-count="pagination.totalPages"
          :current-page="pagination.currentPage"
          :page-sizes="params.pageSizes"
          layout="sizes, prev, pager, next, jumper, total"
          @prev-click="getUsers"
          @next-click="getUsers"
          @current-change="getUsers"
          @size-change="handleSizeChange"
        >
        </el-pagination>
      </div>
    </div>
  </CmsLayout>
</template>

<script>
import CmsLayout from "../layouts/CmsLayout.vue";

export default {
  components: { CmsLayout },

  data() {
    return {
      isLoading: false,
      users: [],
      pagination: {},
      params: {
        perPage: 50,
        pageSizes: [10, 50, 100, 200],
        isActive: true,
        isVerified: true,
      },
    };
  },

  async created() {
    await this.getUsers();
  },

  methods: {
    async getUsers(page = null) {
      try {
        this.isLoading = true;
        const data = await this.$http.get("/admin/users", {
          page,
          perPage: this.params.perPage,
        });

        this.users = data.users;
        this.pagination = data.pagination;
      } catch (e) {
        this.$onError("Не удалось получить список пользователей");
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },

    async handleSizeChange(size) {
      this.params.perPage = size;

      await this.getUsers();
    },
  },
};
</script>

<style scoped>
.users {
  padding: 1rem;
}
.filter {
  margin: 1rem 0;
  padding: 2rem 1rem;
  border: 1px dashed var(--color-divider);
}
.filter_wrapper {
  display: flex;
}
.filter_item {
  margin-right: 0.5rem;
}
.users_table {
}
</style>
