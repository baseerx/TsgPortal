<template>
    <div :class="this.modalClass" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info text-left" v-text="this.name"></h5>
                    <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Do you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="delRec" class="btn btn-danger">Delete Record</button>
                    <button type="button" @click="closeModal" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['delflag'],
    data() {
        return {
            name: "Delete Record Confirmation",
            modalClass: "modal d-none"
        }
    },
    watch: {
        delflag: function (flag) {
            this.modalFunction(flag);
        }
    },
    methods: {
        modalFunction(flag) {
            if (flag)
                this.modalClass = "modal d-block";
            else
                this.closeModal();
        },
        closeModal() {
            this.modalClass = "modal d-none";
        },
        delRec() {
            this.$emit("deleteMe")
        }
    }
}
</script>

<style scoped>

</style>
