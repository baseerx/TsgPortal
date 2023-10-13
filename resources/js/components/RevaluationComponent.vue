<template>
    <v-app>
        <v-container fluid>
            <v-card
                class="mx-auto v-card v-card--shaped v-sheet theme--light elevation-18"
            >
                <v-card-title class="bg-info" v-text="this.name">
                </v-card-title>
                <v-form @submit.prevent="submitRecord" id="check-login-form" ref="form">
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                                md="4">
                                <label for="assetcode">Asset Code</label>
                                <input type="text" id="assetcode" required class="form-control" v-model="form.assetcode">
                            </v-col>
                            <v-col
                                cols="12"
                                md="4">
                                <label for="bookvalue">Book value</label>
                                <input type="text" id="bookvalue" required class="form-control" v-model="form.bookvalue">
                            </v-col>
                            <v-col
                                cols="12"
                                md="4">
                                <label for="revaluated">Revaluated</label>
                                <input type="text" id="revaluated" required class="form-control" v-model="form.revaluated">
                            </v-col>
                        </v-row>
                    </v-container>
                    <v-row
                        justify="center"
                        no-gutters
                    >
                        <v-col cols="12" md="6" offset-md="4">
                            <v-btn color="primary" form="check-login-form" large outlined type="submit"
                                   v-text="btnName"></v-btn>
                        </v-col>
                    </v-row>
                </v-form>
                <v-spacer></v-spacer>
                <RevaluationTable :randno="passrandNo" @updaterecord="updateRecord"></RevaluationTable>
            </v-card>
        </v-container>
    </v-app>

</template>

<script>
    import RevaluationTable from "./RevaluationTable";
    import DatePick from 'vue-date-pick';
    import 'vue-date-pick/dist/vueDatePick.css';

    export default {
        components: {
            RevaluationTable,
            DatePick
        },
        data() {
            return {
                form: new Form({
                    assetcode: 0,
                    bookvalue: 0,
                    revaluated: 0
                }),
                name: "Revaluation",
                numberRules: [
                    v => !!v || 'Text is required',
                ],
                btnName: 'Submit',
                updateId: 0,
                passrandNo: 0,
                assetsData: {}
            }
        },
        mounted() {
            Fire.$on('updateTable', () => {
                this.passrandNo = Math.random();
            });

        },
        watch: {


        },
        computed: {

        },
        methods: {
            submitRecord(e) {
                e.preventDefault();
                this.$refs.form.validate();
                if (this.updateId > 0) {
                    this.form.put('api/revaluation/' + this.updateId)
                        .then(reponse => {
                            swal("Congratulations!", "Record Updated Successfully..", "success");
                            Fire.$emit('updateTable');
                            this.btnName = 'Submit';
                            this.form.reset()
                        })
                        .catch(error => swal("Failed!", "Record Updation Failed..", "error"))
                } else {
                    this.form.post('api/revaluation')
                        .then(response => {
                            swal('Congratulations!', 'Data Has Been Successfully Submitted..', 'success');
                            Fire.$emit('updateTable');
                            this.form.reset()
                        })
                        .catch(error => swal('Failed!', 'Data Has Been Successfully Submitted..', 'error'));
                }
            }
            ,
            updateRecord(id) {
                this.updateId = id;
                this.btnName = 'Update';
                axios.get('api/revaluation/' + id)
                    .then(response => this.form.fill(response.data))
                    .catch(error => swal('Failed!', 'Record Cant be fetched..', 'error'));
            }

        }

    }
</script>

<style scoped>

</style>
