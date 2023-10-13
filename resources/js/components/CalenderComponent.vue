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
                                <label for="year">Year</label>
                                <input type="text" id="year" required class="form-control" v-model="form.year">
                            </v-col>
                            <v-col
                                cols="12"
                                md="6">
                                <label for="period">Period</label>
                                <input type="text" id="period" required class="form-control" v-model="form.period">
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
                <CalenderTable :randno="passrandNo" @updaterecord="updateRecord"></CalenderTable>
            </v-card>
        </v-container>
    </v-app>

</template>

<script>

    import CalenderTable from "./CalenderTable";

    export default {
        components:{
          CalenderTable
        },
        data() {
            return {
                form: new Form({
                    year: '',
                    period: '',
                }),
                name: "Add Calender Data..",
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
                    this.form.put('api/calender/' + this.updateId)
                        .then(reponse => {
                            swal("Congratulations!", "Record Updated Successfully..", "success");
                            Fire.$emit('updateTable');
                            this.btnName = 'Submit';
                            this.form.reset()
                        })
                        .catch(error => swal("Failed!", "Record Updation Failed..", "error"))
                } else {
                    this.form.post('api/calender')
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
                axios.get('api/calender/' + id)
                    .then(response => this.form.fill(response.data))
                    .catch(error => swal('Failed!', 'Record Cant be fetched..', 'error'));
            }

        }

    }
</script>

<style scoped>

</style>
