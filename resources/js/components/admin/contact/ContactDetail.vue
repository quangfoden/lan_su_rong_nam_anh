<template>
    <div class="add_partner">
        <div class="row">
            <div class="row d-flex justify-content-center">
                <div class="card-body">
                    <div class="col-md-8 offset-md-2 card show border border-0 p-4">
                        <h4 class="card-title text-center fs-4 mb-4">
                            Contact Detail
                        </h4>
                        <div class="row">
                            <div class="col-6">
                                <label class="font-weight-bold mb-0">Tên:</label>
                                <div>{{ data.name }}</div>
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold mb-0">Email:</label>
                                <div>{{ data.email }}</div>
                            </div>
                            <div class="col-6 mt-4">
                                <label class="font-weight-bold mb-0">Chủ đề:</label>
                                <div>{{ data.subject }}</div>
                            </div>
                            <div class="col-6 mt-4">
                                <label class="font-weight-bold mb-0">Đại chỉ IP:</label>
                                <div>{{ data.ip }}</div>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="font-weight-bold mb-0">Tin nhắn:</label>
                                <div>{{ data.message }}</div>
                            </div>
                            <div class="col-4 mt-4">
                                <label class="font-weight-bold mb-0">Trạng thái:</label>
                                <div v-if="[1, 2].includes(this.data.status)"
                                     class="badge badge-warning w-100 fs-6 p-2"><i
                                    class="fa fa-eye"></i> Đã đọc
                                </div>
                                <div v-else-if="this.data.status === 3" class="badge badge-success w-100 fs-6 p-2"><i
                                    class="fa fa-paper-plane"></i> Đâ phản hồi
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div v-if="[1, 2].includes(this.data.status)" class="col-4">
                                <a
                                    class="btn btn-primary text-white w-100 mt-2"
                                    :href="`mailto:${this.data.email}`"
                                >
                                    <i class="fa fa-paper-plane"></i> Phản hồi
                                </a>
                            </div>
                            <div class="col-4">
                                <a
                                    v-if="[1, 2].includes(this.data.status)"
                                    class="btn btn-success text-white w-100 mt-2"
                                    @click="changeStatus(3)"
                                >
                                    <i class="fas fa-sync-alt"></i> Đánh dấu là đã phản hồi
                                </a>
                                <a
                                    v-else-if="this.data.status === 3"
                                    class="btn btn-warning text-white w-100 mt-2"
                                    @click="changeStatus(2)"
                                >
                                    <i class="fas fa-sync-alt"></i> Đánh dấu là đã đọc
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapMutations, mapActions} from "vuex";

export default {
    data() {
        return {
            data: [],
            contactStatus: ''
        };
    },
    created() {
        this.getContact(this.$route.params.id);
    },
    methods: {
        ...mapActions(["logout"]),
        getContact(gameId) {
            this.axios
                .get(`/api/admin/contact-us/${gameId}`)
                .then((response) => {
                    if (response.data.status === 200) {
                        if (response.data.data) {
                            this.data = response.data.data;
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
        changeStatus(toStatus) {
            const swalLoading = this.$swal.fire({
                title: "",
                customClass: {
                    container: "bg-transparent",
                    popup: "bg-transparent",
                },
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    this.$swal.showLoading();
                },
            });
            this.axios
                .post(`/api/admin/contact-us/${this.data.id}/change-status`, {to_status: toStatus})
                .then((response) => {
                    if (response.data.status === 200 && response.data.success) {
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: this.$config.notificationTimer ?? 1000,
                        })
                        this.getContact(this.data.id);
                    } else if (response.data.status === 200 && !response.data.success) {
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: `Error ${response.data.message}`
                        });
                    }
                })
                .catch((error) => {
                    if (error.response.status === 403) {
                        this.logout();
                    }
                    if (error.response.status === 401) {
                        this.logout();
                    }
                    this.$swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: `Error ${error.response.status}: ${error.response.data.message}`,
                    });
                });
        }
    },
};
</script>
