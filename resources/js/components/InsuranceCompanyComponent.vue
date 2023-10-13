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
                                md="6">
                                <label for="name">Company Name</label>
                                <input type="text" id="name" required class="form-control" v-model="form.name">
                            </v-col>
                            <v-col
                                cols="12"
                                md="6">
                                <label>Validity</label>
                                <v-spacer></v-spacer>
                                <date-pick
                                    v-model="form.validity"
                                    class="text-bold font-weight-bolder form-control w-100"
                                    :pickTime="true"
                                    :format="'YYYY-MM-DD HH:mm'"
                                ></date-pick>
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
                <InsuranceComTable :randno="passrandNo" @updaterecord="updateRecord"></InsuranceComTable>
            </v-card>
        </v-container>
    </v-app>

</template>

<script>
    import DatePick from 'vue-date-pick';
    import 'vue-date-pick/dist/vueDatePick.css';
    import InsuranceComTable from "./InsuranceComTable";
    import moment from "moment";

    export default {
        components: {
            InsuranceComTable,
            DatePick
        },
        data() {
            return {
                form: new Form({
                    name: '',
                    validity: moment().format("YYYY-MM-DD HH:mm:ss"),
                }),
                name: "Add Insurance Company..",
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
        watch: {


        },
        computed: {
            computeVal()
            {
                this.form.gainloss=this.form.salevalue-this.form.bookvalue;
            }
        },
        methods: {
            submitRecord(e) {
                e.preventDefault();
                this.$refs.form.validate();
                if (this.updateId > 0) {
                    this.form.put('api/insurancecomp/' + this.updateId)
                        .then(reponse => {
                            swal("Congratulations!", "Record Updated Successfully..", "success");
                            Fire.$emit('updateTable');
                            this.btnName = 'Submit';
                            this.form.reset()
                        })
                        .catch(error => swal("Failed!", "Record Updation Failed..", "error"))
                } else {
                    this.form.post('api/insurancecomp')
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
                axios.get('api/insurancecomp/' + id)
                    .then(response => this.form.fill(response.data))
                    .catch(error => swal('Failed!', 'Record Cant be fetched..', 'error'));
            }

        }

    }
</script>

<style scoped>

</style>
