<template>
  <CmsLayout>
    <div class="users container">
      <el-table :data="users" v-loading="isLoading">
        <el-table-column label="ID" prop="id"></el-table-column>
        <el-table-column
          label="ID мобилизации"
          prop="associateId"
        ></el-table-column>
        <el-table-column label="Фамилия" prop="lastName"></el-table-column>
        <el-table-column label="Имя" prop="firstName"></el-table-column>
        <el-table-column label="Отчество" prop="patronymic"></el-table-column>
        <el-table-column
          label="Дата рождения"
          prop="birthday"
        ></el-table-column>
        <el-table-column label="Email" prop="email"></el-table-column>
        <el-table-column label="Адрес" prop="address"></el-table-column>
        <el-table-column label="Телефон" prop="phone"></el-table-column>
        <el-table-column label="Телефон подтвержден" width="120">
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
