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
        <el-table-column label="Активен" width="100">
          <template #default="{ row }">
            <span
              ><el-checkbox
                v-model="row.isActive"
                :disabled="true"
              ></el-checkbox>
            </span>
          </template>
        </el-table-column>

        <el-table-column label="Привязка в мобилизации" width="150">
          <template #default="{ row }">
            <span
              ><el-checkbox
                v-model="row.isAssociated"
                :disabled="true"
              ></el-checkbox
            ></span>
          </template>
        </el-table-column>
      </el-table>
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
    };
  },

  async created() {
    try {
      this.isLoading = true;
      const { users } = await this.$http.get("/admin/users");
      this.users = users;
    } catch (e) {
      this.$onError("Не удалось получить список пользователей");
      console.error(e);
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
