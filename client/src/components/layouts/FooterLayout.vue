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
                  <div class="icon"><i class="value.icon"></i></div>
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

        <div class="year">{{ getYear() }}</div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contacts: {
        address: {
          heading: "Адрес",
          icon: "el-icon-location-outline",
          title: "350018 г. Краснодар, ул. Магистральная, 68",
        },

        phone: {
          heading: "Телефон",
          icon: "el-icon-phone-outline",
          title: "(861)260-62-31",
        },
      },

      usefullLinks: [
        {
          label: "Музеи Ставропольского края",
          link: "https://www.culture.ru/museums/institutes/location-stavropolskiy-kray",
        },
        {
          label:
            "Министерство туризма и оздоровительных курортов Ставропольского края",
          link: "http://mintourism26.ru/",
        },

        {
          label: "Министерство культуры Ставропольского края",
          link: "http://mincultsk.ru/",
        },
      ],
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
  font-size: 45px;
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
