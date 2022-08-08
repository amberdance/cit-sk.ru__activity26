export const APP_TITLE = "Активный гражданин Ставропольского края";
export const APP_DESCRIPTION = () =>
  `Проект ${APP_TITLE} создан как площадка для проведения среди различных групп населения Ставропольского края голосований в электронной форме по вопросам развития.`;

export const VALIDATE_DEFAULT_ERROR = "Поле обязательно для заполнения";
export const PASSWORD_STRENGTH_TEXT =
  "Допускаются буквы латинского алфавита, состоящие минимум из 1 цифры, 3 букв в нижнем регистре, 1 буквы в верхнем регистре.";
export const CMS_PREFFIX_ROUTE = "/watchyourstep";

export const DESKTOP_MENU = [
  {
    label: "Опросы",
    link: "/polls",
  },
  {
    label: "Результаты",
    link: "/poll/results",
  },
  {
    label: "Контакты",
    link: "/contacts",
    scroll: "#footer",
  },
];

export const MOBILE_MENU = [
  {
    label: "Опросы",
    link: "/polls",
  },
  {
    label: "Результаты",
    link: "/poll/results",
  },
];

export const ADMIN_MENU = [
  {
    label: "Главная",
    link: CMS_PREFFIX_ROUTE,
  },

  {
    label: "Пользователи",
    link: CMS_PREFFIX_ROUTE + "/users",
  },

  {
    label: "Активный гражданин",
    link: CMS_PREFFIX_ROUTE + "/polls",
  },
];

export const FOOTER_LINKS = [
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
];

export const FOOTER_CONTACTS = {
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
};
