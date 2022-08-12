<template>
  <div class="users">
    <div class="filter">
      <div class="filter_wrapper">
        <div class="filter_item d-flex">
          <el-input
            v-model="filter.lastName"
            placeholder="Фамилия"
            clearable
            size="small"
          ></el-input>

          <el-input
            v-model="filter.firstName"
            placeholder="Имя"
            clearable
            size="small"
          ></el-input>

          <el-input
            v-model="filter.patronymic"
            placeholder="Отчество"
            clearable
            size="small"
          ></el-input>

          <el-input
            v-model="filter.email"
            placeholder="Email"
            clearable
            size="small"
          ></el-input>

          <el-input
            v-model="filter.phone"
            placeholder="Номер телефона"
            clearable
            size="small"
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
        height="571px"
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
    </div>

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

    <transition name="el-fade-in-linear">
      <div class="control_panel" v-show="ids.length">
        <div class="control_panel__wrapper">
          <div class="item" @click="deleteUser">
            <i class="el-icon-close"></i><span>Удалить</span>
          </div>

          <div class="item">Действия</div>
        </div>
      </div>
    </transition>
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
        pageSizes: [10, 20, 50, 100, 200, 500],
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
        const data = await this.$http.get("/users", {
          page,
          perPage: this.params.perPage,
          ...removeEmptyProps(this.filter),
        });

        // this.users = data.users;
        data.users.forEach((user) => this.$set(this.users, user.id, user));
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
          "/users/transfer",
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

    async deleteUser() {
      try {
        await this.$confirm("Удалить выбранные элементы?", {
          confirmButtonText: "Да",
          cancelButtonText: "Подумаю",
          type: "warning",
        });
      } catch (e) {
        return;
      }

      try {
        this.isLoading = true;
        await this.$http.post("/users/delete", {
          id: this.ids.length == 1 ? this.ids[0] : this.ids,
        });

        if (this.ids.length) {
          this.ids.forEach((id) => this.$delete(this.users, id));
        } else this.$delete(this.users, this.ids[0]);
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
.filter,
.btn_group {
  margin: 2rem 0;
  padding: 0 1rem;
}
.filter_wrapper {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}
.filter_item,
.filter_item .el-input {
  margin-right: 0.5rem;
}
.control_panel {
  display: flex;
  align-items: center;
  padding: 0 1rem;
  min-height: 50px;
  background-color: var(--color-secondary);
  color: var(--color-font--secondary);
}

.control_panel__wrapper {
  display: flex;
}
.control_panel__wrapper .item {
  padding: 0 0.5rem;
  cursor: pointer;
}
.control_panel__wrapper .item i {
  margin-right: 0.3rem;
}
</style>
