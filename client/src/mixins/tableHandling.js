export default {
  data() {
    return {
      ids: [],
    };
  },

  methods: {
    defaultFormatter(row, column, value) {
      return value || "-";
    },

    selectionChange(rows) {
      this.ids = [];
      rows.forEach(({ id }) => this.ids.push(id));
    },
  },
};
