export const APP_TITLE = "Активный гражданин Ставропольского края";
export const APP_DESCRIPTION = () =>
  `Проект ${APP_TITLE} создан как площадка для проведения среди различных групп населения Ставропольского края голосований в электронной форме по вопросам развития.`;

export const VALIDATE_DEFAULT_ERROR = "Поле обязательно для заполнения";

export const DESKTOP_MENU = [
  // {
  //   label: "Результаты",
  //   link: "/poll/results",
  // },
  {
    label: "Опросы",
    link: "/polls",
    scroll: "#polls",
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
    scroll: "#polls",
  },
];
