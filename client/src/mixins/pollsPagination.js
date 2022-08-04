import MainLayout from "@/components/layouts/MainLayout.vue";
import PostsListBase from "@/components/shared/PostsListBase";

export default {
  components: {
    MainLayout,
    PostsListBase,
  },

  data() {
    return {
      isLoading: false,
      polls: [],
      filter: "all",
      skeletonCount: 4,

      pagination: {
        currentPage: 1,
        perPage: 4,
        total: 0,
      },
    };
  },

  async created() {
    await this.paginate();
  },

  methods: {
    async paginate(showMore = false) {
      try {
        this.isLoading = true;

        const params = {
          perPage: this.pagination.perPage,
          filter: this.filter,
        };

        if (showMore) params.page = this.pagination.currentPage;

        const response = await this.$http.get("/polls", params);

        this.pagination.total = response.total;

        if (showMore) this.skeletonCount += response.data.length;

        this.pagination.currentPage = response.nextPageUrl
          ? response.nextPageUrl.match(/page=(.*\d)/)[1]
          : null;

        showMore
          ? response.data.forEach((poll) => this.polls.push(poll))
          : (this.polls = response.data);
      } catch (e) {
        this.$onError();
        console.error(e);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
