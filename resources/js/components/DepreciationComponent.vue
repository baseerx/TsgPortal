<template>
    <v-app>
        <v-container fluid>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" v-text="this.name"></h4>
                </div>
                <div class="card-body">
                    <v-form @submit.prevent="submitRecord" id="check-login-form" ref="form">
                        <v-container>
                            <div class="row">
                                <div class="col-2 text-right">
                                    <label for="run">Run</label>
                                </div>
                                <div class="col-4">
                                    <input
                                        class="form-control"
                                        id="run"
                                        type="text"
                                        v-model="form.run">
                                </div>
                                <div class="col-2 text-right">
                                    <label for="rollback">Rollback</label>
                                </div>
                                <div class="col-4">
                                    <input id="rollback"
                                           class="form-control"
                                           required type="text"
                                           v-model="form.rollback" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 text-right">
                                    <label>Calender</label>
                                </div>
                                <div class="col-4">
                                    <date-pick
                                        :format="'YYYY-MM-DD HH:mm:ss'"
                                        :pickTime="true"
                                        class="form-control"
                                        v-model="form.calender"
                                    ></date-pick>
                                </div>
                            </div>
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
                    <DepreciationTable :randno="passrandNo" @updaterecord="updateRecord"></DepreciationTable>
                </div>
            </div>
        </v-container>
    </v-app>
</template>

<script>
    import DepreciationTable from "./DepreciationTable";
    import moment from 'moment';
    import DatePick from 'vue-date-pick';
    import 'vue-date-pick/dist/vueDatePick.css';

    export default {
        components: {
            DepreciationTable,
            DatePick
        },
        data() {
            return {
                form: new Form({
                    run: '',
                    rollback: '',
                    calender: moment().format("YYYY-MM-DD HH:mm:ss")
                }),
                name: "Depreciation Section",
                textFieldBlured: false,
                valid: false,
                textRules: [
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
        watch: {},
        methods: {
            submitRecord(e) {
                e.preventDefault();
                this.$refs.form.validate();
                if (this.updateId > 0) {
                    this.form.put('api/depreciation/' + this.updateId)
                        .then(reponse => {
                            swal("Congratulations!", "Record Updated Successfully..", "success");
                            Fire.$emit('updateTable');
                            this.btnName = 'Submit';
                            this.$refs.form.reset()
                        })
                        .catch(error => swal("Failed!", "Record Updation Failed..", "error"))
                } else {
                    this.form.post('api/depreciation')
                        .then(response => {
                            swal('Congratulations!', 'Data Has Been Successfully Submitted..', 'success');
                            Fire.$emit('updateTable');
                            this.$refs.form.reset()
                        })
                        .catch(error => swal('Failed!', 'Data Has Been Successfully Submitted..', 'error'));
                }
            },
            validTextField: function (email) {
                var re = /(.+)@(.+){2,}\.(.+){2,}/;
                return re.test(email.toLowerCase());
            },
            updateRecord(id) {
                this.updateId = id;
                this.btnName = 'Update';
                axios.get('api/depreciation/' + id)
                    .then(response => this.form.fill(response.data))
                    .catch(error => swal('Failed!', 'Record Cant be fetched..', 'error'));
            }
        }

    }
</script>

<style scoped>

</style>
