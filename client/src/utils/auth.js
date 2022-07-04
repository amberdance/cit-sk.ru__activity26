export const auth = {
  loginUrl: `${process.env.VUE_APP_API_URL}/auth/login`,
  logoutUrl: `${process.env.VUE_APP_API_URL}/auth/logout`,

  async login(params) {
    try {
      const response = await this.http("POST", this.loginUrl, params);

      if ("error" in response) return Promise.reject(response);

      $cookies.set("access_token", response.data.token);

      return Promise.resolve(response);
    } catch (e) {
      return Promise.reject(e);
    }
  },

  async http(method, url, props) {
    const params = {
      method,
      mode: "cors",
      credentials: "omit",
      headers: {
        "Content-Type": "application/json",
      },
    };

    if (this.isAuthorized()) {
      params.headers.Authorization = `Bearer ${$cookies.get("access_token")}`;
    }

    if (props) params.body = JSON.stringify(props);

    const response = await fetch(url, params);

    if (response.status < 200 || response.status >= 300) {
      const error = new Error(`${response.status} ${response.statusText}`);
      error.config = { response };

      throw error;
    }

    if (url == this.loginUrl) return response.json();
  },

  logout() {
    try {
      this.http("GET", this.logoutUrl);
    } catch (e) {
      return;
    } finally {
      this.purge();
    }
  },

  isAuthorized() {
    return Boolean($cookies.get("access_token"));
  },

  purge() {
    $cookies.remove("access_token");
  },
};
