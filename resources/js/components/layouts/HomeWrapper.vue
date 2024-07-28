<template>
    <div class="loader-first load-intro notranslate">
        <div class="logo-intro d-flex align-items-center justify-content-center text-white">
            <span class="text-logo">N</span>
            <span class="text-logo">A</span>
            <span class="text-logo">M</span>
            <span class="text-logo space"></span>
            <span class="text-logo">A</span>
            <span class="text-logo">N</span>
            <span class="text-logo">H</span>
            <span class="text-logo space"></span>
            <span class="text-logo cus-color">S</span>
            <span class="text-logo cus-color">H</span>
            <span class="text-logo cus-color">O</span>
            <span class="text-logo cus-color">P</span>
        </div>
    </div>
    <div class="loader-overlay one"></div>
    <div class="loader-overlay two"></div>
    <div id="layout-wrapper">
        <div class="home-content">
            <div class="container-fluid">
                <div class="row">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import F from '@resources/js/utils/loading-first-module';

export default {
    components: {},
    data() {
        return {
            isFirstLoad: true,
        }
    },
    created() {
        if (!window.location.href.indexOf("/admin") > -1) {
            this.getSettingsPage('Home');
            this.getSettingsPage('About');
        }
    },
    methods: {
        loadFirst() {
            var e = this
                , t = document.querySelector(".load-intro")
                , n = (document.querySelector(".logo-intro"),
                    document.querySelectorAll(".text-logo"));
            setTimeout((function () {
                n.forEach((function (e, t) {
                    setTimeout((function () {
                        e.classList.add("active")
                    }
                    ), 250 * (t + 1))
                }
                ))
            }
            )),
                setTimeout((function () {
                    n.forEach((function (e, t) {
                        setTimeout((function () {
                            e.classList.remove("active"),
                                e.classList.add("fade")
                        }
                        ), 50 * (t + 1))
                    }
                    ))
                }
                ), 3500),
                setTimeout((function () {
                    t.style.top = "-100vh",
                        e.changeLoadingFirst()
                }
                ), 4000)
            e.isFirstLoad = false
        },
        changeLoadingFirst() {
            F.setcookie.set("loading_first", "false", {
                expires: 1
            })
        },
        getCookieValue(cookieName) {
            var allCookies = document.cookie;
            var cookiesArray = allCookies.split(';');
            for (var i = 0; i < cookiesArray.length; i++) {
                var cookie = cookiesArray[i].trim();
                var parts = cookie.split('=');
                var key = parts[0];
                var value = parts[1];
                if (key === cookieName) {
                    return value;
                }
            }
            return null;
        },
        useCookieValue() {
            var addCookieValue = this.getCookieValue('loading_first');
            if (addCookieValue !== null) {
                var loader_first = document.querySelector('.loader-first');
                loader_first.classList.add(addCookieValue);
            }
        },
        getSettingsPage(page) {
            this.axios
                .get("/api/settings-page", {
                    params: { page: page }
                })
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        switch (page) {
                            case ('Home'):
                                this.setHomePageSettings(response.data.data);
                                break;
                            case ('About'):
                                this.setAboutPageSettings(response.data.data);
                                break;
                        }
                        if (localStorage.getItem('is_loaded_cf') === null) {
                            localStorage.setItem('is_loaded_cf', 'loaded');
                            window.location.reload();
                        } else {
                            this.loadFirst();
                            if (this.isFirstLoad === false) {
                                this.useCookieValue();
                            }
                        }
                    }
                })
                .catch((error) => {
                    if (error.response.status === 403) {
                        this.logout();
                    }
                    if (error.response.status === 401) {
                        this.logout();
                    }
                });
        },
        setHomePageSettings(data) {
            data.forEach(item => {
                switch (item.name) {
                    case ('General'):
                        localStorage.setItem('general', JSON.stringify(item.data));
                        break;
                    case ('About Sec.'):
                        localStorage.setItem('about_sec', JSON.stringify(item.data));
                        break;
                    case ('Slide Sec.'):
                        localStorage.setItem('slide_sec', JSON.stringify(item.data));
                        break;
                    case ('News Sec.'):
                        localStorage.setItem('news_sec', JSON.stringify(item.data));
                        break;
                    case ('Products Sec.'):
                        localStorage.setItem('products_sec', JSON.stringify(item.data));
                        break;
                    case ('Global Teams Sec.'):
                        localStorage.setItem('global_teams_sec', JSON.stringify(item.data));
                        break;
                }
            });
        },
        setAboutPageSettings(data) {
            data.forEach(item => {
                switch (item.name) {
                    case ('Life Our Value Sec.'):
                        localStorage.setItem('life_our_value_sec', JSON.stringify(item.data));
                        break;
                    case ('Life With You Sec.'):
                        localStorage.setItem('life_with_you_sec', JSON.stringify(item.data));
                        break;
                    case ('Life How We Hire Sec.'):
                        localStorage.setItem('life_how_we_hire_sec', JSON.stringify(item.data));
                        break;
                }
            });
        },
    },
}
</script>
