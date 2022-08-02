<template>
  <div class="footer">
    <footer>
      <div class="container">
        <div class="row footer_content">
          <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="heading">Контакты</div>
            <div class="contacts_wrapper">
              <div
                class="contact_wrap"
                v-for="(value, prop) in contacts"
                :key="prop"
              >
                <div class="contact_item d-flex">
                  <div class="icon"><i :class="value.icon"></i></div>
                  <div>
                    <div class="label">{{ value.heading }}</div>
                    <div class="text">{{ value.title }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="heading">Полезные ссылки</div>
            <div class="links_wrapper">
              <a
                v-for="(item, i) in usefullLinks"
                :key="i"
                :href="item.link"
                class="link_item"
                target="_blank"
                >{{ item.label }}</a
              >
            </div>
          </div>
        </div>

        <div class="row pt-3 pb-3">
          <div class="col-6">{{ getYear() }}</div>

          <div class="col">
            <router-link to="/privacy-policy"
              >Политика конфиденциальности</router-link
            >
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { FOOTER_CONTACTS, FOOTER_LINKS } from "@/values";

export default {
  data() {
    return {
      contacts: FOOTER_CONTACTS,
      usefullLinks: FOOTER_LINKS,
    };
  },

  methods: {
    getYear() {
      const fullYear = new Date().getFullYear();
      return fullYear == 2022 ? "@ 2022" : `@ 2022 - ${fullYear}`;
    },
  },
};
</script>
<style scoped>
.footer {
  margin-top: 3rem;
  padding-top: 3rem;
  font-size: 16px;
  background-color: var(--color-primary);
}
footer,
.footer a {
  color: var(--color-font--secondary);
}
.footer .heading {
  font-size: 30px;
  font-weight: bold;
  margin-bottom: 1rem;
}

.footer_content .el-col {
  margin-bottom: 1rem;
}
.contact_item {
  margin-bottom: 1rem;
}
.contact_item .label {
  font-weight: bold;
  font-size: 20px;
}
.contact_item i {
  font-size: 35px;
  margin-right: 0.5rem;
}
.links_wrapper {
  max-width: 350px;
}

.links_wrapper .link_item {
  display: block;
  margin-bottom: 0.5rem;
}
.footer .year {
  padding: 2rem 0;
}
</style>
