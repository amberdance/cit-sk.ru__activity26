<template>
  <div class="users">
    <div class="filter">
      <div class="filter_wrapper">
        <div class="filter_item">
          <el-input
            v-model="filter.lastName"
            placeholder="Фамилия"
            clearable
          ></el-input>

          <el-input
            v-model="filter.firstName"
            placeholder="Имя"
            clearable
          ></el-input>

          <el-input
            v-model="filter.patronymic"
            placeholder="Отчество"
            clearable
          ></el-input>

          <el-input
            v-model="filter.email"
            placeholder="Email"
            clearable
          ></el-input>

          <el-input
            v-model="filter.phone"
            placeholder="Номер телефона"
            clearable
          ></el-input>
        </div>

        <div class="filter_item">
          <el-switch
            v-model="filter.isActive"
            active-text="Активные"
          ></el-switch>
        </div>

        <div class="filter_item">
          <el-switch
            v-model="filter.isVerified"
            active-text="Телефон подтвержден"
          ></el-switch>
        </div>
      </div>
    </div>

    <div class="btn_group">
      <el-button
        type="primary"
        style="max-width: 150px; white-space: break-spaces"
        @click="transferUsers"
        >Перенести всех неактивных пользователей</el-button
      >

      <el-button
        type="primary"
        style="max-width: 150px; white-space: break-spaces"
        @click="transferUsers($event, true)"
        >Объеденить неактивных пользователей</el-button
      >
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
        @selection-change="selectionChange"
      >
        <el-table-column align="center" type="selection" width="55" />

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
          width="200"
        ></el-table-column>

        <el-table-column label="Адрес" prop="address"></el-table-column>

        <el-table-column
          label="Телефон"
          prop="phone"
          align="center"
          width="180"
        ></el-table-column>

        <el-table-column label="Телефон подтвержден" width="120" align="center">
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
</template>

<script>
import tableHandling from "@/mixins/tableHandling";
import { removeEmptyProps } from "@/utils/common";

export default {
  mixins: [tableHandling],

  data() {
    return {
      isLoading: false,
      users: [],
      pagination: {},

      filter: {
        isActive: true,
        isVerified: true,
        firstName: "",
        lastName: "",
        patronymic: "",
        email: "",
        phone: "",
      },

      params: {
        perPage: 50,
        pageSizes: [10, 50, 100, 200],
      },
    };
  },

  watch: {
    filter: {
      handler() {
        this.debouncedWatch();
      },

      deep: true,
    },
  },

  async created() {
    await this.getUsers();
    this.debouncedWatch = _.debounce(() => this.getUsers(), 250);
  },

  beforeUnmount() {
    this.debouncedWatch.cancel();
  },

  methods: {
    async getUsers(page = null) {
      try {
        this.isLoading = true;
        const data = await this.$http.get("/admin/users", {
          page,
          perPage: this.params.perPage,
          ...removeEmptyProps(this.filter),
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

    async transferUsers(event, isMerge = false) {
      try {
        await this.$confirm(
          isMerge
            ? "Объеденить невалидных пользователей с остальными?"
            : "Данное действие переносит пользователей, не подвердивших смс кодом свой номер телефона в другую таблицу в БД. Это может занять более длительное время ожидания.Продолжить ?",
          {
            confirmButtonText: "Да",
            cancelButtonText: "Подумаю",
            type: "warning",
          }
        );
      } catch (e) {
        return;
      }

      try {
        this.isLoading = true;

        await this.$http.get(
          "/admin/users/transfer",
          isMerge ? { merge: true } : null
        );

        const data = await this.getUsers();
        this.users = data.users;
        this.pagination = data.pagination;
        this.$onSuccess();
      } catch (e) {
        this.$onError();
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.users {
  padding: 1rem;
}
.filter,
.btn_group {
  margin: 1rem 0;
  padding: 2rem 1rem;
  border: 1px dashed var(--color-divider);
}
.filter_wrapper {
  display: flex;
  align-items: center;
}
.filter_item,
::v-deep .filter_item .el-input {
  margin-right: 0.5rem;
}
</style>
